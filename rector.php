<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/donjo-app',
    ]);

    $rectorConfig->skip([
        __DIR__ . '/donjo-app/third_party',
        __DIR__ . '/donjo-app/Views',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        LevelSetList::UP_TO_PHP_80,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::NAMING,
        SetList::PHP_74,
        SetList::PHP_80,
    ]);
};
