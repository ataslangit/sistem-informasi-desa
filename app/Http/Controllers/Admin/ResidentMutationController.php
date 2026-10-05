<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Resident;
use App\Models\ResidentMutation;
use App\Services\ResidentMutationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResidentMutationController extends Controller
{
    public function __construct(
        protected ResidentMutationService $mutationService
    ) {}

    /**
     * Menampilkan riwayat log mutasi kependudukan.
     */
    public function index(Request $request): View
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');

        $mutations = ResidentMutation::with(['resident.family', 'creator'])
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('resident', function ($rq) use ($keyword) {
                    $rq->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nik', 'like', "%{$keyword}%");
                });
            })
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.mutations.index', compact('mutations', 'type', 'keyword'));
    }

    /**
     * Form pencatatan peristiwa mutasi penduduk.
     */
    public function create(Request $request): View
    {
        $type = $request->input('type', 'death');
        $residents = Resident::active()->select('id', 'nik', 'name')->orderBy('name')->get();
        $families = Family::select('id', 'family_card_number', 'address', 'rt', 'rw')->get();

        return view('admin.mutations.create', compact('type', 'residents', 'families'));
    }

    /**
     * Menyimpan data mutasi baru melalui ResidentMutationService.
     */
    public function store(Request $request): RedirectResponse
    {
        $type = $request->input('type');
        $userId = (int) auth()->id();

        if ($type === 'birth') {
            $validated = $request->validate([
                'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:residents,nik'],
                'family_id' => ['nullable', 'exists:families,id'],
                'name' => ['required', 'string', 'max:255'],
                'birth_place' => ['required', 'string', 'max:100'],
                'birth_date' => ['required', 'date', 'before_or_equal:today'],
                'gender' => ['required', 'in:L,P'],
                'blood_type' => ['nullable', 'string', 'max:5'],
                'religion' => ['required', 'string', 'max:30'],
                'father_name' => ['nullable', 'string', 'max:255'],
                'mother_name' => ['nullable', 'string', 'max:255'],
                'date' => ['required', 'date', 'before_or_equal:today'],
                'reference_number' => ['nullable', 'string', 'max:100'],
                'notes' => ['nullable', 'string'],
            ], [
                'nik.size' => 'NIK harus 16 digit angka.',
            ]);

            $residentData = [
                'nik' => $validated['nik'],
                'family_id' => $validated['family_id'] ?? null,
                'name' => $validated['name'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'blood_type' => $validated['blood_type'] ?? '-',
                'religion' => $validated['religion'],
                'marital_status' => 'Belum Kawin',
                'family_relationship_status' => 'Anak',
                'education_level' => 'Tidak/Belum Sekolah',
                'occupation' => 'Belum / Tidak Bekerja',
                'nationality' => 'WNI',
                'father_name' => $validated['father_name'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
            ];

            $mutationData = [
                'date' => $validated['date'],
                'reason' => 'Kelahiran baru',
                'notes' => $validated['notes'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
            ];

            $this->mutationService->recordBirth($residentData, $mutationData, $userId);

            return redirect()->route('admin.mutations.index')
                ->with('success', 'Peristiwa kelahiran berhasil dicatat dan penduduk baru ditambahkan ke sistem.');
        }

        if ($type === 'death') {
            $validated = $request->validate([
                'resident_id' => ['required', 'exists:residents,id'],
                'date' => ['required', 'date', 'before_or_equal:today'],
                'reason' => ['required', 'string', 'max:150'],
                'reference_number' => ['nullable', 'string', 'max:100'],
                'notes' => ['nullable', 'string'],
            ], [
                'resident_id.required' => 'Pilih warga yang dilaporkan meninggal dunia.',
                'reason.required' => 'Penyebab / keterangan kematian wajib diisi.',
            ]);

            $this->mutationService->recordDeath((int) $validated['resident_id'], $validated, $userId);

            return redirect()->route('admin.mutations.index')
                ->with('success', 'Peristiwa kematian berhasil dicatat dan status kependudukan diperbarui.');
        }

        if ($type === 'moved_out') {
            $validated = $request->validate([
                'resident_id' => ['required', 'exists:residents,id'],
                'date' => ['required', 'date'],
                'reason' => ['required', 'string', 'max:150'],
                'reference_number' => ['nullable', 'string', 'max:100'],
                'target_province' => ['nullable', 'string', 'max:100'],
                'target_regency' => ['nullable', 'string', 'max:100'],
                'target_district' => ['nullable', 'string', 'max:100'],
                'target_village' => ['nullable', 'string', 'max:100'],
                'target_address' => ['nullable', 'string', 'max:255'],
                'notes' => ['nullable', 'string'],
            ], [
                'resident_id.required' => 'Pilih warga yang pindah keluar.',
                'reason.required' => 'Alasan pindah domisili wajib diisi.',
            ]);

            $this->mutationService->recordMovedOut((int) $validated['resident_id'], $validated, $userId);

            return redirect()->route('admin.mutations.index')
                ->with('success', 'Peristiwa pindah keluar berhasil dicatat.');
        }

        return redirect()->route('admin.mutations.index')
            ->with('error', 'Tipe mutasi tidak dikenali.');
    }
}
