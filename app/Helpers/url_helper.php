<?php

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string
 * as the word separator.
 *
 * @param string $str       Input string
 * @param string $separator Word separator (usually '-' or '_')
 * @param bool   $lowercase Whether to transform the output string to lowercase
 */
function url_title(string $str, string $separator = '-', bool $lowercase = false): string
{
    $qSeparator = preg_quote($separator);

    $trans = [
        '![^' . $qSeparator . '\pL\pM\pN\s]+!u' => '', // remove all chars are not the separator, letters, numbers, whitespace or another character (e.g. accents, umlauts, enclosing boxes, etc.)
        '![' . $qSeparator . '\s]+!u'           => $separator, // replace all separator chars with $separator
    ];

    // make all dashes/underscores into separator
    if ($separator === '-') {
        $str = str_replace('_', '-', $str);
    } elseif ($separator === '_') {
        $str = str_replace('-', '_', $str);
    }

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace($key, $val, $str);
    }

    if ($lowercase === true) {
        $str = mb_strtolower($str);
    }

    return trim(trim($str, $separator));
}
