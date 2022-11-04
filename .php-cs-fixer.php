<?php

declare(strict_types=1);

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use Nexus\CsConfig\FixerGenerator;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude(['donjo-app/Views', 'donjo-sys']);

$overrides = [];

$options = [
    'finder'       => $finder,
    'customFixers' => FixerGenerator::create('donjo-sys/nexusphp/cs-config/src/Fixer', 'Nexus\\CsConfig\\Fixer'),
];

return Factory::create(new CodeIgniter4(), $overrides, $options)->forProjects();
