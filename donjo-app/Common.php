<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

/**
 * This function checks `manifest.json` from `FCPATH` . 'build', extracts the entire file and returns an array.
 *
 * @param string $file The file name to check.
 *
 * @return string The path to the file, or `null` if the file does not exist.
 */
function asset(string $file): string
{
    // Check if the manifest file exists.
    $manifest_path = FCPATH . 'build' . DIRECTORY_SEPARATOR . 'manifest.json';

    if (! file_exists($manifest_path)) {
        return '';
    }

    // Decode the JSON file.
    $manifest = json_decode(file_get_contents($manifest_path), true);

    // Check if the file exists in the manifest file.
    if (! isset($manifest[$file])) {
        return '';
    }

    // Return the path to the file.
    return base_url('build/' . $manifest[$file]['file']);
}
