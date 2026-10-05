<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CitizenRegistrationAndAccountTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected Resident $unregisteredResident;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();

        // Cari atau buat resident tanpa akun untuk pengujian
        $family = Family::first();
        $this->unregisteredResident = Resident::create([
            'family_id' => $family?->id,
            'nik' => '3201019901010001',
            'name' => 'Warga Uji Mandiri',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-05-20',
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
    }

    /**
     * Test public registration page is accessible.
     */
    public function test_public_registration_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Aktivasi Layanan Mandiri Warga');
        $response->assertSee('Identitas Kependudukan');
    }

    /**
     * Test citizen can self-register with matching NIK, No KK, and birth date.
     */
    public function test_citizen_can_self_register_with_valid_data(): void
    {
        $familyCardNumber = $this->unregisteredResident->family->family_card_number;

        $response = $this->post('/register', [
            'nik' => '3201019901010001',
            'family_card_number' => $familyCardNumber,
            'birth_date' => '1995-05-20',
            'email' => 'warga.uji@email.com',
            'phone' => '081234567899',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'consent' => '1',
        ]);

        $response->assertRedirect('/citizen/letters');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => '3201019901010001',
            'email' => 'warga.uji@email.com',
        ]);

        $user = User::where('username', '3201019901010001')->firstOrFail();
        $this->assertTrue($user->hasRole('warga'));
        $this->assertTrue(Hash::check('secret1234', $user->password));

        // Memastikan persetujuan PDP terekam dalam metadata
        $this->assertNotNull($user->metadata['pdp_consent'] ?? null);
        $this->assertTrue($user->metadata['pdp_consent']['agreed']);

        // Resident harus terhubung ke user
        $this->assertEquals($user->id, $this->unregisteredResident->fresh()->user_id);
    }

    /**
     * Test registration fails if PDP consent is not accepted.
     */
    public function test_registration_fails_if_pdp_consent_not_accepted(): void
    {
        $familyCardNumber = $this->unregisteredResident->family->family_card_number;

        $response = $this->post('/register', [
            'nik' => '3201019901010001',
            'family_card_number' => $familyCardNumber,
            'birth_date' => '1995-05-20',
            'email' => 'warga.uji@email.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            // Tanpa 'consent'
        ]);

        $response->assertSessionHasErrors('consent');
        $this->assertGuest();
    }

    /**
     * Test registration fails if NIK is not registered in village database.
     */
    public function test_registration_fails_if_nik_not_found(): void
    {
        $response = $this->post('/register', [
            'nik' => '9999999999999999',
            'family_card_number' => '3201011202150001',
            'birth_date' => '1995-05-20',
            'email' => 'unknown@email.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'consent' => '1',
        ]);

        $response->assertSessionHasErrors('nik');
        $this->assertGuest();
    }

    /**
     * Test registration fails if birth date does not match resident record.
     */
    public function test_registration_fails_if_birth_date_mismatch(): void
    {
        $familyCardNumber = $this->unregisteredResident->family->family_card_number;

        $response = $this->post('/register', [
            'nik' => '3201019901010001',
            'family_card_number' => $familyCardNumber,
            'birth_date' => '1990-01-01', // Salah
            'email' => 'warga.uji@email.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'consent' => '1',
        ]);

        $response->assertSessionHasErrors('birth_date');
        $this->assertGuest();
    }

    /**
     * Test registration fails if family card number does not match resident record.
     */
    public function test_registration_fails_if_family_card_number_mismatch(): void
    {
        $response = $this->post('/register', [
            'nik' => '3201019901010001',
            'family_card_number' => '9999999999999999', // Salah
            'birth_date' => '1995-05-20',
            'email' => 'warga.uji@email.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'consent' => '1',
        ]);

        $response->assertSessionHasErrors('family_card_number');
        $this->assertGuest();
    }

    /**
     * Test admin can create citizen account directly from resident show page.
     */
    public function test_admin_can_create_citizen_account_directly(): void
    {
        $resident = $this->unregisteredResident;

        $response = $this->actingAs($this->superadmin)
            ->post('/admin/residents/'.$resident->id.'/create-account', [
                'email' => 'direct.account@sidesa.id',
                'password' => 'desa123456',
            ]);

        $response->assertRedirect('/admin/residents/'.$resident->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => $resident->nik,
            'email' => 'direct.account@sidesa.id',
        ]);

        $user = User::where('username', $resident->nik)->firstOrFail();
        $this->assertTrue($user->hasRole('warga'));
        $this->assertEquals($user->id, $resident->fresh()->user_id);
    }
}
