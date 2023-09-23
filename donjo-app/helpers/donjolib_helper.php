<?php

use App\Models\Config;

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
    $manifest = json_decode(file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);

    // Check if the file exists in the manifest file.
    if (! isset($manifest[$file])) {
        return '';
    }

    // Return the path to the file.
    return base_url('build/' . $manifest[$file]['file']);
}

if (! function_exists('view')) {
    /**
     * fungsi view() untuk menggantikan $this->load->view()
     */
    function view(string $view, array $data = [], bool $return = false)
    {
        $CI = &get_instance();

        $CI->load->view($view, $data, $return);
    }
}

if (! function_exists('dd')) {
    /**
     * Dump & die
     *
     * @param mixed ...$args
     *
     * @return void
     */
    function dd(...$args)
    {
        if (ENVIRONMENT === 'development') {
            var_dump($args);

            exit;
        }
    }
}

// --------------------------------------------------------------------------

function Rpt($str = 0)
{
    $satuan  = ['', ' satu', ' dua', ' tiga', ' empat', ' lima', ' enam', ' tujuh', ' delapan', ' sembilan'];
    $belas   = ['', ' sebelas', ' duabelas', ' tigabelas', ' empatbelas', ' limabelas', ' enambelas', ' tujuhbelas', ' delapanbelas', ' sembilanbelas'];
    $lipatan = ['', '', 'puluh', 'ratus'];
    $i       = 0;
    $str .= '.00';
    $len  = strlen($str) - 3;
    $outp = '';
    // < 1000
    if ($len >= 13) {
        $isi = 0;

        while ($i < $len - 12) {
            if ($str[$i] === 1 && $len - $i === 14 && $str[$i + 1] !== 0) {
                $outp .= $belas[$str[$i + 1]];
                $i++;
                $isi = 1;
            } elseif ($str[$i] === 1 && ($i + 1 !== $len) && ($len - $i !== 13)) {
                $outp = $outp . ' se' . $lipatan[$len - ($i + 12)];
                $isi  = 1;
            } elseif ($str[$i] > 0) {
                $outp = $outp . $satuan[$str[$i]] . ' ' . $lipatan[$len - ($i + 12)];
                $isi  = 1;
            }
            $i++;
        }
        if ($isi === 1) {
            $outp .= ' triliyun';
        }
    }

    if ($len - $i >= 10) {
        $isi = 0;

        while ($i < $len - 9) {
            if ($str[$i] === 1 && $len - $i === 11 && $str[$i + 1] !== 0) {
                $outp .= $belas[$str[$i + 1]];
                $isi = 1;
                $i++;
            } elseif ($str[$i] === 1 && ($i + 1 !== $len) && ($len - $i !== 10)) {
                $outp = $outp . ' se' . $lipatan[$len - ($i + 9)];
                $isi  = 1;
            } elseif ($str[$i] > 0) {
                $outp = $outp . $satuan[$str[$i]] . ' ' . $lipatan[$len - ($i + 9)];
                $isi  = 1;
            }
            $i++;
        }
        if ($isi === 1) {
            $outp .= ' miliyar';
        }
    }

    if ($len - $i >= 7) {
        $isi = 0;

        while ($i < $len - 6) {
            if ($str[$i] === 1 && $len - $i === 8 && $str[$i + 1] !== 0) {
                $outp .= $belas[$str[$i + 1]];
                $i++;
                $isi = 1;
            } elseif ($str[$i] === 1 && ($i + 1 !== $len) && ($len - $i !== 7)) {
                $outp = $outp . ' se' . $lipatan[$len - ($i + 6)];
                $isi  = 1;
            } elseif ($str[$i] > 0) {
                $outp = $outp . $satuan[$str[$i]] . ' ' . $lipatan[$len - ($i + 6)];
                $isi  = 1;
            }
            $i++;
        }
        if ($isi === 1) {
            $outp .= ' juta';
        }
    }

    if ($len - $i >= 4) {
        $isi = 0;

        while ($i < $len - 3) {
            if ($str[$i] === 1 && $len - $i === 5 && $str[$i + 1] !== 0) {
                $outp .= $belas[$str[$i + 1]];
                $i++;
                $isi = 1;
            } elseif ($str[$i] === 1 && ($i + 1 !== $len)) {
                $outp = $outp . ' se' . $lipatan[$len - ($i + 3)];
                $isi  = 1;
            } elseif ($str[$i] > 0) {
                $outp = $outp . $satuan[$str[$i]] . ' ' . $lipatan[$len - ($i + 3)];
                $isi  = 1;
            }
            $i++;
        }
        if ($isi === 1) {
            $outp .= ' ribu';
        }
    }

    while ($i < $len) {
        if ($str[$i] === 1 && $len - $i === 2 && $str[$i + 1] !== 0) {
            $outp = $outp . $belas[$str[$i + 1]] . ' ';
            $i++;
        } elseif ($str[$i] === 1 && ($i + 1 !== $len)) {
            $outp = $outp . ' se' . $lipatan[$len - $i] . ' ';
        } else {
            if ($str[$i] > 0) {
                $outp = $outp . $satuan[$str[$i]] . ' ' . $lipatan[$len - $i];
            }
        }
        $i++;
    }
    $i++;
    $outp2 = '';
    $len += 3;

    while ($i < ($len)) {
        if ($str[$i] === 1 && $len - $i === 2 && $str[$i + 1] !== 0) {
            $outp2 = $outp2 . $belas[$str[$i + 1]] . ' ';
            $i++;
        } elseif ($str[$i] === 1 && ($i + 1 !== $len)) {
            $outp2 = $outp2 . ' se' . $lipatan[$len - $i] . ' ';
        } else {
            if ($str[$i] > 0) {
                $outp2 = $outp2 . $satuan[$str[$i]] . ' ' . $lipatan[$len - $i];
            }
        }
        $i++;
    }

    if ($outp2 !== '') {
        $outp = $outp . ' komah ' . $outp2;
    }
    $outp .= ' rupiah';
    $len  = strlen($outp);
    $outp = substr($outp, 1, $len - 1);

    return "{$outp}";
}

