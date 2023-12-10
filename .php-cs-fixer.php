<?php

declare(strict_types=1);

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('donjo-sys')
    ->exclude('donjo-app/Views');

$overrides = [];

$options = [
    'finder'       => $finder,
];

return Factory::create(new CodeIgniter4(), $overrides, $options)->forProjects();
