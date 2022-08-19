<?php

declare(strict_types=1);

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use Nexus\CsConfig\FixerGenerator;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('docs')
    ->exclude('donjo-app/views')
    ->exclude('app/Views');

$overrides = [
    'no_extra_blank_lines' => ['tokens' => [
        'case',
        'curly_brace_block',
        'default',
        'extra',
        'square_brace_block',
        'switch',
        'use',
    ]],
];

$options = [
    'finder'       => $finder,
    'customFixers' => FixerGenerator::create('vendor/nexusphp/cs-config/src/Fixer', 'Nexus\\CsConfig\\Fixer'),
];

return Factory::create(new CodeIgniter4(), $overrides, $options)->forProjects();