function Parse_Data($data, $p1, $p2)
{
    $data  = ' ' . $data;
    $hasil = '';
    $awal  = strpos($data, (string) $p1);
    $akhir = strpos(strstr($data, (string) $p1), (string) $p2);

    return substr($data, $awal + strlen($p1), $akhir - strlen($p1));
}
function Rupiah($nil = 0)
{
    $nil += 0;
    if (($nil * 100) % 100 === 0) {
        $nil .= '.00';
    } elseif (($nil * 100) % 10 === 0) {
        $nil .= '0';
    }
    $nil  = str_replace('.', ',', $nil);
    $str1 = $nil;
    $str2 = '';
    $dot  = '';
    $str  = strrev($str1);
    $arr  = str_split($str, 3);
    $i    = 0;

    foreach ($arr as $str) {
        $str2 = $str2 . $dot . $str;
        if (strlen($str) === 3 && $i > 0) {
            $dot = '.';
        }
        $i++;
    }
    $rp = strrev($str2);
    if ($rp === '') {
        return 'Rp. 0,00';
    }
    if ($rp <= 0) {
        return 'Rp. 0,00';
    }

    return "Rp. {$rp}";
}

function jecho($a, $b, $str)
{
    if ($a === $b) {
        echo $str;
    }
}
function selected($a, $b, $opt = 0)
{
    if ($a === $b) {
        if ($opt) {
            echo "checked='checked'";
        } else {
            echo "selected='selected'";
        }
    }
}
function rev_tgl($tgl)
{
    $ar = explode('-', $tgl);

    return $ar[2] . '-' . $ar[1] . '-' . $ar[0];
}
function penetration($str)
{
    return str_replace("'", '-', $str);
}

function unpenetration($str)
{
    return str_replace('-', "'", $str);
}
function spaceunpenetration($str)
{
    return str_replace('-', ' ', $str);
}
function underscore($str)
{
    return str_replace(' ', '_', $str);
}
function ununderscore($str)
{
    return str_replace('_', ' ', $str);
}
function bulan($bln)
{
    $nm = '';

    switch ($bln) {
        case '1':
            $nm = 'Januari';
            break;

        case '2':
            $nm = 'Februari';
            break;

        case '3':
            $nm = 'Maret';
            break;

        case '4':
            $nm = 'April';
            break;

        case '5':
            $nm = 'Mei';
            break;

        case '6':
            $nm = 'Juni';
            break;

        case '7':
            $nm = 'Juli';
            break;

        case '8':
            $nm = 'Agustus';
            break;

        case '9':
            $nm = 'September';
            break;

        case '10':
            $nm = 'Oktober';
            break;

        case '11':
            $nm = 'November';
            break;

        case '12':
            $nm = 'Desember';
            break;

        default:
            $nm = '';
            break;
    }

    return $nm;
}

