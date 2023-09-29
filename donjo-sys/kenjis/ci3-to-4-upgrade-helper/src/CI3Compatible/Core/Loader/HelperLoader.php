<?php

declare(strict_types=1);

/*
 * Copyright (c) 2021 Kenji Suzuki
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/kenjis/ci3-to-4-upgrade-helper
 */

namespace Kenjis\CI3Compatible\Core\Loader;

use Kenjis\CI3Compatible\Internal\DebugLog;

use function in_array;
use function is_array;

class HelperLoader
{
    /** @var string[] */
    private $autoloaded = ['url'];

    /** @var string[] */
    private $compatible = [
        'form',
        'captcha',
        'url',
    ];

    /** @var array<string, string> */
    private $helperMap = [
        // CI3 => CI4
        'string' => 'text',
    ];

    /** @var string[] List of loaded helpers */
    private $loadedHelpers = [];

    /**
     * Helper Loader
     *
     * @param   string|string[] $helpers Helper name(s)
     */
    public function load($helpers): void
    {
        if (is_array($helpers)) {
            $this->loadMultiple($helpers);

            return;
        }

        $helper = $helpers;
        $this->loadOne($helper);
    }

    private function loadOne(string $helper): void
    {
        if ($this->isLoaded($helper)) {
            return;
        }

        if ($this->loadAutoloadedHelper($helper)) {
            return;
        }

        $this->loadCompatibleHelper($helper);
        $this->loadCI4Helper($helper);
    }

    private function loadAutoloadedHelper(string $helper): bool
    {
        if (in_array($helper, $this->autoloaded, true)) {
            $this->loadCompatibleHelper($helper);

            return true;
        }

        return false;
    }

    private function loadMultiple(array $helpers): void
    {
        foreach ($helpers as $helper) {
            $this->loadOne($helper);
        }
    }

    /**
     * Load CI4 helper
     *
     * Returns bool for mocking this method.
     * Must be protected for mocking this method.
     */
    protected function loadCI4Helper(string $helper): bool
    {
        if (isset($this->helperMap[$helper])) {
            helper($this->helperMap[$helper]);
        } else {
            helper($helper);
            $this->loaded($helper);

            $message = 'Helper(CI4) "' . $helper . '" loaded';
            DebugLog::log(__METHOD__, $message);
        }

        return true;
    }

    private function loadCompatibleHelper(string $helper): void
    {
        if (in_array($helper, $this->compatible, true)) {
            require __DIR__ . '/../../Helper/' . $helper . '_helper.php';
            $this->loaded($helper);

            $message = 'Helper(CI3Compat) "' . $helper . '" loaded';
            DebugLog::log(__METHOD__, $message);
        }
    }

    private function loaded(string $helper)
    {
        $this->loadedHelpers[] = $helper;
    }

    private function isLoaded(string $helper): bool
    {
        if (in_array($helper, $this->loadedHelpers, true)) {
            return true;
        }

        return false;
    }
}
