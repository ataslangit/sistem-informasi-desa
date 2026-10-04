<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Resident;
use App\Models\ResidentMutation;
use Illuminate\Support\Facades\DB;

class ResidentMutationService
{
    /**
     * Mencatat peristiwa kelahiran baru dan menambah data ke tabel penduduk.
     *
     * @param  array<string, mixed>  $residentData
     * @param  array<string, mixed>  $mutationData
     */
    public function recordBirth(array $residentData, array $mutationData, int $userId): Resident
    {
        return DB::transaction(function () use ($residentData, $mutationData, $userId) {
            $residentData['status'] = 'active';
            $resident = Resident::create($residentData);

            ResidentMutation::create([
                'resident_id' => $resident->id,
                'type' => 'birth',
                'date' => $mutationData['date'],
                'reason' => $mutationData['reason'] ?? 'Kelahiran baru',
                'notes' => $mutationData['notes'] ?? null,
                'reference_number' => $mutationData['reference_number'] ?? null,
                'created_by' => $userId,
            ]);

            return $resident;
        });
    }

    /**
     * Mencatat peristiwa kematian penduduk dan mengubah status menjadi 'deceased'.
     *
     * @param  array<string, mixed>  $mutationData
     */
    public function recordDeath(int $residentId, array $mutationData, int $userId): ResidentMutation
    {
        return DB::transaction(function () use ($residentId, $mutationData, $userId) {
            $resident = Resident::findOrFail($residentId);
            $resident->update(['status' => 'deceased']);

            // Jika penduduk adalah kepala keluarga, kosongkan status kepala keluarga di KK terkait
            if ($resident->family && (int) $resident->family->head_of_family_id === (int) $resident->id) {
                $resident->family->update(['head_of_family_id' => null]);
            }

            return ResidentMutation::create([
                'resident_id' => $resident->id,
                'type' => 'death',
                'date' => $mutationData['date'],
                'reason' => $mutationData['reason'] ?? 'Meninggal dunia',
                'notes' => $mutationData['notes'] ?? null,
                'reference_number' => $mutationData['reference_number'] ?? null,
                'created_by' => $userId,
            ]);
        });
    }

    /**
     * Mencatat penduduk pindah keluar dan mengubah status menjadi 'moved'.
     *
     * @param  array<string, mixed>  $mutationData
     */
    public function recordMovedOut(int $residentId, array $mutationData, int $userId): ResidentMutation
    {
        return DB::transaction(function () use ($residentId, $mutationData, $userId) {
            $resident = Resident::findOrFail($residentId);
            $resident->update(['status' => 'moved']);

            // Jika kepala keluarga pindah, kosongkan kepala keluarga di KK terkait
            if ($resident->family && (int) $resident->family->head_of_family_id === (int) $resident->id) {
                $resident->family->update(['head_of_family_id' => null]);
            }

            return ResidentMutation::create([
                'resident_id' => $resident->id,
                'type' => 'moved_out',
                'date' => $mutationData['date'],
                'reason' => $mutationData['reason'] ?? 'Pindah domisili keluar desa',
                'notes' => $mutationData['notes'] ?? null,
                'reference_number' => $mutationData['reference_number'] ?? null,
                'created_by' => $userId,
            ]);
        });
    }

    /**
     * Mencatat penduduk pindah datang dari luar desa.
     *
     * @param  array<string, mixed>  $residentData
     * @param  array<string, mixed>  $mutationData
     */
    public function recordMovedIn(array $residentData, array $mutationData, int $userId): Resident
    {
        return DB::transaction(function () use ($residentData, $mutationData, $userId) {
            $residentData['status'] = 'active';
            $resident = Resident::create($residentData);

            ResidentMutation::create([
                'resident_id' => $resident->id,
                'type' => 'moved_in',
                'date' => $mutationData['date'],
                'reason' => $mutationData['reason'] ?? 'Pindah datang masuk desa',
                'notes' => $mutationData['notes'] ?? null,
                'reference_number' => $mutationData['reference_number'] ?? null,
                'created_by' => $userId,
            ]);

            return $resident;
        });
    }
}