function tgl_indo2($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $jam     = substr($tgl, 11, 8);
    $bulan   = getBulan(substr($tgl, 5, 2));
    $tahun   = substr($tgl, 0, 4);

    return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam . ' WIB';
}
function tgl_indo($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan   = getBulan(substr($tgl, 5, 2));
    $tahun   = substr($tgl, 0, 4);

    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function tgl_indo_out($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan   = substr($tgl, 5, 2);
    $tahun   = substr($tgl, 0, 4);

    return $tanggal . '-' . $bulan . '-' . $tahun;
}
function tgl_indo_in($tgl)
{
    $tanggal = substr($tgl, 0, 2);
    $bulan   = substr($tgl, 3, 2);
    $tahun   = substr($tgl, 6, 4);

    return $tahun . '-' . $bulan . '-' . $tanggal;
}

function waktu_ind($time)
{
    $str = '';
    if (($time / 360) > 1) {
        $jam = ($time / 360);
        $jam = explode('.', $jam);
        $str .= $jam . ' Jam ';
    }
    if (($time / 60) > 1) {
        $menit = ($time / 60);
        $menit = explode('.', $menit);
        $str .= $menit[0] . ' Menit ';
    }
    $detik = $time % 60;
    $str .= $detik;

    return $str . ' Detik';
}

function getBulan($bln)
{
    switch ($bln) {
        case 1:
            return 'Januari';

        case 2:
            return 'Februari';

        case 3:
            return 'Maret';

        case 4:
            return 'April';

        case 5:
            return 'Mei';

        case 6:
            return 'Juni';

        case 7:
            return 'Juli';

        case 8:
            return 'Agustus';

        case 9:
            return 'September';

        case 10:
            return 'Oktober';

        case 11:
            return 'November';

        case 12:
            return 'Desember';
    }
}

function timer()
{
    $time                = 2000;
    $_SESSION['timeout'] = time() + $time;
}
function generator($length = 7)
{
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}
function hash_password($password = '')
{
    $password = strrev($password);
    $password .= '!#@$#%';
    $password = md5($password);
    $password = substr($password, 3, 19);

    return md5($password);
}

function mandiri_timer()
{
    $time                        = 90;
    $_SESSION['mandiri_try']     = 4;
    $_SESSION['mandiri_wait']    = 0;
    $_SESSION['mandiri_timeout'] = time() + $time;
}
function mandiri_timeout()
{
    if (! isset($_SESSION['mandiri_timeout'])) {
        $_SESSION['mandiri_timeout'] = time() - 1;
    }

    $timeout = $_SESSION['mandiri_timeout'];
    if (time() > $timeout) {
        mandiri_timer();
    }
}
function get_identitas()
{
    $configModel = new Config();

    $hsl = $configModel->get_data();

    // $string = "Desa : ".$hsl['nama_desa']." Kec : ".$hsl['nama_kecamatan']." Kab : ".$hsl['nama_kabupaten'];
    return "<h2 class='kop'>PEMERINTAH KABUPATEN " . strtoupper($hsl['nama_kabupaten']) . '<br>KECAMATAN ' . strtoupper($hsl['nama_kecamatan']) . '<br>DESA ' . strtoupper($hsl['nama_desa']) . '</h2><hr>';
}
function fixSQL($str, $encode_ent = false)
{
    $str = @trim($str);
    if ($encode_ent) {
        $str = htmlentities($str);
    }
    if (version_compare(PHP_VERSION, '4.3.0') >= 0) {
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        if (@mysql_ping()) {
            $str = mysql_real_escape_string($str);
        } else {
            $str = addslashes($str);
        }
    } else {
        $str = addslashes($str);
    }

    return $str;
}
function fixTag($varString)
{
    $isIn = true;
    $strD = '';

    for ($i = 0; $i <= strlen($varString); $i++) {
        $mch = substr($varString, $i, 1);
        if ((ord($mch) === 9) || (ord($mch) === 10) || (ord($mch) === 13)) {
            $mch = ' ';
        }
        if ($mch === '<') {
            $isIn = true;
        }
        if ($mch === '>') {
            $isIn = false;
        } else {
            if ($isIn === false) {
                $strD .= $mch;
            }
        }
    }

    return trim($strD);
}
function fTampilTgl($sdate, $edate)
{
    if ($sdate === $edate) {
        $tgl = date('j M Y', strtotime($sdate));
    } elseif ($edate > $sdate) {
        if (date('Y', strtotime($sdate)) === date('Y', strtotime($edate))) {
            if (date('M Y', strtotime($sdate)) === date('M Y', strtotime($edate))) {
                if (date('j M Y', strtotime($sdate)) === date('j M Y', strtotime($edate))) {
                    if (date('j M Y H', strtotime($sdate)) === date('j M Y H', strtotime($edate))) {
                        $tgl = date('j M Y H:i', strtotime($sdate));
                    } else {
                        $tgl = date('j M Y H:i', strtotime($sdate)) . ' - ' . date('H:i', strtotime($edate));
                    }
                } else {
                    $tgl = date('j', strtotime($sdate)) . ' - ' . date('j M Y', strtotime($edate));
                }
            } else {
                $tgl = date('j M', strtotime($sdate)) . ' - ' . date('j M Y', strtotime($edate));
            }
        } else {
            $tgl = date('j M Y', strtotime($sdate)) . ' - ' . date('j M Y', strtotime($edate));
        }
    }

    return $tgl;
}
function hash_pin($pin = '')
{
    $pin = strrev($pin);
    $pin *= 77;
    $pin .= '!#@$#%';

    return md5($pin);
}
