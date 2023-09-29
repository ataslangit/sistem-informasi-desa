<?php

/**
 * Helper Functions
 */

declare(strict_types=1);

/**
 * @SuppressWarnings(PHPMD.ExitExpression)
 * Does not work if I move to the function annotation
 * See https://github.com/phpmd/phpmd/issues/337
 */
if (! function_exists('dd')) { // @codeCoverageIgnore

    /**
     * Alias of var_dump() and exit()
     *
     * @param mixed ...$vars
     *
     * @psalm-suppress ForbiddenCode Unsafe var_dump
     * @codeCoverageIgnore
     */
    function dd(...$vars): void
    {
        var_dump(...$vars);
        exit;
    }
}

if (! function_exists('d')) { // @codeCoverageIgnore

    /**
     * Alias of var_dump()
     *
     * @param mixed ...$vars
     *
     * @psalm-suppress ForbiddenCode Unsafe var_dump
     */
    function d(...$vars): void
    {
        var_dump(...$vars);
    }
}
