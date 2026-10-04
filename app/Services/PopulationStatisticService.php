<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Family;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PopulationStatisticService
{
    /**
     * Mengambil ringkasan data kependudukan untuk dashboard.
     *
     * @return array<string, mixed>
     */
    public function getSummaryDashboard(): array
    {
        $totalResidents = Resident::active()->count();
        $totalMales = Resident::active()->where('gender', 'L')->count();
        $totalFemales = Resident::active()->where('gender', 'P')->count();
        $totalFamilies = Family::count();

        // Mutasi bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $birthsThisMonth = DB::table('resident_mutations')->where('type', 'birth')->where('date', '>=', $startOfMonth)->count();
        $deathsThisMonth = DB::table('resident_mutations')->where('type', 'death')->where('date', '>=', $startOfMonth)->count();
        $movedOutThisMonth = DB::table('resident_mutations')->where('type', 'moved_out')->where('date', '>=', $startOfMonth)->count();
        $movedInThisMonth = DB::table('resident_mutations')->where('type', 'moved_in')->where('date', '>=', $startOfMonth)->count();

        return [
            'total_residents' => $totalResidents,
            'total_males' => $totalMales,
            'total_females' => $totalFemales,
            'total_families' => $totalFamilies,
            'births_this_month' => $birthsThisMonth,
            'deaths_this_month' => $deathsThisMonth,
            'moved_out_this_month' => $movedOutThisMonth,
            'moved_in_this_month' => $movedInThisMonth,
        ];
    }

    /**
     * Statistik kelompok umur penduduk aktif.
     *
     * @return array<string, int>
     */
    public function getAgeGroupDistribution(): array
    {
        $residents = Resident::active()->select('birth_date')->get();

        $groups = [
            'Balita (0 - 4 tahun)' => 0,
            'Kanak-kanak (5 - 11 tahun)' => 0,
            'Remaja (12 - 25 tahun)' => 0,
            'Dewasa (26 - 59 tahun)' => 0,
            'Lansia (60+ tahun)' => 0,
        ];

        foreach ($residents as $resident) {
            $age = $resident->age;

            if ($age <= 4) {
                $groups['Balita (0 - 4 tahun)']++;
            } elseif ($age <= 11) {
                $groups['Kanak-kanak (5 - 11 tahun)']++;
            } elseif ($age <= 25) {
                $groups['Remaja (12 - 25 tahun)']++;
            } elseif ($age <= 59) {
                $groups['Dewasa (26 - 59 tahun)']++;
            } else {
                $groups['Lansia (60+ tahun)']++;
            }
        }

        return $groups;
    }

    /**
     * Statistik distribusi penduduk per pendidikan.
     *
     * @return array<string, int>
     */
    public function getEducationDistribution(): array
    {
        return Resident::active()
            ->select('education_level', DB::raw('count(*) as total'))
            ->groupBy('education_level')
            ->orderByDesc('total')
            ->pluck('total', 'education_level')
            ->toArray();
    }

    /**
     * Statistik distribusi penduduk per pekerjaan (Top 10).
     *
     * @return array<string, int>
     */
    public function getOccupationDistribution(): array
    {
        return Resident::active()
            ->select('occupation', DB::raw('count(*) as total'))
            ->groupBy('occupation')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'occupation')
            ->toArray();
    }

    /**
     * Statistik penduduk per dusun.
     *
     * @return array<string, int>
     */
    public function getHamletDistribution(): array
    {
        return DB::table('families')
            ->join('residents', 'families.id', '=', 'residents.family_id')
            ->where('residents.status', 'active')
            ->whereNull('residents.deleted_at')
            ->whereNull('families.deleted_at')
            ->select('families.hamlet', DB::raw('count(residents.id) as total'))
            ->whereNotNull('families.hamlet')
            ->groupBy('families.hamlet')
            ->orderByDesc('total')
            ->pluck('total', 'families.hamlet')
            ->toArray();
    }

    /**
     * Statistik status ekonomi keluarga.
     *
     * @return array<string, int>
     */
    public function getEconomicStatusDistribution(): array
    {
        return Family::select('economic_status', DB::raw('count(*) as total'))
            ->groupBy('economic_status')
            ->pluck('total', 'economic_status')
            ->toArray();
    }

    /**
     * Statistik agama penduduk.
     *
     * @return array<string, int>
     */
    public function getReligionDistribution(): array
    {
        return Resident::active()
            ->select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->orderByDesc('total')
            ->pluck('total', 'religion')
            ->toArray();
    }
}
