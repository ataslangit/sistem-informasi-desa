<?php

declare(strict_types=1);

return [
    'min_php_version' => '8.1.0',

    'required_extensions' => [
        'pdo_mysql' => 'Driver Database MySQL PDO',
        'mbstring' => 'Multibyte String Extension',
        'openssl' => 'OpenSSL Security Extension',
        'tokenizer' => 'Tokenizer Extension',
        'xml' => 'XML Processing Extension',
        'curl' => 'cURL Extension',
        'fileinfo' => 'File Information Extension',
        'gd' => 'GD Image Processing Extension',
        'zip' => 'ZIP Archive Extension',
        'bcmath' => 'BCMath Arbitrary Precision',
    ],

    'writable_directories' => [
        'storage/app' => 'Penyimpanan Berkas Aplikasi',
        'storage/framework' => 'Penyimpanan Cache & Session Framework',
        'storage/logs' => 'Penyimpanan Log Sistem',
        'bootstrap/cache' => 'Penyimpanan Cache Bootstrap',
    ],
];
