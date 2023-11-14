<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnExprInConstructRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::DEAD_CODE,
        LevelSetList::UP_TO_PHP_74,
        // PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        // PHPUnitSetList::PHPUNIT_100,
    ]);

    $rectorConfig->parallel();

    // The paths to refactor (can also be supplied with CLI arguments)
    $rectorConfig->paths([
        __DIR__ . '/donjo-app/',
        // __DIR__ . '/tests/',
    ]);

    $rectorConfig->skip([
        __DIR__ . '/donjo-app/third_party/',
        __DIR__ . '/donjo-app/Views/',
        JsonThrowOnErrorRector::class,
        RemoveUselessReturnExprInConstructRector::class,
    ]);

    // Include Composer's autoload - required for global execution, remove if running locally
    $rectorConfig->autoloadPaths([
        __DIR__ . '/donjo-sys/autoload.php',
    ]);

    // Set the target version for refactoring
    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    // Auto-import fully qualified class names
    $rectorConfig->importNames();
};
