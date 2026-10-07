<?php

declare(strict_types=1);

namespace App\Http\ViewComposers;

use App\Models\InformationObjection;
use App\Models\InformationRequest;
use App\Models\LetterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * Bind data pending counters to the view.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();

        if (! $user) {
            $view->with('pendingCounts', [
                'ppid_requests' => 0,
                'ppid_objections' => 0,
                'letters' => 0,
                'citizen_letters' => 0,
            ]);

            return;
        }

        try {
            $pendingCounts = [
                'ppid_requests' => 0,
                'ppid_objections' => 0,
                'letters' => 0,
                'citizen_letters' => 0,
            ];

            // 1. Keterbukaan Informasi (PPID) - Menunggu verifikasi permohonan & tinjauan keberatan
            if ($user->hasRole(['superadmin', 'kades', 'perangkat'])) {
                if (Schema::hasTable('information_requests')) {
                    $pendingCounts['ppid_requests'] = InformationRequest::where('status', 'submitted')->count();
                }

                if (Schema::hasTable('information_objections')) {
                    $pendingCounts['ppid_objections'] = InformationObjection::where('status', 'submitted')->count();
                }
            }

            // 2. Pelayanan Surat - Menunggu verifikasi / persetujuan / TTE sesuai role
            if ($user->hasRole(['superadmin', 'kades', 'perangkat', 'rt'])) {
                if (Schema::hasTable('letter_requests')) {
                    if ($user->hasRole('rt')) {
                        $query = LetterRequest::where('status', LetterRequest::STATUS_PENDING_RT);
                        if (! empty($user->metadata['rt'])) {
                            $userRt = (string) $user->metadata['rt'];
                            $query->whereHas('resident', function ($q) use ($userRt) {
                                $q->whereHas('family', fn ($fq) => $fq->where('rt', $userRt));
                            });
                        }
                        $pendingCounts['letters'] = $query->count();
                    } elseif ($user->hasRole('kades') && ! $user->hasRole('superadmin')) {
                        // Untuk Kepala Desa: utamakan surat yang menunggu persetujuan akhir & TTE Kades
                        $pendingCounts['letters'] = LetterRequest::where('status', LetterRequest::STATUS_PENDING_KADES)->count();
                    } else {
                        // Superadmin / Perangkat / Staf: seluruh surat yang memerlukan penanganan sistem
                        $pendingCounts['letters'] = LetterRequest::whereIn('status', [
                            LetterRequest::STATUS_PENDING_RT,
                            LetterRequest::STATUS_PENDING_STAFF,
                            LetterRequest::STATUS_PENDING_KADES,
                        ])->count();
                    }
                }
            }

            // 3. Layanan Mandiri Warga - Surat milik pemohon warga yang sedang diproses
            if ($user->hasRole('warga')) {
                if (Schema::hasTable('letter_requests')) {
                    $pendingCounts['citizen_letters'] = LetterRequest::where('user_id', $user->id)
                        ->whereIn('status', [
                            LetterRequest::STATUS_PENDING_RT,
                            LetterRequest::STATUS_PENDING_STAFF,
                            LetterRequest::STATUS_PENDING_KADES,
                        ])
                        ->count();
                }
            }

            $view->with('pendingCounts', $pendingCounts);
        } catch (\Throwable $e) {
            $view->with('pendingCounts', [
                'ppid_requests' => 0,
                'ppid_objections' => 0,
                'letters' => 0,
                'citizen_letters' => 0,
            ]);
        }
    }
}
