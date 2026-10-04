<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Family;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Ttpryg\AuditEngine\Services\AuditService;

class AuditEngineIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::where('email', 'admin@sidesa.id')->firstOrFail();
    }

    /**
     * Test AuditEngine service is bound in IoC container.
     */
    public function test_audit_engine_service_is_bound(): void
    {
        $this->assertTrue($this->app->bound(AuditService::class));
        $service = $this->app->make(AuditService::class);
        $this->assertInstanceOf(AuditService::class, $service);
    }

    /**
     * Test creating a resident automatically generates an audit log entry.
     */
    public function test_resident_creation_triggers_audit_log(): void
    {
        $this->actingAs($this->adminUser);

        $resident = Resident::create([
            'nik' => '3201019900000001',
            'name' => 'Warga Percobaan Audit',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-05-15',
            'gender' => 'L',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'S1',
            'occupation' => 'Karyawan Swasta',
            'nationality' => 'WNI',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'entity_type' => 'resident',
            'entity_id' => (string) $resident->id,
            'event_name' => 'ResidentCreated',
            'actor_id' => $this->adminUser->id,
        ]);

        $audit = AuditLog::where('entity_type', 'resident')
            ->where('entity_id', (string) $resident->id)
            ->where('event_name', 'ResidentCreated')
            ->first();

        $this->assertNotNull($audit);
        $this->assertEquals('Warga Percobaan Audit', $audit->new_values['name'] ?? null);
        $this->assertNull($audit->old_values);
    }

    /**
     * Test updating a family automatically generates an audit log entry with diff.
     */
    public function test_family_update_triggers_audit_log_with_diff(): void
    {
        $this->actingAs($this->adminUser);

        $family = Family::firstOrFail();
        $oldRt = $family->rt;
        $family->update([
            'rt' => '099',
            'hamlet' => 'Dusun Perubahan',
        ]);

        $audit = AuditLog::where('entity_type', 'family')
            ->where('entity_id', (string) $family->id)
            ->where('event_name', 'FamilyUpdated')
            ->latest('id')
            ->first();

        $this->assertNotNull($audit);
        $this->assertEquals($this->adminUser->id, $audit->actor_id);
        $this->assertEquals('099', $audit->new_values['rt'] ?? null);
        $this->assertEquals($oldRt, $audit->old_values['rt'] ?? null);
    }

    /**
     * Test admin can access audit logs list and filter.
     */
    public function test_admin_can_view_audit_logs_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/audit-logs');
        $response->assertStatus(200);
        $response->assertSee('Audit Trail');
    }

    /**
     * Test admin can view specific audit log details.
     */
    public function test_admin_can_view_audit_log_detail(): void
    {
        $this->actingAs($this->adminUser);

        $family = Family::firstOrFail();
        $family->update(['postal_code' => '99999']);

        $audit = AuditLog::where('entity_type', 'family')
            ->where('entity_id', (string) $family->id)
            ->latest('id')
            ->firstOrFail();

        $response = $this->actingAs($this->adminUser)->get("/admin/audit-logs/{$audit->id}");
        $response->assertStatus(200);
        $response->assertSee('Detail Audit Trail #'.$audit->id);
        $response->assertSee('postal_code');
        $response->assertSee('99999');
    }

    /**
     * Test unauthenticated users cannot access audit logs.
     */
    public function test_guest_cannot_access_audit_logs(): void
    {
        $response = $this->get('/admin/audit-logs');
        $response->assertRedirect('/login');
    }
}
