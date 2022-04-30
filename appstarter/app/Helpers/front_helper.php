<?php

/**
 * Membuat link atau tag untuk `assets` pada tema
 * support untuk menampilkan tag ($asLink) hanya berlaku untuk
 * - gambar (jpg,jpeg,png,gif)
 * - css
 * - js
 *
 * @param string $path      link assets pada tema (dalam folder `assets` pada tema)
 * @param bool   $asLink    Atur true untuk menampilkan tag
 * @param mixed  $baseTheme
 */
function assets($path, $baseTheme = true, $asLink = false): string
{
    $pathTheme = 'themes/' . activeTheme() . '/';
    $url       = base_url(esc(($baseTheme ? $pathTheme : '') . $path));

    // detect type of file from $path
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    // if file is image
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
        return $asLink ? '<img src="' . $url . '" alt="' . $path . '" />' : $url;
    }

    // if file is css
    if ($ext === 'css') {
        return $asLink ? '<link type="text/css" href="' . $url . '" rel="Stylesheet" />' : $url;
    }

    // if file is js
    if ($ext === 'js') {
        return $asLink ? '<script src="' . $url . '"></script>' : $url;
    }

    return $url;
}

/**
 * Ambil tema yang aktif
 */
function activeTheme(): string
{
    return 'Default';
}

// make url with format 'year/month/day/slug' form date string and slug string
function makeUrl($date, $slug): string
{
    $date = date_create($date);

    return date_format($date, 'Y/m/d') . '/' . $slug;
}
