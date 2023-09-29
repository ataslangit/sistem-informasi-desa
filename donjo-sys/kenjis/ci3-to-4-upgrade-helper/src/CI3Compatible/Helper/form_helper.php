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

use Config\Services;
use Kenjis\CI3Compatible\Exception\NotSupportedException;

if (! function_exists('form_error')) {
    /**
     * Form Error
     *
     * Returns the error for a specific form field. This is a helper for the
     * form validation class.
     *
     * @param   string
     * @param   string
     * @param   string
     *
     * @return  string
     */
    function form_error($field = '', $prefix = '', $suffix = ''): string
    {
        if ($prefix !== '' || $suffix !== '') {
            throw new NotSupportedException(
                '$prefix and $suffix are not supported.'
                . ' Create custom views to display errors.'
                . ' See <https://github.com/kenjis/ci3-to-4-upgrade-helper/blob/1.x/docs/HowToUpgradeFromCI3ToCI4.md#form_validation>.'
            );
        }

        return Services::validation()->showError($field);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('validation_errors')) {
    /**
     * Validation Error String
     *
     * Returns all the errors associated with a form submission. This is a helper
     * function for the form validation class.
     *
     * @param   string
     * @param   string
     *
     * @return  string
     */
    function validation_errors($prefix = '', $suffix = ''): string
    {
        if ($prefix !== '' || $suffix !== '') {
            throw new NotSupportedException(
                '$prefix and $suffix are not supported.'
                . ' Create custom views to display errors.'
                . ' See <https://github.com/kenjis/ci3-to-4-upgrade-helper/blob/1.x/docs/HowToUpgradeFromCI3ToCI4.md#form_validation>.'
            );
        }

        return Services::validation()->listErrors();
    }
}
