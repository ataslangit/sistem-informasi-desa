<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PpidSettingController extends Controller
{
    /**
     * Formulir pengaturan struktur tim PPID Desa dan Maklumat Pelayanan Informasi.
     */
    public function index(): View
    {
        $settings = [
            'ppid_leader_name' => Setting::get('ppid_leader_name', 'Budi Santoso, S.Sos (Kepala Desa)'),
            'ppid_officer_name' => Setting::get('ppid_officer_name', 'Ahmad Hidayat, S.IP (Sekretaris Desa)'),
            'ppid_desk_officers' => Setting::get('ppid_desk_officers', "Kaur Umum & Tata Usaha\nKasi Pelayanan\nKasi Kesejahteraan"),
            'ppid_maklumat' => Setting::get('ppid_maklumat', 'Kami berjanji dan berkomitmen memberikan pelayanan informasi publik secara tepat waktu, mudah, dan proporsional sesuai UU No. 14 Tahun 2008 dan Perki No. 1 Tahun 2018 demi terwujudnya tata kelola pemerintahan desa yang terbuka dan akuntabel.'),
            'ppid_phone' => Setting::get('ppid_phone', '081234567890'),
            'ppid_email' => Setting::get('ppid_email', 'ppid@sidesa.id'),
            'ppid_service_hours' => Setting::get('ppid_service_hours', 'Senin - Kamis: 08.00 - 15.00 WIB, Jumat: 08.00 - 11.30 WIB'),
        ];

        return view('admin.ppid.settings.index', compact('settings'));
    }

    /**
     * Simpan pengaturan PPID Desa.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ppid_leader_name' => ['required', 'string', 'max:255'],
            'ppid_officer_name' => ['required', 'string', 'max:255'],
            'ppid_desk_officers' => ['required', 'string', 'max:2000'],
            'ppid_maklumat' => ['required', 'string', 'max:2000'],
            'ppid_phone' => ['required', 'string', 'max:50'],
            'ppid_email' => ['required', 'string', 'email', 'max:255'],
            'ppid_service_hours' => ['required', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'ppid', "Pengaturan PPID Desa: {$key}");
        }

        return back()->with('success', 'Pengaturan Struktur & Maklumat Pelayanan PPID Desa berhasil diperbarui.');
    }
}
