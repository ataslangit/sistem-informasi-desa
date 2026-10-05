<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Provider Tanda Tangan Elektronik (TTE) Aktif
    |--------------------------------------------------------------------------
    |
    | Pilihan provider Penyelenggara Sertifikasi Elektronik (PSrE):
    | - 'bsre_bssn'  : Balai Sertifikasi Elektronik - Badan Siber dan Sandi Negara
    | - 'peruri'     : Perum Peruri Digital Signature
    | - 'local'      : TTE Lokal / Standar Internal
    |
    */
    'default_provider' => env('TTE_DEFAULT_PROVIDER', 'bsre_bssn'),

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Integrasi BSrE BSSN
    |--------------------------------------------------------------------------
    |
    | Pengaturan koneksi API BSrE BSSN untuk instansi pemerintah desa.
    |
    */
    'bsre' => [
        'name' => 'Balai Sertifikasi Elektronik (BSrE)',
        'agency' => 'Badan Siber dan Sandi Negara (BSSN)',
        'issuer' => 'Balai Sertifikasi Elektronik (BSrE) - Badan Siber dan Sandi Negara (BSSN)',
        'endpoint_url' => env('TTE_BSRE_URL', 'https://bsre.bssn.go.id/api/sign/pdf'),
        'api_key' => env('TTE_BSRE_API_KEY', 'demo_bsre_api_key_sidesa'),
        'client_id' => env('TTE_BSRE_CLIENT_ID', 'sidesa-gov-id'),
        'passphrase' => env('TTE_BSRE_PASSPHRASE', 'secretPassphrase123'),
        'sandbox_mode' => (bool) env('TTE_BSRE_SANDBOX', true),
        'tsa_url' => env('TTE_BSRE_TSA_URL', 'https://tsa.bssn.go.id'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payung Hukum & Legalitas TTE
    |--------------------------------------------------------------------------
    |
    | Regulasi yang menjadi dasar keabsahan yuridis TTE dalam sistem ini.
    |
    */
    'regulations' => [
        'uu_ite' => 'UU No. 1 Tahun 2024 tentang Perubahan Kedua atas UU No. 11 Tahun 2008 tentang Informasi dan Transaksi Elektronik (Pasal 11)',
        'pp_pste' => 'PP No. 71 Tahun 2019 tentang Penyelenggaraan Sistem dan Transaksi Elektronik (Pasal 52-62)',
        'perpres' => 'Perpres No. 95 Tahun 2018 tentang Sistem Pemerintahan Berbasis Elektronik (SPBE)',
    ],
];
