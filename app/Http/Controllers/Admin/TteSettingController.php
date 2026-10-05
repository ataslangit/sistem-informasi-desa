<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TteSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan dan status sertifikasi TTE (PSrE / BSrE BSSN).
     */
    public function index(): View
    {
        $kadesUser = User::whereHas('roles', function ($q) {
            $q->where('name', 'kades');
        })->first();

        $settings = [
            'tte_provider' => Setting::get('tte_provider', Config::get('tte.default_provider', 'bsre_bssn')),
            'tte_bsre_url' => Setting::get('tte_bsre_url', Config::get('tte.bsre.endpoint_url')),
            'tte_bsre_client_id' => Setting::get('tte_bsre_client_id', Config::get('tte.bsre.client_id')),
            'tte_bsre_issuer' => Setting::get('tte_bsre_issuer', Config::get('tte.bsre.issuer')),
            'tte_sandbox_mode' => (bool) Setting::get('tte_sandbox_mode', Config::get('tte.bsre.sandbox_mode', true)),
        ];

        $regulations = Config::get('tte.regulations', []);

        return view('admin.tte_settings.index', compact('settings', 'kadesUser', 'regulations'));
    }

    /**
     * Perbarui konfigurasi TTE.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tte_provider' => ['required', 'in:bsre_bssn,peruri,local'],
            'tte_bsre_url' => ['required', 'url', 'max:255'],
            'tte_bsre_client_id' => ['required', 'string', 'max:100'],
            'tte_bsre_issuer' => ['required', 'string', 'max:255'],
            'tte_sandbox_mode' => ['nullable', 'boolean'],
        ]);

        Setting::set('tte_provider', $validated['tte_provider'], 'tte', 'Provider TTE Aktif');
        Setting::set('tte_bsre_url', $validated['tte_bsre_url'], 'tte', 'Endpoint API BSrE');
        Setting::set('tte_bsre_client_id', $validated['tte_bsre_client_id'], 'tte', 'Client ID BSrE');
        Setting::set('tte_bsre_issuer', $validated['tte_bsre_issuer'], 'tte', 'Penerbit Sertifikat BSrE');
        Setting::set('tte_sandbox_mode', $request->boolean('tte_sandbox_mode') ? '1' : '0', 'tte', 'Mode Sandbox BSrE');

        return redirect()->route('admin.tte-settings.index')
            ->with('success', 'Konfigurasi TTE Tersertifikasi (BSrE BSSN) berhasil diperbarui.');
    }
}
