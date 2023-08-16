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
        SetList::DEAD_CODE,
        LevelSetList::UP_TO_PHP_74,
    ]);
};
