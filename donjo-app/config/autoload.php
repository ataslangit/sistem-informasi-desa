<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = [];

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = [
    'database',
    'form_validation',
    'session',
];

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = [];

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = [
    'date',
    'donjolib',
    'download',
    'excel',
    'file',
    'form',
    'pict',
    'url',
];

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = [];

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = [];

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = [
    'KategoriModel' => 'kategori_model',
    'analisis_grafik_model',
    'analisis_import_model',
    'analisis_indikator_model',
    'analisis_kategori_model',
    'analisis_klasifikasi_model',
    // 'analisis_laporan_keluarga_model',
    'analisis_laporan_model',
    'analisis_master_model',
    'analisis_periode_model',
    'analisis_respon_model',
    'analisis_statistik_jawaban_model',
    'config_model',
    'data_persil_model',
    'export_model',
    'feed_model',
    'first_artikel_m',
    'first_gallery_m',
    'first_keluarga_m',
    'first_m',
    'first_menu_m',
    'first_penduduk_m',
    'header_model',
    'import_model',
    'kelompok_master_model',
    'kelompok_model',
    'keluarga_model',
    'laporan_bulanan_model',
    'laporan_penduduk_model',
    'mandiri_model',
    'modul_model',
    'pamong_model',
    'penduduk_model',
    'plan_area_model',
    'plan_garis_model',
    'plan_line_model',
    'plan_lokasi_model',
    'plan_point_model',
    'plan_polygon_model',
    'program_bantuan_model',
    'rtm_model',
    'sms_model',
    'surat_keluar_model',
    'surat_master_model',
    'surat_model',
    'user_model',
    'web_artikel_model',
    'web_dokumen_model',
    'web_gallery_model',
    'web_kategori_model',
    'web_komentar_model',
    'web_menu_model',
    'web_sosmed_model',
    'web_widget_model',
    'wilayah_model',
];
