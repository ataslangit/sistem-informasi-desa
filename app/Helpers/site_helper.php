<?php

/**
 * Membuat hash untuk password
 * Ini digunakan pada versi dari SID 3.10
 * Digunakan hanya untuk validasi password dengan format yang lama
 *
 * @param string $password Password string
 *
 * @return string
 *
 * @deprecated version 4.0.0
 */
function hash_password(string $password = '')
{
    $password = strrev($password);
    $password .= '!#@$#%';
    $password = md5($password);
    $password = substr($password, 3, 19);

    return md5($password);
}
