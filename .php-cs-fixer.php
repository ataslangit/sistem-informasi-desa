<?php

declare(strict_types=1);

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->files()
    ->in(__DIR__)
    ->exclude(['donjo-app/Views', 'donjo-sys', 'node_modules'])
    ->append([
        __FILE__,
        __DIR__ . '/rector.php',
    ]);

$overrides = [
    // 'declare_strict_types' => true,
    // 'void_return'          => true,
];

$options = [
    'finder'     => $finder,
    'usingCache' => false,
];

return Factory::create(new CodeIgniter4(), $overrides, $options)->forProjects();
