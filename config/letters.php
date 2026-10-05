<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Format Default Nomor Surat Resmi Desa
    |--------------------------------------------------------------------------
    |
    | Pola format penomoran surat resmi. Format ini digunakan sebagai default
    | jika jenis template surat tidak memiliki custom format tersendiri.
    |
    | Placeholder yang didukung:
    | - {nomor}         : Nomor urut berkas (sesuai panjang default padding)
    | - {nomor:X}       : Nomor urut dengan panjang X digit (cth: {nomor:3} -> 001)
    | - {kode}          : Kode template surat (cth: SKTM, SKCK, DOMISILI)
    | - {klasifikasi}   : Kode klasifikasi surat dinas (cth: 470)
    | - {bulan}         : Bulan 2 digit angka (cth: 01 - 12)
    | - {bulan_romawi}  : Bulan angka Romawi (cth: I, II, ..., X, XII)
    | - {tahun}         : Tahun 4 digit (cth: 2026)
    | - {desa}          : Singkatan / kode desa (cth: Ds)
    |
    */
    'default_number_format' => env('LETTER_DEFAULT_NUMBER_FORMAT', '{klasifikasi}/{nomor:3}/{kode}/Ds/{tahun}'),

    /*
    |--------------------------------------------------------------------------
    | Panjang Digit Padding Nomor Urut
    |--------------------------------------------------------------------------
    |
    | Jumlah digit padding angka nol untuk nomor urut jika {nomor} digunakan
    | tanpa parameter panjang digit.
    |
    */
    'number_padding' => (int) env('LETTER_NUMBER_PADDING', 3),

    /*
    |--------------------------------------------------------------------------
    | Pemetaan Kode Klasifikasi Surat Dinas
    |--------------------------------------------------------------------------
    |
    | Kode klasifikasi tata naskah dinas (Permendagri / Perbup) berdasarkan
    | kode jenis surat.
    |
    */
    'classification_codes' => [
        'SKTM' => '470',
        'DOMISILI' => '470',
        'SKCK' => '300',
        'SKU' => '510',
        'DEFAULT' => '470',
    ],
];
