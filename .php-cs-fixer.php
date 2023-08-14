<?php

declare(strict_types=1);

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude(['donjo-app/Views', 'donjo-sys', 'node_modules']);

$overrides = [];

$options = [
    'finder' => $finder,
];

return Factory::create(new CodeIgniter4(), $overrides, $options)->forProjects();
