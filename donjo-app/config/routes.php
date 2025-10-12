<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Analisis_grafik
$route['analisis_grafik']                     = 'analisis_grafik';
$route['analisis_grafik/index']               = 'analisis_grafik';
$route['analisis_grafik/index/(:num)']        = 'analisis_grafik/index/$1';
$route['analisis_grafik/index/(:num)/(:num)'] = 'analisis_grafik/index/$1/$2';
$route['analisis_grafik/clear']               = 'analisis_grafik/clear';
$route['analisis_grafik/clear/(:any)']        = 'analisis_grafik/clear/$1';
$route['analisis_grafik/leave']               = 'analisis_grafik/leave';
$route['analisis_grafik/time']                = 'analisis_grafik/time';
$route['analisis_grafik/time/(:num)']         = 'analisis_grafik/time/$1';
$route['analisis_grafik/time/(:num)/(:num)']  = 'analisis_grafik/time/$1/$2';
$route['analisis_grafik/dusun']               = 'analisis_grafik/dusun';
$route['analisis_grafik/rw']                  = 'analisis_grafik/rw';
$route['analisis_grafik/rt']                  = 'analisis_grafik/rt';
$route['analisis_grafik/search']              = 'analisis_grafik/search';

// Analisis_indikator
$route['analisis_indikator']                              = 'analisis_indikator';
$route['analisis_indikator/index']                        = 'analisis_indikator';
$route['analisis_indikator/index/(:num)']                 = 'analisis_indikator/index/$1';
$route['analisis_indikator/index/(:num)/(:num)']          = 'analisis_indikator/index/$1/$2';
$route['analisis_indikator/clear']                        = 'analisis_indikator/clear';
$route['analisis_indikator/leave']                        = 'analisis_indikator/leave';
$route['analisis_indikator/form']                         = 'analisis_indikator/form';
$route['analisis_indikator/form/(:num)']                  = 'analisis_indikator/form/$1';
$route['analisis_indikator/form/(:num)/(:num)']           = 'analisis_indikator/form/$1/$2';
$route['analisis_indikator/form/(:num)/(:num)/(:any)']    = 'analisis_indikator/form/$1/$2/$3';
$route['analisis_indikator/parameter/(:any)']             = 'analisis_indikator/parameter/$1';
$route['analisis_indikator/form_parameter/(:any)']        = 'analisis_indikator/form_parameter/$1';
$route['analisis_indikator/form_parameter/(:any)/(:any)'] = 'analisis_indikator/form_parameter/$1/$2';
$route['analisis_indikator/menu/(:any)']                  = 'analisis_indikator/menu/$1';
$route['analisis_indikator/search']                       = 'analisis_indikator/search';
$route['analisis_indikator/filter']                       = 'analisis_indikator/filter';
$route['analisis_indikator/tipe']                         = 'analisis_indikator/tipe';
$route['analisis_indikator/kategori']                     = 'analisis_indikator/kategori';
$route['analisis_indikator/insert']                       = 'analisis_indikator/insert';
$route['analisis_indikator/update/(:num)/(:num)/(:any)']  = 'analisis_indikator/update/$1/$2/$3';
$route['analisis_indikator/delete/(:num)/(:num)/(:any)']  = 'analisis_indikator/delete/$1/$2/$3';
$route['analisis_indikator/delete_all/(:num)/(:num)']     = 'analisis_indikator/delete_all/$1/$2';
$route['analisis_indikator/p_insert/(:any)']              = 'analisis_indikator/p_insert/$1';
$route['analisis_indikator/p_update/(:any)/(:any)']       = 'analisis_indikator/p_update/$1/$2';
$route['analisis_indikator/p_delete/(:any)/(:any)']       = 'analisis_indikator/p_delete/$1/$2';
$route['analisis_indikator/p_delete_all']                 = 'analisis_indikator/p_delete_all';

// Analisis_kategori
$route['analisis_kategori']                             = 'analisis_kategori';
$route['analisis_kategori/index']                       = 'analisis_kategori';
$route['analisis_kategori/index/(:num)']                = 'analisis_kategori/index/$1';
$route['analisis_kategori/index/(:num)/(:num)']         = 'analisis_kategori/index/$1/$2';
$route['analisis_kategori/clear']                       = 'analisis_kategori/clear';
$route['analisis_kategori/leave']                       = 'analisis_kategori/leave';
$route['analisis_kategori/form']                        = 'analisis_kategori/form';
$route['analisis_kategori/form/(:num)']                 = 'analisis_kategori/form/$1';
$route['analisis_kategori/form/(:num)/(:num)']          = 'analisis_kategori/form/$1/$2';
$route['analisis_kategori/form/(:num)/(:num)/(:any)']   = 'analisis_kategori/form/$1/$2/$3';
$route['analisis_kategori/search']                      = 'analisis_kategori/search';
$route['analisis_kategori/insert']                      = 'analisis_kategori/insert';
$route['analisis_kategori/update/(:num)/(:num)/(:any)'] = 'analisis_kategori/update/$1/$2/$3';
$route['analisis_kategori/delete/(:num)/(:num)/(:any)'] = 'analisis_kategori/delete/$1/$2/$3';
$route['analisis_kategori/delete_all/(:num)/(:num)']    = 'analisis_kategori/delete_all/$1/$2';

// Analisis_klasifikasi
$route['analisis_klasifikasi']                             = 'analisis_klasifikasi';
$route['analisis_klasifikasi/index']                       = 'analisis_klasifikasi';
$route['analisis_klasifikasi/index/(:num)']                = 'analisis_klasifikasi/index/$1';
$route['analisis_klasifikasi/index/(:num)/(:num)']         = 'analisis_klasifikasi/index/$1/$2';
$route['analisis_klasifikasi/clear']                       = 'analisis_klasifikasi/clear';
$route['analisis_klasifikasi/leave']                       = 'analisis_klasifikasi/leave';
$route['analisis_klasifikasi/form']                        = 'analisis_klasifikasi/form';
$route['analisis_klasifikasi/form/(:num)']                 = 'analisis_klasifikasi/form/$1';
$route['analisis_klasifikasi/form/(:num)/(:num)']          = 'analisis_klasifikasi/form/$1/$2';
$route['analisis_klasifikasi/form/(:num)/(:num)/(:any)']   = 'analisis_klasifikasi/form/$1/$2/$3';
$route['analisis_klasifikasi/search']                      = 'analisis_klasifikasi/search';
$route['analisis_klasifikasi/insert']                      = 'analisis_klasifikasi/insert';
$route['analisis_klasifikasi/update/(:num)/(:num)/(:any)'] = 'analisis_klasifikasi/update/$1/$2/$3';
$route['analisis_klasifikasi/delete/(:num)/(:num)/(:any)'] = 'analisis_klasifikasi/delete/$1/$2/$3';
$route['analisis_klasifikasi/delete_all/(:num)/(:num)']    = 'analisis_klasifikasi/delete_all/$1/$2';

// Analisis_laporan
$route['analisis_laporan']                                = 'analisis_laporan';
$route['analisis_laporan/index']                          = 'analisis_laporan';
$route['analisis_laporan/index/(:num)']                   = 'analisis_laporan/index/$1';
$route['analisis_laporan/index/(:num)/(:num)']            = 'analisis_laporan/index/$1/$2';
$route['analisis_laporan/clear']                          = 'analisis_laporan/clear';
$route['analisis_laporan/leave']                          = 'analisis_laporan/leave';
$route['analisis_laporan/kuisioner/(:num)/(:num)/(:any)'] = 'analisis_laporan/kuisioner/$1/$2/$3';
$route['analisis_laporan/cetak']                          = 'analisis_laporan/cetak';
$route['analisis_laporan/cetak/(:num)']                   = 'analisis_laporan/cetak/$1';
$route['analisis_laporan/excel']                          = 'analisis_laporan/excel';
$route['analisis_laporan/excel/(:num)']                   = 'analisis_laporan/excel/$1';
$route['analisis_laporan/multi_jawab']                    = 'analisis_laporan/multi_jawab';
$route['analisis_laporan/multi_exec']                     = 'analisis_laporan/multi_exec';
$route['analisis_laporan/ajax_multi_jawab']               = 'analisis_laporan/ajax_multi_jawab';
$route['analisis_laporan/multi_jawab_proses']             = 'analisis_laporan/multi_jawab_proses';
$route['analisis_laporan/dusun']                          = 'analisis_laporan/dusun';
$route['analisis_laporan/rw']                             = 'analisis_laporan/rw';
$route['analisis_laporan/rt']                             = 'analisis_laporan/rt';
$route['analisis_laporan/klasifikasi']                    = 'analisis_laporan/klasifikasi';
$route['analisis_laporan/search']                         = 'analisis_laporan/search';

// Analisis_master
$route['analisis_master']                             = 'analisis_master';
$route['analisis_master/index']                       = 'analisis_master';
$route['analisis_master/index/(:num)']                = 'analisis_master/index/$1';
$route['analisis_master/index/(:num)/(:num)']         = 'analisis_master/index/$1/$2';
$route['analisis_master/clear']                       = 'analisis_master/clear';
$route['analisis_master/form']                        = 'analisis_master/form';
$route['analisis_master/form/(:num)']                 = 'analisis_master/form/$1';
$route['analisis_master/form/(:num)/(:num)']          = 'analisis_master/form/$1/$2';
$route['analisis_master/form/(:num)/(:num)/(:any)']   = 'analisis_master/form/$1/$2/$3';
$route['analisis_master/panduan']                     = 'analisis_master/panduan';
$route['analisis_master/import_analisis']             = 'analisis_master/import_analisis';
$route['analisis_master/menu/(:any)']                 = 'analisis_master/menu/$1';
$route['analisis_master/menu/(:any)/(:num)']          = 'analisis_master/menu/$1/$2';
$route['analisis_master/search']                      = 'analisis_master/search';
$route['analisis_master/filter']                      = 'analisis_master/filter';
$route['analisis_master/state']                       = 'analisis_master/state';
$route['analisis_master/insert']                      = 'analisis_master/insert';
$route['analisis_master/import']                      = 'analisis_master/import';
$route['analisis_master/update/(:num)/(:num)/(:any)'] = 'analisis_master/update/$1/$2/$3';
$route['analisis_master/delete/(:num)/(:num)/(:any)'] = 'analisis_master/delete/$1/$2/$3';
$route['analisis_master/delete_all/(:num)/(:num)']    = 'analisis_master/delete_all/$1/$2';

// Analisis_periode
$route['analisis_periode']                             = 'analisis_periode';
$route['analisis_periode/index']                       = 'analisis_periode';
$route['analisis_periode/index/(:num)']                = 'analisis_periode/index/$1';
$route['analisis_periode/index/(:num)/(:num)']         = 'analisis_periode/index/$1/$2';
$route['analisis_periode/clear']                       = 'analisis_periode/clear';
$route['analisis_periode/leave']                       = 'analisis_periode/leave';
$route['analisis_periode/form']                        = 'analisis_periode/form';
$route['analisis_periode/form/(:num)']                 = 'analisis_periode/form/$1';
$route['analisis_periode/form/(:num)/(:num)']          = 'analisis_periode/form/$1/$2';
$route['analisis_periode/form/(:num)/(:num)/(:any)']   = 'analisis_periode/form/$1/$2/$3';
$route['analisis_periode/search']                      = 'analisis_periode/search';
$route['analisis_periode/state']                       = 'analisis_periode/state';
$route['analisis_periode/insert']                      = 'analisis_periode/insert';
$route['analisis_periode/update/(:num)/(:num)/(:any)'] = 'analisis_periode/update/$1/$2/$3';
$route['analisis_periode/delete/(:num)/(:num)/(:any)'] = 'analisis_periode/delete/$1/$2/$3';
$route['analisis_periode/delete_all/(:num)/(:num)']    = 'analisis_periode/delete_all/$1/$2';
$route['analisis_periode/list_state']                  = 'analisis_periode/list_state';

// Analisis_respon
$route['analisis_respon']                                                    = 'analisis_respon';
$route['analisis_respon/index']                                              = 'analisis_respon';
$route['analisis_respon/index/(:num)']                                       = 'analisis_respon/index/$1';
$route['analisis_respon/index/(:num)/(:num)']                                = 'analisis_respon/index/$1/$2';
$route['analisis_respon/clear']                                              = 'analisis_respon/clear';
$route['analisis_respon/leave']                                              = 'analisis_respon/leave';
$route['analisis_respon/kuisioner/(:num)/(:num)/(:any)']                     = 'analisis_respon/kuisioner/$1/$2/$3';
$route['analisis_respon/kuisioner/(:num)/(:num)/(:any)/(:num)']              = 'analisis_respon/kuisioner/$1/$2/$3/$4';
$route['analisis_respon/update_kuisioner/(:num)/(:num)/(:any)']              = 'analisis_respon/update_kuisioner/$1/$2/$3';
$route['analisis_respon/kuisioner_child/(:num)/(:num)/(:any)/(:any)']        = 'analisis_respon/kuisioner_child/$1/$2/$3/$4';
$route['analisis_respon/update_kuisioner_child/(:num)/(:num)/(:any)/(:any)'] = 'analisis_respon/update_kuisioner_child/$1/$2/$3/$4';
$route['analisis_respon/aturan_ajax']                                        = 'analisis_respon/aturan_ajax';
$route['analisis_respon/aturan_unduh']                                       = 'analisis_respon/aturan_unduh';
$route['analisis_respon/data_ajax']                                          = 'analisis_respon/data_ajax';
$route['analisis_respon/data_unduh']                                         = 'analisis_respon/data_unduh';
$route['analisis_respon/data_unduh/(:num)']                                  = 'analisis_respon/data_unduh/$1';
$route['analisis_respon/data_unduh/(:num)/(:num)']                           = 'analisis_respon/data_unduh/$1/$2';
$route['analisis_respon/import']                                             = 'analisis_respon/import';
$route['analisis_respon/import/(:num)']                                      = 'analisis_respon/import/$1';
$route['analisis_respon/satu_jiwa']                                          = 'analisis_respon/satu_jiwa';
$route['analisis_respon/satu_jiwa/(:num)']                                   = 'analisis_respon/satu_jiwa/$1';
$route['analisis_respon/dua_dunia']                                          = 'analisis_respon/dua_dunia';
$route['analisis_respon/dua_dunia/(:num)']                                   = 'analisis_respon/dua_dunia/$1';
$route['analisis_respon/import_proses']                                      = 'analisis_respon/import_proses';
$route['analisis_respon/import_proses/(:num)']                               = 'analisis_respon/import_proses/$1';
$route['analisis_respon/search']                                             = 'analisis_respon/search';
$route['analisis_respon/isi']                                                = 'analisis_respon/isi';
$route['analisis_respon/dusun']                                              = 'analisis_respon/dusun';
$route['analisis_respon/rw']                                                 = 'analisis_respon/rw';
$route['analisis_respon/rt']                                                 = 'analisis_respon/rt';

// Analisis_statistik_jawaban
$route['analisis_statistik_jawaban']                                = 'analisis_statistik_jawaban';
$route['analisis_statistik_jawaban/index']                          = 'analisis_statistik_jawaban';
$route['analisis_statistik_jawaban/index/(:num)']                   = 'analisis_statistik_jawaban/index/$1';
$route['analisis_statistik_jawaban/index/(:num)/(:num)']            = 'analisis_statistik_jawaban/index/$1/$2';
$route['analisis_statistik_jawaban/clear']                          = 'analisis_statistik_jawaban/clear';
$route['analisis_statistik_jawaban/leave']                          = 'analisis_statistik_jawaban/leave';
$route['analisis_statistik_jawaban/form']                           = 'analisis_statistik_jawaban/form';
$route['analisis_statistik_jawaban/form/(:num)']                    = 'analisis_statistik_jawaban/form/$1';
$route['analisis_statistik_jawaban/form/(:num)/(:num)']             = 'analisis_statistik_jawaban/form/$1/$2';
$route['analisis_statistik_jawaban/form/(:num)/(:num)/(:any)']      = 'analisis_statistik_jawaban/form/$1/$2/$3';
$route['analisis_statistik_jawaban/parameter/(:any)']               = 'analisis_statistik_jawaban/parameter/$1';
$route['analisis_statistik_jawaban/grafik_parameter/(:any)']        = 'analisis_statistik_jawaban/grafik_parameter/$1';
$route['analisis_statistik_jawaban/subjek_parameter/(:any)/(:any)'] = 'analisis_statistik_jawaban/subjek_parameter/$1/$2';
$route['analisis_statistik_jawaban/cetak']                          = 'analisis_statistik_jawaban/cetak';
$route['analisis_statistik_jawaban/cetak/(:num)']                   = 'analisis_statistik_jawaban/cetak/$1';
$route['analisis_statistik_jawaban/excel']                          = 'analisis_statistik_jawaban/excel';
$route['analisis_statistik_jawaban/excel/(:num)']                   = 'analisis_statistik_jawaban/excel/$1';
$route['analisis_statistik_jawaban/cetak2/(:any)/(:any)']           = 'analisis_statistik_jawaban/cetak2/$1/$2';
$route['analisis_statistik_jawaban/excel2/(:any)/(:any)']           = 'analisis_statistik_jawaban/excel2/$1/$2';
$route['analisis_statistik_jawaban/search']                         = 'analisis_statistik_jawaban/search';
$route['analisis_statistik_jawaban/filter']                         = 'analisis_statistik_jawaban/filter';
$route['analisis_statistik_jawaban/tipe']                           = 'analisis_statistik_jawaban/tipe';
$route['analisis_statistik_jawaban/kategori']                       = 'analisis_statistik_jawaban/kategori';
$route['analisis_statistik_jawaban/dusun']                          = 'analisis_statistik_jawaban/dusun';
$route['analisis_statistik_jawaban/rw']                             = 'analisis_statistik_jawaban/rw';
$route['analisis_statistik_jawaban/rt']                             = 'analisis_statistik_jawaban/rt';
$route['analisis_statistik_jawaban/dusun2/(:any)/(:any)']           = 'analisis_statistik_jawaban/dusun2/$1/$2';
$route['analisis_statistik_jawaban/rw2/(:any)/(:any)']              = 'analisis_statistik_jawaban/rw2/$1/$2';
$route['analisis_statistik_jawaban/rt2/(:any)/(:any)']              = 'analisis_statistik_jawaban/rt2/$1/$2';
$route['analisis_statistik_jawaban/dusun3/(:any)']                  = 'analisis_statistik_jawaban/dusun3/$1';
$route['analisis_statistik_jawaban/rw3/(:any)']                     = 'analisis_statistik_jawaban/rw3/$1';
$route['analisis_statistik_jawaban/rt3/(:any)']                     = 'analisis_statistik_jawaban/rt3/$1';
$route['analisis_statistik_jawaban/insert']                         = 'analisis_statistik_jawaban/insert';
$route['analisis_statistik_jawaban/update/(:num)/(:num)/(:any)']    = 'analisis_statistik_jawaban/update/$1/$2/$3';
$route['analisis_statistik_jawaban/delete/(:num)/(:num)/(:any)']    = 'analisis_statistik_jawaban/delete/$1/$2/$3';
$route['analisis_statistik_jawaban/delete_all/(:num)/(:num)']       = 'analisis_statistik_jawaban/delete_all/$1/$2';
$route['analisis_statistik_jawaban/p_insert/(:any)']                = 'analisis_statistik_jawaban/p_insert/$1';
$route['analisis_statistik_jawaban/p_update/(:any)/(:any)']         = 'analisis_statistik_jawaban/p_update/$1/$2';
$route['analisis_statistik_jawaban/p_delete/(:any)/(:any)']         = 'analisis_statistik_jawaban/p_delete/$1/$2';
$route['analisis_statistik_jawaban/p_delete_all']                   = 'analisis_statistik_jawaban/p_delete_all';

// Area
$route['area']                                     = 'area';
$route['area/index']                               = 'area';
$route['area/index/(:num)']                        = 'area/index/$1';
$route['area/index/(:num)/(:num)']                 = 'area/index/$1/$2';
$route['area/clear']                               = 'area/clear';
$route['area/form']                                = 'area/form';
$route['area/form/(:num)']                         = 'area/form/$1';
$route['area/form/(:num)/(:num)']                  = 'area/form/$1/$2';
$route['area/form/(:num)/(:num)/(:any)']           = 'area/form/$1/$2/$3';
$route['area/ajax_area_maps']                      = 'area/ajax_area_maps';
$route['area/ajax_area_maps/(:num)']               = 'area/ajax_area_maps/$1';
$route['area/ajax_area_maps/(:num)/(:num)']        = 'area/ajax_area_maps/$1/$2';
$route['area/ajax_area_maps/(:num)/(:num)/(:any)'] = 'area/ajax_area_maps/$1/$2/$3';
$route['area/update_maps/(:num)/(:num)/(:any)']    = 'area/update_maps/$1/$2/$3';
$route['area/search']                              = 'area/search';
$route['area/filter']                              = 'area/filter';
$route['area/polygon']                             = 'area/polygon';
$route['area/subpolygon']                          = 'area/subpolygon';
$route['area/insert']                              = 'area/insert';
$route['area/insert/(:num)']                       = 'area/insert/$1';
$route['area/update/(:any)/(:num)/(:num)']         = 'area/update/$1/$2/$3';
$route['area/delete/(:num)/(:num)/(:any)']         = 'area/delete/$1/$2/$3';
$route['area/delete_all/(:num)/(:num)']            = 'area/delete_all/$1/$2';
$route['area/area_lock/(:any)']                    = 'area/area_lock/$1';
$route['area/area_unlock/(:any)']                  = 'area/area_unlock/$1';

// Data_persil
$route['data_persil']                                = 'data_persil';
$route['data_persil/index']                          = 'data_persil';
$route['data_persil/index/(:num)']                   = 'data_persil/index/$1';
$route['data_persil/clear']                          = 'data_persil/clear';
$route['data_persil/import']                         = 'data_persil/import';
$route['data_persil/search']                         = 'data_persil/search';
$route['data_persil/detail']                         = 'data_persil/detail';
$route['data_persil/detail/(:num)']                  = 'data_persil/detail/$1';
$route['data_persil/create']                         = 'data_persil/create';
$route['data_persil/create/(:num)']                  = 'data_persil/create/$1';
$route['data_persil/create_ext']                     = 'data_persil/create_ext';
$route['data_persil/create_ext/(:num)']              = 'data_persil/create_ext/$1';
$route['data_persil/simpan_persil']                  = 'data_persil/simpan_persil';
$route['data_persil/simpan_persil/(:num)']           = 'data_persil/simpan_persil/$1';
$route['data_persil/jenis/(:num)']                   = 'data_persil/jenis/$1';
$route['data_persil/jenis/(:num)/(:num)']            = 'data_persil/jenis/$1/$2';
$route['data_persil/peruntukan']                     = 'data_persil/peruntukan';
$route['data_persil/peruntukan/(:any)']              = 'data_persil/peruntukan/$1';
$route['data_persil/peruntukan/(:any)/(:num)']       = 'data_persil/peruntukan/$1/$2';
$route['data_persil/persil_jenis']                   = 'data_persil/persil_jenis';
$route['data_persil/persil_jenis/(:num)']            = 'data_persil/persil_jenis/$1';
$route['data_persil/hapus_persil_jenis/(:any)']      = 'data_persil/hapus_persil_jenis/$1';
$route['data_persil/persil_peruntukan']              = 'data_persil/persil_peruntukan';
$route['data_persil/persil_peruntukan/(:num)']       = 'data_persil/persil_peruntukan/$1';
$route['data_persil/hapus_persil_peruntukan/(:any)'] = 'data_persil/hapus_persil_peruntukan/$1';
$route['data_persil/hapus/(:any)']                   = 'data_persil/hapus/$1';
$route['data_persil/import_proses']                  = 'data_persil/import_proses';

// Database
$route['database']                  = 'database';
$route['database/index']            = 'database';
$route['database/clear']            = 'database/clear';
$route['database/import']           = 'database/import';
$route['database/siak']             = 'database/siak';
$route['database/import_ppls']      = 'database/import_ppls';
$route['database/backup']           = 'database/backup';
$route['database/export_dasar']     = 'database/export_dasar';
$route['database/export_akp']       = 'database/export_akp';
$route['database/import2']          = 'database/import2';
$route['database/pre_migrate']      = 'database/pre_migrate';
$route['database/migrate']          = 'database/migrate';
$route['database/import_dasar']     = 'database/import_dasar';
$route['database/ppls_kuisioner']   = 'database/ppls_kuisioner';
$route['database/ppls_individu']    = 'database/ppls_individu';
$route['database/ppls_rumahtangga'] = 'database/ppls_rumahtangga';
$route['database/import_siak']      = 'database/import_siak';
$route['database/import_akp']       = 'database/import_akp';
$route['database/jos']              = 'database/jos';
$route['database/jos2']             = 'database/jos2';
$route['database/exec_backup']      = 'database/exec_backup';
$route['database/restore']          = 'database/restore';
$route['database/ces']              = 'database/ces';
$route['database/surat']            = 'database/surat';
$route['database/export_excel']     = 'database/export_excel';
$route['database/export_csv']       = 'database/export_csv';

// Dokumen
$route['dokumen']                             = 'dokumen';
$route['dokumen/index']                       = 'dokumen';
$route['dokumen/index/(:num)']                = 'dokumen/index/$1';
$route['dokumen/index/(:num)/(:num)']         = 'dokumen/index/$1/$2';
$route['dokumen/clear']                       = 'dokumen/clear';
$route['dokumen/form']                        = 'dokumen/form';
$route['dokumen/form/(:num)']                 = 'dokumen/form/$1';
$route['dokumen/form/(:num)/(:num)']          = 'dokumen/form/$1/$2';
$route['dokumen/form/(:num)/(:num)/(:any)']   = 'dokumen/form/$1/$2/$3';
$route['dokumen/search']                      = 'dokumen/search';
$route['dokumen/filter']                      = 'dokumen/filter';
$route['dokumen/insert']                      = 'dokumen/insert';
$route['dokumen/update/(:any)/(:num)/(:num)'] = 'dokumen/update/$1/$2/$3';
$route['dokumen/delete/(:num)/(:num)/(:any)'] = 'dokumen/delete/$1/$2/$3';
$route['dokumen/delete_all/(:num)/(:num)']    = 'dokumen/delete_all/$1/$2';
$route['dokumen/dokumen_lock/(:any)']         = 'dokumen/dokumen_lock/$1';
$route['dokumen/dokumen_unlock/(:any)']       = 'dokumen/dokumen_unlock/$1';

// Feed
$route['feed']       = 'feed';
$route['feed/index'] = 'feed';

// First
$route['first']                                    = 'first';
$route['first/index']                              = 'first';
$route['first/index/(:num)']                       = 'first/index/$1';
$route['first/auth']                               = 'first/auth';
$route['first/mobile']                             = 'first/mobile';
$route['first/mobile/(:any)']                      = 'first/mobile/$1';
$route['first/mobile/(:any)/(:any)']               = 'first/mobile/$1/$2';
$route['first/logout']                             = 'first/logout';
$route['first/ganti']                              = 'first/ganti';
$route['first/cetak_biodata/(:any)']               = 'first/cetak_biodata/$1';
$route['first/mandiri']                            = 'first/mandiri';
$route['first/mandiri/(:num)']                     = 'first/mandiri/$1';
$route['first/mandiri/(:num)/(:num)']              = 'first/mandiri/$1/$2';
$route['first/artikel']                            = 'first/artikel';
$route['first/artikel/(:any)']                     = 'first/artikel/$1';
$route['first/artikel/(:any)/(:num)']              = 'first/artikel/$1/$2';
$route['first/arsip']                              = 'first/arsip';
$route['first/arsip/(:num)']                       = 'first/arsip/$1';
$route['first/gallery']                            = 'first/gallery';
$route['first/gallery/(:num)']                     = 'first/gallery/$1';
$route['first/sub_gallery/(:num)']                 = 'first/sub_gallery/$1';
$route['first/sub_gallery/(:num)/(:num)']          = 'first/sub_gallery/$1/$2';
$route['first/statistik']                          = 'first/statistik';
$route['first/statistik/(:any)']                   = 'first/statistik/$1';
$route['first/statistik/(:any)/(:num)']            = 'first/statistik/$1/$2';
$route['first/data_analisis']                      = 'first/data_analisis';
$route['first/data_analisis/(:any)']               = 'first/data_analisis/$1';
$route['first/data_analisis/(:any)/(:num)']        = 'first/data_analisis/$1/$2';
$route['first/data_analisis/(:any)/(:num)/(:num)'] = 'first/data_analisis/$1/$2/$3';
$route['first/wilayah']                            = 'first/wilayah';
$route['first/statistik_k']                        = 'first/statistik_k';
$route['first/statistik_k/(:num)']                 = 'first/statistik_k/$1';
$route['first/agenda']                             = 'first/agenda';
$route['first/agenda/(:num)']                      = 'first/agenda/$1';
$route['first/kategori/(:num)']                    = 'first/kategori/$1';
$route['first/kategori/(:num)/(:num)']             = 'first/kategori/$1/$2';
$route['first/add_comment/(:num)']                 = 'first/add_comment/$1';
$route['first/randomap']                           = 'first/randomap';
$route['first/randomap/(:num)']                    = 'first/randomap/$1';

// Gallery
$route['gallery']                                          = 'gallery';
$route['gallery/index']                                    = 'gallery';
$route['gallery/index/(:num)']                             = 'gallery/index/$1';
$route['gallery/index/(:num)/(:num)']                      = 'gallery/index/$1/$2';
$route['gallery/clear']                                    = 'gallery/clear';
$route['gallery/form']                                     = 'gallery/form';
$route['gallery/form/(:num)']                              = 'gallery/form/$1';
$route['gallery/form/(:num)/(:num)']                       = 'gallery/form/$1/$2';
$route['gallery/form/(:num)/(:num)/(:any)']                = 'gallery/form/$1/$2/$3';
$route['gallery/search']                                   = 'gallery/search';
$route['gallery/filter']                                   = 'gallery/filter';
$route['gallery/insert']                                   = 'gallery/insert';
$route['gallery/update/(:any)/(:num)/(:num)']              = 'gallery/update/$1/$2/$3';
$route['gallery/delete/(:num)/(:num)/(:any)']              = 'gallery/delete/$1/$2/$3';
$route['gallery/delete_all/(:num)/(:num)']                 = 'gallery/delete_all/$1/$2';
$route['gallery/gallery_lock/(:any)']                      = 'gallery/gallery_lock/$1';
$route['gallery/gallery_unlock/(:any)']                    = 'gallery/gallery_unlock/$1';
$route['gallery/sub_gallery/(:num)']                       = 'gallery/sub_gallery/$1';
$route['gallery/sub_gallery/(:num)/(:num)']                = 'gallery/sub_gallery/$1/$2';
$route['gallery/form_sub_gallery/(:num)']                  = 'gallery/form_sub_gallery/$1';
$route['gallery/form_sub_gallery/(:num)/(:num)']           = 'gallery/form_sub_gallery/$1/$2';
$route['gallery/insert_sub_gallery/(:any)']                = 'gallery/insert_sub_gallery/$1';
$route['gallery/update_sub_gallery/(:any)/(:any)']         = 'gallery/update_sub_gallery/$1/$2';
$route['gallery/delete_sub_gallery/(:any)/(:any)']         = 'gallery/delete_sub_gallery/$1/$2';
$route['gallery/delete_all_sub_gallery/(:any)']            = 'gallery/delete_all_sub_gallery/$1';
$route['gallery/gallery_lock_sub_gallery/(:any)/(:any)']   = 'gallery/gallery_lock_sub_gallery/$1/$2';
$route['gallery/gallery_unlock_sub_gallery/(:any)/(:any)'] = 'gallery/gallery_unlock_sub_gallery/$1/$2';

// Garis
$route['garis']                                      = 'garis';
$route['garis/index']                                = 'garis';
$route['garis/index/(:num)']                         = 'garis/index/$1';
$route['garis/index/(:num)/(:num)']                  = 'garis/index/$1/$2';
$route['garis/clear']                                = 'garis/clear';
$route['garis/form']                                 = 'garis/form';
$route['garis/form/(:num)']                          = 'garis/form/$1';
$route['garis/form/(:num)/(:num)']                   = 'garis/form/$1/$2';
$route['garis/form/(:num)/(:num)/(:any)']            = 'garis/form/$1/$2/$3';
$route['garis/ajax_garis_maps']                      = 'garis/ajax_garis_maps';
$route['garis/ajax_garis_maps/(:num)']               = 'garis/ajax_garis_maps/$1';
$route['garis/ajax_garis_maps/(:num)/(:num)']        = 'garis/ajax_garis_maps/$1/$2';
$route['garis/ajax_garis_maps/(:num)/(:num)/(:any)'] = 'garis/ajax_garis_maps/$1/$2/$3';
$route['garis/update_maps/(:num)/(:num)/(:any)']     = 'garis/update_maps/$1/$2/$3';
$route['garis/search']                               = 'garis/search';
$route['garis/filter']                               = 'garis/filter';
$route['garis/line']                                 = 'garis/line';
$route['garis/subline']                              = 'garis/subline';
$route['garis/insert']                               = 'garis/insert';
$route['garis/insert/(:num)']                        = 'garis/insert/$1';
$route['garis/update/(:any)/(:num)/(:num)']          = 'garis/update/$1/$2/$3';
$route['garis/delete/(:num)/(:num)/(:any)']          = 'garis/delete/$1/$2/$3';
$route['garis/delete_all/(:num)/(:num)']             = 'garis/delete_all/$1/$2';
$route['garis/garis_lock/(:any)']                    = 'garis/garis_lock/$1';
$route['garis/garis_unlock/(:any)']                  = 'garis/garis_unlock/$1';

// Gis
$route['gis']                   = 'gis';
$route['gis/index']             = 'gis';
$route['gis/clear']             = 'gis/clear';
$route['gis/search']            = 'gis/search';
$route['gis/filter']            = 'gis/filter';
$route['gis/layer_penduduk']    = 'gis/layer_penduduk';
$route['gis/layer_wilayah']     = 'gis/layer_wilayah';
$route['gis/layer_area']        = 'gis/layer_area';
$route['gis/layer_line']        = 'gis/layer_line';
$route['gis/layer_point']       = 'gis/layer_point';
$route['gis/layer_keluarga']    = 'gis/layer_keluarga';
$route['gis/layer_desa']        = 'gis/layer_desa';
$route['gis/sex']               = 'gis/sex';
$route['gis/dusun']             = 'gis/dusun';
$route['gis/rw']                = 'gis/rw';
$route['gis/rt']                = 'gis/rt';
$route['gis/agama']             = 'gis/agama';
$route['gis/ajax_adv_search']   = 'gis/ajax_adv_search';
$route['gis/adv_search_proses'] = 'gis/adv_search_proses';

// Hom_desa
$route['hom_desa']                     = 'hom_desa';
$route['hom_desa/index']               = 'hom_desa';
$route['hom_desa/about']               = 'hom_desa/about';
$route['hom_desa/insert']              = 'hom_desa/insert';
$route['hom_desa/update/(:any)']       = 'hom_desa/update/$1';
$route['hom_desa/ajax_kantor_maps']    = 'hom_desa/ajax_kantor_maps';
$route['hom_desa/ajax_wilayah_maps']   = 'hom_desa/ajax_wilayah_maps';
$route['hom_desa/update_kantor_maps']  = 'hom_desa/update_kantor_maps';
$route['hom_desa/update_wilayah_maps'] = 'hom_desa/update_wilayah_maps';
$route['hom_desa/kosong_pend']         = 'hom_desa/kosong_pend';
$route['hom_desa/undelik']             = 'hom_desa/undelik';

// Install
$route['install']       = 'install';
$route['install/index'] = 'install';
$route['install/run']   = 'install/run';

// Kategori
$route['kategori']                                            = 'kategori';
$route['kategori/index']                                      = 'kategori';
$route['kategori/index/(:num)']                               = 'kategori/index/$1';
$route['kategori/index/(:num)/(:num)']                        = 'kategori/index/$1/$2';
$route['kategori/clear']                                      = 'kategori/clear';
$route['kategori/form']                                       = 'kategori/form';
$route['kategori/form/(:any)']                                = 'kategori/form/$1';
$route['kategori/sub_kategori']                               = 'kategori/sub_kategori';
$route['kategori/sub_kategori/(:num)']                        = 'kategori/sub_kategori/$1';
$route['kategori/ajax_add_sub_kategori']                      = 'kategori/ajax_add_sub_kategori';
$route['kategori/ajax_add_sub_kategori/(:any)']               = 'kategori/ajax_add_sub_kategori/$1';
$route['kategori/ajax_add_sub_kategori/(:any)/(:any)']        = 'kategori/ajax_add_sub_kategori/$1/$2';
$route['kategori/search']                                     = 'kategori/search';
$route['kategori/filter']                                     = 'kategori/filter';
$route['kategori/insert']                                     = 'kategori/insert';
$route['kategori/update/(:any)']                              = 'kategori/update/$1';
$route['kategori/delete/(:any)']                              = 'kategori/delete/$1';
$route['kategori/delete_all/(:num)/(:num)']                   = 'kategori/delete_all/$1/$2';
$route['kategori/kategori_lock/(:any)']                       = 'kategori/kategori_lock/$1';
$route['kategori/kategori_unlock/(:any)']                     = 'kategori/kategori_unlock/$1';
$route['kategori/insert_sub_kategori/(:any)']                 = 'kategori/insert_sub_kategori/$1';
$route['kategori/update_sub_kategori/(:any)/(:any)']          = 'kategori/update_sub_kategori/$1/$2';
$route['kategori/delete_sub_kategori/(:any)']                 = 'kategori/delete_sub_kategori/$1';
$route['kategori/delete_sub_kategori/(:any)/(:num)']          = 'kategori/delete_sub_kategori/$1/$2';
$route['kategori/delete_all_sub_kategori/(:any)']             = 'kategori/delete_all_sub_kategori/$1';
$route['kategori/kategori_lock_sub_kategori/(:any)/(:any)']   = 'kategori/kategori_lock_sub_kategori/$1/$2';
$route['kategori/kategori_unlock_sub_kategori/(:any)/(:any)'] = 'kategori/kategori_unlock_sub_kategori/$1/$2';

// Kelompok
$route['kelompok']                             = 'kelompok';
$route['kelompok/index']                       = 'kelompok';
$route['kelompok/index/(:num)']                = 'kelompok/index/$1';
$route['kelompok/index/(:num)/(:num)']         = 'kelompok/index/$1/$2';
$route['kelompok/clear']                       = 'kelompok/clear';
$route['kelompok/anggota/(:num)']              = 'kelompok/anggota/$1';
$route['kelompok/form']                        = 'kelompok/form';
$route['kelompok/form/(:num)']                 = 'kelompok/form/$1';
$route['kelompok/form/(:num)/(:num)']          = 'kelompok/form/$1/$2';
$route['kelompok/form/(:num)/(:num)/(:any)']   = 'kelompok/form/$1/$2/$3';
$route['kelompok/form_anggota/(:num)']         = 'kelompok/form_anggota/$1';
$route['kelompok/form_anggota/(:num)/(:num)']  = 'kelompok/form_anggota/$1/$2';
$route['kelompok/panduan']                     = 'kelompok/panduan';
$route['kelompok/cetak']                       = 'kelompok/cetak';
$route['kelompok/excel']                       = 'kelompok/excel';
$route['kelompok/cetak_a/(:num)']              = 'kelompok/cetak_a/$1';
$route['kelompok/excel_a/(:num)']              = 'kelompok/excel_a/$1';
$route['kelompok/menu/(:any)']                 = 'kelompok/menu/$1';
$route['kelompok/search']                      = 'kelompok/search';
$route['kelompok/filter']                      = 'kelompok/filter';
$route['kelompok/state']                       = 'kelompok/state';
$route['kelompok/insert']                      = 'kelompok/insert';
$route['kelompok/update/(:num)/(:num)/(:any)'] = 'kelompok/update/$1/$2/$3';
$route['kelompok/update_a/(:any)/(:num)']      = 'kelompok/update_a/$1/$2';
$route['kelompok/delete/(:num)/(:num)/(:any)'] = 'kelompok/delete/$1/$2/$3';
$route['kelompok/delete_all/(:num)/(:num)']    = 'kelompok/delete_all/$1/$2';
$route['kelompok/insert_a/(:num)']             = 'kelompok/insert_a/$1';
$route['kelompok/delete_a/(:any)/(:num)']      = 'kelompok/delete_a/$1/$2';
$route['kelompok/to_master/(:num)']            = 'kelompok/to_master/$1';

// Kelompok_master
$route['kelompok_master']                             = 'kelompok_master';
$route['kelompok_master/index']                       = 'kelompok_master';
$route['kelompok_master/index/(:num)']                = 'kelompok_master/index/$1';
$route['kelompok_master/index/(:num)/(:num)']         = 'kelompok_master/index/$1/$2';
$route['kelompok_master/clear']                       = 'kelompok_master/clear';
$route['kelompok_master/form']                        = 'kelompok_master/form';
$route['kelompok_master/form/(:num)']                 = 'kelompok_master/form/$1';
$route['kelompok_master/form/(:num)/(:num)']          = 'kelompok_master/form/$1/$2';
$route['kelompok_master/form/(:num)/(:num)/(:any)']   = 'kelompok_master/form/$1/$2/$3';
$route['kelompok_master/search']                      = 'kelompok_master/search';
$route['kelompok_master/filter']                      = 'kelompok_master/filter';
$route['kelompok_master/state']                       = 'kelompok_master/state';
$route['kelompok_master/insert']                      = 'kelompok_master/insert';
$route['kelompok_master/update/(:num)/(:num)/(:any)'] = 'kelompok_master/update/$1/$2/$3';
$route['kelompok_master/delete/(:num)/(:num)/(:any)'] = 'kelompok_master/delete/$1/$2/$3';
$route['kelompok_master/delete_all/(:num)/(:num)']    = 'kelompok_master/delete_all/$1/$2';

// Keluar
$route['keluar']                                 = 'keluar';
$route['keluar/index']                           = 'keluar';
$route['keluar/index/(:num)']                    = 'keluar/index/$1';
$route['keluar/index/(:num)/(:num)']             = 'keluar/index/$1/$2';
$route['keluar/clear']                           = 'keluar/clear';
$route['keluar/search']                          = 'keluar/search';
$route['keluar/perorangan']                      = 'keluar/perorangan';
$route['keluar/perorangan/(:num)']               = 'keluar/perorangan/$1';
$route['keluar/perorangan/(:num)/(:num)']        = 'keluar/perorangan/$1/$2';
$route['keluar/perorangan/(:num)/(:num)/(:num)'] = 'keluar/perorangan/$1/$2/$3';
$route['keluar/graph']                           = 'keluar/graph';
$route['keluar/filter']                          = 'keluar/filter';
$route['keluar/nik']                             = 'keluar/nik';

// Keluarga
$route['keluarga']                                            = 'keluarga';
$route['keluarga/index']                                      = 'keluarga';
$route['keluarga/index/(:num)']                               = 'keluarga/index/$1';
$route['keluarga/index/(:num)/(:num)']                        = 'keluarga/index/$1/$2';
$route['keluarga/clear']                                      = 'keluarga/clear';
$route['keluarga/sosial']                                     = 'keluarga/sosial';
$route['keluarga/sosial/(:num)']                              = 'keluarga/sosial/$1';
$route['keluarga/sosial/(:num)/(:num)']                       = 'keluarga/sosial/$1/$2';
$route['keluarga/raskin_graph']                               = 'keluarga/raskin_graph';
$route['keluarga/raskin_graph/(:num)']                        = 'keluarga/raskin_graph/$1';
$route['keluarga/raskin_graph/(:num)/(:num)']                 = 'keluarga/raskin_graph/$1/$2';
$route['keluarga/jamkesmas_graph']                            = 'keluarga/jamkesmas_graph';
$route['keluarga/jamkesmas_graph/(:num)']                     = 'keluarga/jamkesmas_graph/$1';
$route['keluarga/jamkesmas_graph/(:num)/(:num)']              = 'keluarga/jamkesmas_graph/$1/$2';
$route['keluarga/pentagon']                                   = 'keluarga/pentagon';
$route['keluarga/cetak']                                      = 'keluarga/cetak';
$route['keluarga/cetak/(:num)']                               = 'keluarga/cetak/$1';
$route['keluarga/excel']                                      = 'keluarga/excel';
$route['keluarga/excel/(:num)']                               = 'keluarga/excel/$1';
$route['keluarga/form']                                       = 'keluarga/form';
$route['keluarga/form/(:num)']                                = 'keluarga/form/$1';
$route['keluarga/form/(:num)/(:num)']                         = 'keluarga/form/$1/$2';
$route['keluarga/form_a/(:num)/(:num)/(:num)']                = 'keluarga/form_a/$1/$2/$3';
$route['keluarga/edit_nokk/(:num)/(:num)/(:num)']             = 'keluarga/edit_nokk/$1/$2/$3';
$route['keluarga/form_old/(:num)/(:num)/(:num)']              = 'keluarga/form_old/$1/$2/$3';
$route['keluarga/dusun']                                      = 'keluarga/dusun';
$route['keluarga/dusun/(:num)']                               = 'keluarga/dusun/$1';
$route['keluarga/rw']                                         = 'keluarga/rw';
$route['keluarga/rw/(:num)']                                  = 'keluarga/rw/$1';
$route['keluarga/rt']                                         = 'keluarga/rt';
$route['keluarga/rt/(:num)']                                  = 'keluarga/rt/$1';
$route['keluarga/raskin']                                     = 'keluarga/raskin';
$route['keluarga/sex']                                        = 'keluarga/sex';
$route['keluarga/blt']                                        = 'keluarga/blt';
$route['keluarga/bos']                                        = 'keluarga/bos';
$route['keluarga/search']                                     = 'keluarga/search';
$route['keluarga/insert']                                     = 'keluarga/insert';
$route['keluarga/insert_a']                                   = 'keluarga/insert_a';
$route['keluarga/insert_new']                                 = 'keluarga/insert_new';
$route['keluarga/update/(:any)']                              = 'keluarga/update/$1';
$route['keluarga/update_nokk/(:any)']                         = 'keluarga/update_nokk/$1';
$route['keluarga/delete/(:num)/(:num)/(:any)']                = 'keluarga/delete/$1/$2/$3';
$route['keluarga/delete_all/(:num)/(:num)']                   = 'keluarga/delete_all/$1/$2';
$route['keluarga/anggota/(:num)/(:num)/(:num)']               = 'keluarga/anggota/$1/$2/$3';
$route['keluarga/ajax_add_anggota/(:num)/(:num)/(:num)']      = 'keluarga/ajax_add_anggota/$1/$2/$3';
$route['keluarga/edit_anggota/(:num)/(:num)/(:num)/(:num)']   = 'keluarga/edit_anggota/$1/$2/$3/$4';
$route['keluarga/kartu_keluarga/(:num)/(:num)/(:num)']        = 'keluarga/kartu_keluarga/$1/$2/$3';
$route['keluarga/cetak_kk/(:num)']                            = 'keluarga/cetak_kk/$1';
$route['keluarga/doc_kk/(:num)']                              = 'keluarga/doc_kk/$1';
$route['keluarga/coba2/(:num)']                               = 'keluarga/coba2/$1';
$route['keluarga/add_anggota/(:num)/(:num)/(:num)']           = 'keluarga/add_anggota/$1/$2/$3';
$route['keluarga/update_anggota/(:num)/(:num)/(:num)/(:num)'] = 'keluarga/update_anggota/$1/$2/$3/$4';
$route['keluarga/delete_anggota/(:num)/(:num)/(:num)/(:any)'] = 'keluarga/delete_anggota/$1/$2/$3/$4';
$route['keluarga/delete_all_anggota/(:num)/(:num)/(:num)']    = 'keluarga/delete_all_anggota/$1/$2/$3';
$route['keluarga/pindah_proses/(:num)']                       = 'keluarga/pindah_proses/$1';
$route['keluarga/ajax_penduduk_pindah/(:num)']                = 'keluarga/ajax_penduduk_pindah/$1';
$route['keluarga/ajax_penduduk_pindah_rw']                    = 'keluarga/ajax_penduduk_pindah_rw';
$route['keluarga/ajax_penduduk_pindah_rw/(:any)']             = 'keluarga/ajax_penduduk_pindah_rw/$1';
$route['keluarga/ajax_penduduk_pindah_rt']                    = 'keluarga/ajax_penduduk_pindah_rt';
$route['keluarga/ajax_penduduk_pindah_rt/(:any)']             = 'keluarga/ajax_penduduk_pindah_rt/$1';
$route['keluarga/ajax_penduduk_pindah_rt/(:any)/(:any)']      = 'keluarga/ajax_penduduk_pindah_rt/$1/$2';
$route['keluarga/statistik/(:num)/(:num)/(:num)/(:num)']      = 'keluarga/statistik/$1/$2/$3/$4';
$route['keluarga/cetak_statistik/(:num)']                     = 'keluarga/cetak_statistik/$1';

// Komentar
$route['komentar']                             = 'komentar';
$route['komentar/index']                       = 'komentar';
$route['komentar/index/(:num)']                = 'komentar/index/$1';
$route['komentar/index/(:num)/(:num)']         = 'komentar/index/$1/$2';
$route['komentar/clear']                       = 'komentar/clear';
$route['komentar/form']                        = 'komentar/form';
$route['komentar/form/(:num)']                 = 'komentar/form/$1';
$route['komentar/form/(:num)/(:num)']          = 'komentar/form/$1/$2';
$route['komentar/form/(:num)/(:num)/(:any)']   = 'komentar/form/$1/$2/$3';
$route['komentar/search']                      = 'komentar/search';
$route['komentar/filter']                      = 'komentar/filter';
$route['komentar/insert']                      = 'komentar/insert';
$route['komentar/update/(:any)/(:num)/(:num)'] = 'komentar/update/$1/$2/$3';
$route['komentar/delete/(:num)/(:num)/(:any)'] = 'komentar/delete/$1/$2/$3';
$route['komentar/delete_all/(:num)/(:num)']    = 'komentar/delete_all/$1/$2';
$route['komentar/komentar_lock/(:any)']        = 'komentar/komentar_lock/$1';
$route['komentar/komentar_unlock/(:any)']      = 'komentar/komentar_unlock/$1';

// Lapor
$route['lapor']                             = 'lapor';
$route['lapor/index']                       = 'lapor';
$route['lapor/index/(:num)']                = 'lapor/index/$1';
$route['lapor/index/(:num)/(:num)']         = 'lapor/index/$1/$2';
$route['lapor/clear']                       = 'lapor/clear';
$route['lapor/form']                        = 'lapor/form';
$route['lapor/form/(:num)']                 = 'lapor/form/$1';
$route['lapor/form/(:num)/(:num)']          = 'lapor/form/$1/$2';
$route['lapor/form/(:num)/(:num)/(:any)']   = 'lapor/form/$1/$2/$3';
$route['lapor/search']                      = 'lapor/search';
$route['lapor/filter']                      = 'lapor/filter';
$route['lapor/insert']                      = 'lapor/insert';
$route['lapor/update/(:any)/(:num)/(:num)'] = 'lapor/update/$1/$2/$3';
$route['lapor/delete/(:num)/(:num)/(:any)'] = 'lapor/delete/$1/$2/$3';
$route['lapor/delete_all/(:num)/(:num)']    = 'lapor/delete_all/$1/$2';
$route['lapor/komentar_lock/(:any)']        = 'lapor/komentar_lock/$1';
$route['lapor/komentar_unlock/(:any)']      = 'lapor/komentar_unlock/$1';

// Laporan
$route['laporan']                            = 'laporan';
$route['laporan/index']                      = 'laporan';
$route['laporan/index/(:num)']               = 'laporan/index/$1';
$route['laporan/index/(:num)/(:num)']        = 'laporan/index/$1/$2';
$route['laporan/index/(:num)/(:num)/(:num)'] = 'laporan/index/$1/$2/$3';
$route['laporan/clear']                      = 'laporan/clear';
$route['laporan/cetak']                      = 'laporan/cetak';
$route['laporan/cetak/(:num)']               = 'laporan/cetak/$1';
$route['laporan/excel']                      = 'laporan/excel';
$route['laporan/excel/(:num)']               = 'laporan/excel/$1';
$route['laporan/bulan']                      = 'laporan/bulan';

// Laporan_rentan
$route['laporan_rentan']       = 'laporan_rentan';
$route['laporan_rentan/index'] = 'laporan_rentan';
$route['laporan_rentan/clear'] = 'laporan_rentan/clear';
$route['laporan_rentan/cetak'] = 'laporan_rentan/cetak';
$route['laporan_rentan/excel'] = 'laporan_rentan/excel';
$route['laporan_rentan/dusun'] = 'laporan_rentan/dusun';

// Line
$route['line']                                    = 'line';
$route['line/index']                              = 'line';
$route['line/index/(:num)']                       = 'line/index/$1';
$route['line/index/(:num)/(:num)']                = 'line/index/$1/$2';
$route['line/clear']                              = 'line/clear';
$route['line/form']                               = 'line/form';
$route['line/form/(:num)']                        = 'line/form/$1';
$route['line/form/(:num)/(:num)']                 = 'line/form/$1/$2';
$route['line/form/(:num)/(:num)/(:any)']          = 'line/form/$1/$2/$3';
$route['line/sub_line']                           = 'line/sub_line';
$route['line/sub_line/(:num)']                    = 'line/sub_line/$1';
$route['line/ajax_add_sub_line']                  = 'line/ajax_add_sub_line';
$route['line/ajax_add_sub_line/(:num)']           = 'line/ajax_add_sub_line/$1';
$route['line/ajax_add_sub_line/(:num)/(:num)']    = 'line/ajax_add_sub_line/$1/$2';
$route['line/search']                             = 'line/search';
$route['line/filter']                             = 'line/filter';
$route['line/insert']                             = 'line/insert';
$route['line/insert/(:num)']                      = 'line/insert/$1';
$route['line/update/(:any)/(:num)/(:num)']        = 'line/update/$1/$2/$3';
$route['line/delete/(:num)/(:num)/(:any)']        = 'line/delete/$1/$2/$3';
$route['line/delete_all/(:num)/(:num)']           = 'line/delete_all/$1/$2';
$route['line/line_lock/(:any)']                   = 'line/line_lock/$1';
$route['line/line_unlock/(:any)']                 = 'line/line_unlock/$1';
$route['line/insert_sub_line/(:any)']             = 'line/insert_sub_line/$1';
$route['line/update_sub_line/(:any)/(:any)']      = 'line/update_sub_line/$1/$2';
$route['line/delete_sub_line/(:any)/(:any)']      = 'line/delete_sub_line/$1/$2';
$route['line/delete_all_sub_line/(:any)']         = 'line/delete_all_sub_line/$1';
$route['line/line_lock_sub_line/(:any)/(:any)']   = 'line/line_lock_sub_line/$1/$2';
$route['line/line_unlock_sub_line/(:any)/(:any)'] = 'line/line_unlock_sub_line/$1/$2';

// Main
$route['main']             = 'main';
$route['main/index']       = 'main';
$route['main/initial']     = 'main/initial';
$route['main/install']     = 'main/install';
$route['main/init']        = 'main/init';
$route['main/init/(:any)'] = 'main/init/$1';
$route['main/auth']        = 'main/auth';
$route['main/logout']      = 'main/logout';

// Man_user
$route['man_user']                             = 'man_user';
$route['man_user/index']                       = 'man_user';
$route['man_user/index/(:num)']                = 'man_user/index/$1';
$route['man_user/index/(:num)/(:num)']         = 'man_user/index/$1/$2';
$route['man_user/clear']                       = 'man_user/clear';
$route['man_user/form']                        = 'man_user/form';
$route['man_user/form/(:num)']                 = 'man_user/form/$1';
$route['man_user/form/(:num)/(:num)']          = 'man_user/form/$1/$2';
$route['man_user/form/(:num)/(:num)/(:any)']   = 'man_user/form/$1/$2/$3';
$route['man_user/search']                      = 'man_user/search';
$route['man_user/filter']                      = 'man_user/filter';
$route['man_user/insert']                      = 'man_user/insert';
$route['man_user/update/(:num)/(:num)/(:any)'] = 'man_user/update/$1/$2/$3';
$route['man_user/delete/(:num)/(:num)/(:any)'] = 'man_user/delete/$1/$2/$3';
$route['man_user/delete_all/(:num)/(:num)']    = 'man_user/delete_all/$1/$2';
$route['man_user/user_lock/(:any)']            = 'man_user/user_lock/$1';
$route['man_user/user_unlock/(:any)']          = 'man_user/user_unlock/$1';

// Mandiri
$route['mandiri']                               = 'mandiri';
$route['mandiri/index']                         = 'mandiri';
$route['mandiri/index/(:num)']                  = 'mandiri/index/$1';
$route['mandiri/index/(:num)/(:num)']           = 'mandiri/index/$1/$2';
$route['mandiri/clear']                         = 'mandiri/clear';
$route['mandiri/ajax_pin']                      = 'mandiri/ajax_pin';
$route['mandiri/ajax_pin/(:num)']               = 'mandiri/ajax_pin/$1';
$route['mandiri/ajax_pin/(:num)/(:num)']        = 'mandiri/ajax_pin/$1/$2';
$route['mandiri/ajax_pin/(:num)/(:num)/(:num)'] = 'mandiri/ajax_pin/$1/$2/$3';
$route['mandiri/search']                        = 'mandiri/search';
$route['mandiri/filter']                        = 'mandiri/filter';
$route['mandiri/nik']                           = 'mandiri/nik';
$route['mandiri/insert']                        = 'mandiri/insert';
$route['mandiri/ajax_pin_show']                 = 'mandiri/ajax_pin_show';
$route['mandiri/ajax_pin_show/(:any)']          = 'mandiri/ajax_pin_show/$1';

// Menu
$route['menu']                                           = 'menu';
$route['menu/index']                                     = 'menu';
$route['menu/index/(:num)']                              = 'menu/index/$1';
$route['menu/index/(:num)/(:num)']                       = 'menu/index/$1';
$route['menu/index/(:num)/(:num)/(:num)']                = 'menu/index/$1/$2/$3';
$route['menu/clear']                                     = 'menu/clear';
$route['menu/form']                                      = 'menu/form';
$route['menu/form/(:num)']                               = 'menu/form/$1';
$route['menu/form/(:num)/(:any)']                        = 'menu/form/$1/$2';
$route['menu/sub_menu/(:num)']                           = 'menu/sub_menu/$1';
$route['menu/sub_menu/(:num)/(:num)']                    = 'menu/sub_menu/$1/$2';
$route['menu/ajax_add_sub_menu']                         = 'menu/ajax_add_sub_menu';
$route['menu/ajax_add_sub_menu/(:num)']                  = 'menu/ajax_add_sub_menu/$1';
$route['menu/ajax_add_sub_menu/(:num)/(:any)']           = 'menu/ajax_add_sub_menu/$1/$2';
$route['menu/ajax_add_sub_menu/(:num)/(:any)/(:any)']    = 'menu/ajax_add_sub_menu/$1/$2/$3';
$route['menu/search']                                    = 'menu/search';
$route['menu/search/(:num)']                             = 'menu/search/$1';
$route['menu/filter']                                    = 'menu/filter';
$route['menu/insert']                                    = 'menu/insert';
$route['menu/insert/(:num)']                             = 'menu/insert/$1';
$route['menu/update/(:num)/(:any)']                      = 'menu/update/$1/$2';
$route['menu/delete/(:num)/(:any)']                      = 'menu/delete/$1/$2';
$route['menu/delete_all/(:num)/(:num)/(:num)']           = 'menu/delete_all/$1/$2/$3';
$route['menu/menu_lock/(:num)/(:any)']                   = 'menu/menu_lock/$1/$2';
$route['menu/menu_unlock/(:num)/(:any)']                 = 'menu/menu_unlock/$1/$2';
$route['menu/insert_sub_menu/(:num)/(:any)']             = 'menu/insert_sub_menu/$1/$2';
$route['menu/update_sub_menu/(:num)/(:any)/(:any)']      = 'menu/update_sub_menu/$1/$2/$3';
$route['menu/delete_sub_menu']                           = 'menu/delete_sub_menu';
$route['menu/delete_sub_menu/(:any)']                    = 'menu/delete_sub_menu/$1';
$route['menu/delete_sub_menu/(:any)/(:any)']             = 'menu/delete_sub_menu/$1/$2';
$route['menu/delete_sub_menu/(:any)/(:any)/(:num)']      = 'menu/delete_sub_menu/$1/$2/$3';
$route['menu/delete_all_sub_menu/(:num)/(:any)']         = 'menu/delete_all_sub_menu/$1/$2';
$route['menu/menu_lock_sub_menu/(:num)/(:any)/(:any)']   = 'menu/menu_lock_sub_menu/$1/$2/$3';
$route['menu/menu_unlock_sub_menu/(:num)/(:any)/(:any)'] = 'menu/menu_unlock_sub_menu/$1/$2/$3';

// Modul
$route['modul']               = 'modul';
$route['modul/index']         = 'modul';
$route['modul/clear']         = 'modul/clear';
$route['modul/form']          = 'modul/form';
$route['modul/form/(:any)']   = 'modul/form/$1';
$route['modul/filter']        = 'modul/filter';
$route['modul/search']        = 'modul/search';
$route['modul/insert']        = 'modul/insert';
$route['modul/update/(:any)'] = 'modul/update/$1';
$route['modul/delete/(:any)'] = 'modul/delete/$1';
$route['modul/delete_all']    = 'modul/delete_all';

// Penduduk
$route['penduduk']                                          = 'penduduk';
$route['penduduk/index']                                    = 'penduduk';
$route['penduduk/index/(:num)']                             = 'penduduk/index/$1';
$route['penduduk/index/(:num)/(:num)']                      = 'penduduk/index/$1/$2';
$route['penduduk/clear']                                    = 'penduduk/clear';
$route['penduduk/form']                                     = 'penduduk/form';
$route['penduduk/form/(:num)']                              = 'penduduk/form/$1';
$route['penduduk/form/(:num)/(:num)']                       = 'penduduk/form/$1/$2';
$route['penduduk/form/(:num)/(:num)/(:any)']                = 'penduduk/form/$1/$2/$3';
$route['penduduk/detail/(:num)/(:num)/(:any)']              = 'penduduk/detail/$1/$2/$3';
$route['penduduk/dokumen/(:any)']                           = 'penduduk/dokumen/$1';
$route['penduduk/dokumen_form']                             = 'penduduk/dokumen_form';
$route['penduduk/dokumen_form/(:num)']                      = 'penduduk/dokumen_form/$1';
$route['penduduk/dokumen_list']                             = 'penduduk/dokumen_list';
$route['penduduk/dokumen_list/(:num)']                      = 'penduduk/dokumen_list/$1';
$route['penduduk/dokumen_insert']                           = 'penduduk/dokumen_insert';
$route['penduduk/delete_dokumen/(:num)/(:any)']             = 'penduduk/delete_dokumen/$1/$2';
$route['penduduk/delete_all_dokumen']                       = 'penduduk/delete_all_dokumen';
$route['penduduk/delete_all_dokumen/(:num)']                = 'penduduk/delete_all_dokumen/$1';
$route['penduduk/cetak_biodata/(:any)']                     = 'penduduk/cetak_biodata/$1';
$route['penduduk/search']                                   = 'penduduk/search';
$route['penduduk/filter']                                   = 'penduduk/filter';
$route['penduduk/duplikat']                                 = 'penduduk/duplikat';
$route['penduduk/status_dasar']                             = 'penduduk/status_dasar';
$route['penduduk/sex']                                      = 'penduduk/sex';
$route['penduduk/agama']                                    = 'penduduk/agama';
$route['penduduk/warganegara']                              = 'penduduk/warganegara';
$route['penduduk/dusun']                                    = 'penduduk/dusun';
$route['penduduk/rw']                                       = 'penduduk/rw';
$route['penduduk/rt']                                       = 'penduduk/rt';
$route['penduduk/insert']                                   = 'penduduk/insert';
$route['penduduk/update/(:num)/(:num)/(:any)']              = 'penduduk/update/$1/$2/$3';
$route['penduduk/delete_confirm/(:num)/(:num)/(:any)']      = 'penduduk/delete_confirm/$1/$2/$3';
$route['penduduk/delete/(:num)/(:num)/(:any)']              = 'penduduk/delete/$1/$2/$3';
$route['penduduk/delete_all/(:num)/(:num)']                 = 'penduduk/delete_all/$1/$2';
$route['penduduk/ajax_adv_search']                          = 'penduduk/ajax_adv_search';
$route['penduduk/adv_search_proses']                        = 'penduduk/adv_search_proses';
$route['penduduk/ajax_penduduk_pindah']                     = 'penduduk/ajax_penduduk_pindah';
$route['penduduk/ajax_penduduk_pindah/(:num)']              = 'penduduk/ajax_penduduk_pindah/$1';
$route['penduduk/ajax_penduduk_pindah_rw']                  = 'penduduk/ajax_penduduk_pindah_rw';
$route['penduduk/ajax_penduduk_pindah_rw/(:any)']           = 'penduduk/ajax_penduduk_pindah_rw/$1';
$route['penduduk/ajax_penduduk_pindah_rt']                  = 'penduduk/ajax_penduduk_pindah_rt';
$route['penduduk/ajax_penduduk_pindah_rt/(:any)']           = 'penduduk/ajax_penduduk_pindah_rt/$1';
$route['penduduk/ajax_penduduk_pindah_rt/(:any)/(:any)']    = 'penduduk/ajax_penduduk_pindah_rt/$1/$2';
$route['penduduk/ajax_penduduk_cari_rw']                    = 'penduduk/ajax_penduduk_cari_rw';
$route['penduduk/ajax_penduduk_cari_rw/(:any)']             = 'penduduk/ajax_penduduk_cari_rw/$1';
$route['penduduk/ajax_penduduk_cari_rt']                    = 'penduduk/ajax_penduduk_cari_rt';
$route['penduduk/ajax_penduduk_cari_rt/(:any)']             = 'penduduk/ajax_penduduk_cari_rt/$1';
$route['penduduk/ajax_penduduk_cari_rt/(:any)/(:any)']      = 'penduduk/ajax_penduduk_cari_rt/$1/$2';
$route['penduduk/pindah_proses/(:num)']                     = 'penduduk/pindah_proses/$1';
$route['penduduk/ajax_penduduk_maps/(:num)/(:num)/(:any)']  = 'penduduk/ajax_penduduk_maps/$1/$2/$3';
$route['penduduk/update_maps/(:num)/(:num)/(:any)']         = 'penduduk/update_maps/$1/$2/$3';
$route['penduduk/wilayah_sel/(:num)/(:num)/(:any)']         = 'penduduk/wilayah_sel/$1/$2/$3';
$route['penduduk/edit_status_dasar/(:num)/(:num)/(:num)']   = 'penduduk/edit_status_dasar/$1/$2/$3';
$route['penduduk/update_status_dasar/(:num)/(:num)/(:any)'] = 'penduduk/update_status_dasar/$1/$2/$3';
$route['penduduk/cetak']                                    = 'penduduk/cetak';
$route['penduduk/cetak/(:num)']                             = 'penduduk/cetak/$1';
$route['penduduk/excel']                                    = 'penduduk/excel';
$route['penduduk/excel/(:num)']                             = 'penduduk/excel/$1';
$route['penduduk/statistik']                                = 'penduduk/statistik';
$route['penduduk/statistik/(:any)']                         = 'penduduk/statistik/$1';
$route['penduduk/statistik/(:any)/(:any)']                  = 'penduduk/statistik/$1/$2';
$route['penduduk/statistik/(:any)/(:any)/(:any)']           = 'penduduk/statistik/$1/$2/$3';
$route['penduduk/lap_statistik']                            = 'penduduk/lap_statistik';
$route['penduduk/lap_statistik/(:num)']                     = 'penduduk/lap_statistik/$1';
$route['penduduk/lap_statistik/(:num)/(:num)']              = 'penduduk/lap_statistik/$1/$2';
$route['penduduk/lap_statistik/(:num)/(:num)/(:num)']       = 'penduduk/lap_statistik/$1/$2/$3';
$route['penduduk/coba2/(:num)']                             = 'penduduk/coba2/$1';

// Penduduk_log
$route['penduduk_log']                                          = 'penduduk_log';
$route['penduduk_log/index']                                    = 'penduduk_log';
$route['penduduk_log/index/(:num)']                             = 'penduduk_log/index/$1';
$route['penduduk_log/index/(:num)/(:num)']                      = 'penduduk_log/index/$1/$2';
$route['penduduk_log/clear']                                    = 'penduduk_log/clear';
$route['penduduk_log/search']                                   = 'penduduk_log/search';
$route['penduduk_log/filter']                                   = 'penduduk_log/filter';
$route['penduduk_log/sex']                                      = 'penduduk_log/sex';
$route['penduduk_log/agama']                                    = 'penduduk_log/agama';
$route['penduduk_log/dusun']                                    = 'penduduk_log/dusun';
$route['penduduk_log/rw']                                       = 'penduduk_log/rw';
$route['penduduk_log/rt']                                       = 'penduduk_log/rt';
$route['penduduk_log/edit_status_dasar/(:num)/(:num)/(:num)']   = 'penduduk_log/edit_status_dasar/$1/$2/$3';
$route['penduduk_log/update_status_dasar/(:num)/(:num)/(:any)'] = 'penduduk_log/update_status_dasar/$1/$2/$3';
$route['penduduk_log/cetak']                                    = 'penduduk_log/cetak';
$route['penduduk_log/cetak/(:num)']                             = 'penduduk_log/cetak/$1';
$route['penduduk_log/delete_all/(:num)/(:num)']                 = 'penduduk_log/delete_all/$1/$2';

// Pengurus
$route['pengurus']               = 'pengurus';
$route['pengurus/index']         = 'pengurus';
$route['pengurus/clear']         = 'pengurus/clear';
$route['pengurus/form']          = 'pengurus/form';
$route['pengurus/form/(:any)']   = 'pengurus/form/$1';
$route['pengurus/filter']        = 'pengurus/filter';
$route['pengurus/search']        = 'pengurus/search';
$route['pengurus/insert']        = 'pengurus/insert';
$route['pengurus/update/(:any)'] = 'pengurus/update/$1';
$route['pengurus/delete/(:any)'] = 'pengurus/delete/$1';
$route['pengurus/delete_all']    = 'pengurus/delete_all';

// Plan
$route['plan']                                       = 'plan';
$route['plan/index']                                 = 'plan';
$route['plan/index/(:num)']                          = 'plan/index/$1';
$route['plan/index/(:num)/(:num)']                   = 'plan/index/$1/$2';
$route['plan/clear']                                 = 'plan/clear';
$route['plan/form']                                  = 'plan/form';
$route['plan/form/(:num)']                           = 'plan/form/$1';
$route['plan/form/(:num)/(:num)']                    = 'plan/form/$1/$2';
$route['plan/form/(:num)/(:num)/(:any)']             = 'plan/form/$1/$2/$3';
$route['plan/ajax_lokasi_maps']                      = 'plan/ajax_lokasi_maps';
$route['plan/ajax_lokasi_maps/(:num)']               = 'plan/ajax_lokasi_maps/$1';
$route['plan/ajax_lokasi_maps/(:num)/(:num)']        = 'plan/ajax_lokasi_maps/$1/$2';
$route['plan/ajax_lokasi_maps/(:num)/(:num)/(:any)'] = 'plan/ajax_lokasi_maps/$1/$2/$3';
$route['plan/update_maps/(:num)/(:num)/(:any)']      = 'plan/update_maps/$1/$2/$3';
$route['plan/search']                                = 'plan/search';
$route['plan/filter']                                = 'plan/filter';
$route['plan/point']                                 = 'plan/point';
$route['plan/subpoint']                              = 'plan/subpoint';
$route['plan/insert']                                = 'plan/insert';
$route['plan/insert/(:num)']                         = 'plan/insert/$1';
$route['plan/update/(:any)/(:num)/(:num)']           = 'plan/update/$1/$2/$3';
$route['plan/delete/(:num)/(:num)/(:any)']           = 'plan/delete/$1/$2/$3';
$route['plan/delete_all/(:num)/(:num)']              = 'plan/delete_all/$1/$2';
$route['plan/lokasi_lock/(:any)']                    = 'plan/lokasi_lock/$1';
$route['plan/lokasi_unlock/(:any)']                  = 'plan/lokasi_unlock/$1';

// Point
$route['point']                                      = 'point';
$route['point/index']                                = 'point';
$route['point/index/(:num)']                         = 'point/index/$1';
$route['point/index/(:num)/(:num)']                  = 'point/index/$1/$2';
$route['point/clear']                                = 'point/clear';
$route['point/form']                                 = 'point/form';
$route['point/form/(:num)']                          = 'point/form/$1';
$route['point/form/(:num)/(:num)']                   = 'point/form/$1/$2';
$route['point/form/(:num)/(:num)/(:any)']            = 'point/form/$1/$2/$3';
$route['point/sub_point']                            = 'point/sub_point';
$route['point/sub_point/(:num)']                     = 'point/sub_point/$1';
$route['point/ajax_add_sub_point']                   = 'point/ajax_add_sub_point';
$route['point/ajax_add_sub_point/(:num)']            = 'point/ajax_add_sub_point/$1';
$route['point/ajax_add_sub_point/(:num)/(:num)']     = 'point/ajax_add_sub_point/$1/$2';
$route['point/search']                               = 'point/search';
$route['point/filter']                               = 'point/filter';
$route['point/insert']                               = 'point/insert';
$route['point/insert/(:num)']                        = 'point/insert/$1';
$route['point/update/(:any)/(:num)/(:num)']          = 'point/update/$1/$2/$3';
$route['point/delete/(:num)/(:num)/(:any)']          = 'point/delete/$1/$2/$3';
$route['point/delete_all/(:num)/(:num)']             = 'point/delete_all/$1/$2';
$route['point/point_lock/(:any)']                    = 'point/point_lock/$1';
$route['point/point_unlock/(:any)']                  = 'point/point_unlock/$1';
$route['point/insert_sub_point/(:any)']              = 'point/insert_sub_point/$1';
$route['point/update_sub_point/(:any)/(:any)']       = 'point/update_sub_point/$1/$2';
$route['point/delete_sub_point/(:any)/(:any)']       = 'point/delete_sub_point/$1/$2';
$route['point/delete_all_sub_point/(:any)']          = 'point/delete_all_sub_point/$1';
$route['point/point_lock_sub_point/(:any)/(:any)']   = 'point/point_lock_sub_point/$1/$2';
$route['point/point_unlock_sub_point/(:any)/(:any)'] = 'point/point_unlock_sub_point/$1/$2';

// Polygon
$route['polygon']                                          = 'polygon';
$route['polygon/index']                                    = 'polygon';
$route['polygon/index/(:num)']                             = 'polygon/index/$1';
$route['polygon/index/(:num)/(:num)']                      = 'polygon/index/$1/$2';
$route['polygon/clear']                                    = 'polygon/clear';
$route['polygon/form']                                     = 'polygon/form';
$route['polygon/form/(:num)']                              = 'polygon/form/$1';
$route['polygon/form/(:num)/(:num)']                       = 'polygon/form/$1/$2';
$route['polygon/form/(:num)/(:num)/(:any)']                = 'polygon/form/$1/$2/$3';
$route['polygon/sub_polygon']                              = 'polygon/sub_polygon';
$route['polygon/sub_polygon/(:num)']                       = 'polygon/sub_polygon/$1';
$route['polygon/ajax_add_sub_polygon']                     = 'polygon/ajax_add_sub_polygon';
$route['polygon/ajax_add_sub_polygon/(:num)']              = 'polygon/ajax_add_sub_polygon/$1';
$route['polygon/ajax_add_sub_polygon/(:num)/(:num)']       = 'polygon/ajax_add_sub_polygon/$1/$2';
$route['polygon/search']                                   = 'polygon/search';
$route['polygon/filter']                                   = 'polygon/filter';
$route['polygon/insert']                                   = 'polygon/insert';
$route['polygon/insert/(:num)']                            = 'polygon/insert/$1';
$route['polygon/update/(:any)/(:num)/(:num)']              = 'polygon/update/$1/$2/$3';
$route['polygon/delete/(:num)/(:num)/(:any)']              = 'polygon/delete/$1/$2/$3';
$route['polygon/delete_all/(:num)/(:num)']                 = 'polygon/delete_all/$1/$2';
$route['polygon/polygon_lock/(:any)']                      = 'polygon/polygon_lock/$1';
$route['polygon/polygon_unlock/(:any)']                    = 'polygon/polygon_unlock/$1';
$route['polygon/insert_sub_polygon/(:any)']                = 'polygon/insert_sub_polygon/$1';
$route['polygon/update_sub_polygon/(:any)/(:any)']         = 'polygon/update_sub_polygon/$1/$2';
$route['polygon/delete_sub_polygon/(:any)/(:any)']         = 'polygon/delete_sub_polygon/$1/$2';
$route['polygon/delete_all_sub_polygon/(:any)']            = 'polygon/delete_all_sub_polygon/$1';
$route['polygon/polygon_lock_sub_polygon/(:any)/(:any)']   = 'polygon/polygon_lock_sub_polygon/$1/$2';
$route['polygon/polygon_unlock_sub_polygon/(:any)/(:any)'] = 'polygon/polygon_unlock_sub_polygon/$1/$2';

// Program_bantuan
$route['program_bantuan']                       = 'program_bantuan';
$route['program_bantuan/index']                 = 'program_bantuan';
$route['program_bantuan/sasaran']               = 'program_bantuan/sasaran';
$route['program_bantuan/sasaran/(:num)']        = 'program_bantuan/sasaran/$1';
$route['program_bantuan/detail/(:any)']         = 'program_bantuan/detail/$1';
$route['program_bantuan/peserta']               = 'program_bantuan/peserta';
$route['program_bantuan/peserta/(:num)']        = 'program_bantuan/peserta/$1';
$route['program_bantuan/peserta/(:num)/(:num)'] = 'program_bantuan/peserta/$1/$2';
$route['program_bantuan/create']                = 'program_bantuan/create';
$route['program_bantuan/edit/(:any)']           = 'program_bantuan/edit/$1';
$route['program_bantuan/update/(:any)']         = 'program_bantuan/update/$1';
$route['program_bantuan/hapus/(:any)']          = 'program_bantuan/hapus/$1';
$route['program_bantuan/unduhsheet']            = 'program_bantuan/unduhsheet';
$route['program_bantuan/unduhsheet/(:num)']     = 'program_bantuan/unduhsheet/$1';

// Rtm
$route['rtm']                                            = 'rtm';
$route['rtm/index']                                      = 'rtm';
$route['rtm/index/(:num)']                               = 'rtm/index/$1';
$route['rtm/index/(:num)/(:num)']                        = 'rtm/index/$1/$2';
$route['rtm/clear']                                      = 'rtm/clear';
$route['rtm/cetak']                                      = 'rtm/cetak';
$route['rtm/cetak/(:num)']                               = 'rtm/cetak/$1';
$route['rtm/excel']                                      = 'rtm/excel';
$route['rtm/excel/(:num)']                               = 'rtm/excel/$1';
$route['rtm/excel_pbdt']                                 = 'rtm/excel_pbdt';
$route['rtm/excel_pbdt/(:num)']                          = 'rtm/excel_pbdt/$1';
$route['rtm/edit_nokk/(:num)/(:num)/(:num)']             = 'rtm/edit_nokk/$1/$2/$3';
$route['rtm/form_old/(:num)/(:num)/(:num)']              = 'rtm/form_old/$1/$2/$3';
$route['rtm/dusun']                                      = 'rtm/dusun';
$route['rtm/dusun/(:num)']                               = 'rtm/dusun/$1';
$route['rtm/rw']                                         = 'rtm/rw';
$route['rtm/rw/(:num)']                                  = 'rtm/rw/$1';
$route['rtm/rt']                                         = 'rtm/rt';
$route['rtm/rt/(:num)']                                  = 'rtm/rt/$1';
$route['rtm/raskin']                                     = 'rtm/raskin';
$route['rtm/blt']                                        = 'rtm/blt';
$route['rtm/bos']                                        = 'rtm/bos';
$route['rtm/search']                                     = 'rtm/search';
$route['rtm/insert']                                     = 'rtm/insert';
$route['rtm/insert_by_kk']                               = 'rtm/insert_by_kk';
$route['rtm/insert_a']                                   = 'rtm/insert_a';
$route['rtm/insert_new']                                 = 'rtm/insert_new';
$route['rtm/update/(:any)']                              = 'rtm/update/$1';
$route['rtm/update_nokk/(:any)']                         = 'rtm/update_nokk/$1';
$route['rtm/delete/(:num)/(:num)/(:any)']                = 'rtm/delete/$1/$2/$3';
$route['rtm/delete_all/(:num)/(:num)']                   = 'rtm/delete_all/$1/$2';
$route['rtm/anggota/(:num)/(:num)/(:num)']               = 'rtm/anggota/$1/$2/$3';
$route['rtm/ajax_add_anggota/(:num)/(:num)/(:num)']      = 'rtm/ajax_add_anggota/$1/$2/$3';
$route['rtm/edit_anggota/(:num)/(:num)/(:num)/(:num)']   = 'rtm/edit_anggota/$1/$2/$3/$4';
$route['rtm/kartu_rtm/(:num)/(:num)/(:num)']             = 'rtm/kartu_rtm/$1/$2/$3';
$route['rtm/cetak_kk/(:num)']                            = 'rtm/cetak_kk/$1';
$route['rtm/add_anggota/(:num)/(:num)/(:num)']           = 'rtm/add_anggota/$1/$2/$3';
$route['rtm/update_anggota/(:num)/(:num)/(:num)/(:num)'] = 'rtm/update_anggota/$1/$2/$3/$4';
$route['rtm/delete_anggota/(:num)/(:num)/(:num)/(:any)'] = 'rtm/delete_anggota/$1/$2/$3/$4';
$route['rtm/delete_all_anggota/(:num)/(:num)/(:num)']    = 'rtm/delete_all_anggota/$1/$2/$3';
$route['rtm/cetak_statistik/(:num)']                     = 'rtm/cetak_statistik/$1';

// Sid_core
$route['sid_core']                                    = 'sid_core';
$route['sid_core/index']                              = 'sid_core';
$route['sid_core/index/(:num)']                       = 'sid_core/index/$1';
$route['sid_core/index/(:num)/(:num)']                = 'sid_core/index/$1/$2';
$route['sid_core/clear']                              = 'sid_core/clear';
$route['sid_core/cetak']                              = 'sid_core/cetak';
$route['sid_core/excel']                              = 'sid_core/excel';
$route['sid_core/form']                               = 'sid_core/form';
$route['sid_core/form/(:any)']                        = 'sid_core/form/$1';
$route['sid_core/search']                             = 'sid_core/search';
$route['sid_core/insert']                             = 'sid_core/insert';
$route['sid_core/insert/(:any)']                      = 'sid_core/insert/$1';
$route['sid_core/update/(:any)']                      = 'sid_core/update/$1';
$route['sid_core/delete/(:any)']                      = 'sid_core/delete/$1';
$route['sid_core/delete_all']                         = 'sid_core/delete_all';
$route['sid_core/sub_rw/(:any)']                      = 'sid_core/sub_rw/$1';
$route['sid_core/cetak_rw/(:any)']                    = 'sid_core/cetak_rw/$1';
$route['sid_core/excel_rw/(:any)']                    = 'sid_core/excel_rw/$1';
$route['sid_core/form_rw']                            = 'sid_core/form_rw';
$route['sid_core/form_rw/(:any)']                     = 'sid_core/form_rw/$1';
$route['sid_core/form_rw/(:any)/(:any)']              = 'sid_core/form_rw/$1/$2';
$route['sid_core/insert_rw/(:any)']                   = 'sid_core/insert_rw/$1';
$route['sid_core/update_rw/(:any)/(:any)']            = 'sid_core/update_rw/$1/$2';
$route['sid_core/delete_rw/(:any)/(:any)']            = 'sid_core/delete_rw/$1/$2';
$route['sid_core/delete_all_rw']                      = 'sid_core/delete_all_rw';
$route['sid_core/delete_all_rw/(:any)']               = 'sid_core/delete_all_rw/$1';
$route['sid_core/sub_rt/(:any)/(:any)']               = 'sid_core/sub_rt/$1/$2';
$route['sid_core/cetak_rt/(:any)/(:any)']             = 'sid_core/cetak_rt/$1/$2';
$route['sid_core/excel_rt/(:any)/(:any)']             = 'sid_core/excel_rt/$1/$2';
$route['sid_core/list_dusun_rt']                      = 'sid_core/list_dusun_rt';
$route['sid_core/list_dusun_rt/(:any)']               = 'sid_core/list_dusun_rt/$1';
$route['sid_core/list_dusun_rt/(:any)/(:any)']        = 'sid_core/list_dusun_rt/$1/$2';
$route['sid_core/form_rt']                            = 'sid_core/form_rt';
$route['sid_core/form_rt/(:any)']                     = 'sid_core/form_rt/$1';
$route['sid_core/form_rt/(:any)/(:any)']              = 'sid_core/form_rt/$1/$2';
$route['sid_core/form_rt/(:any)/(:any)/(:any)']       = 'sid_core/form_rt/$1/$2/$3';
$route['sid_core/insert_rt/(:any)/(:any)']            = 'sid_core/insert_rt/$1/$2';
$route['sid_core/update_rt/(:any)/(:any)/(:num)']     = 'sid_core/update_rt/$1/$2/$3';
$route['sid_core/delete_rt/(:any)']                   = 'sid_core/delete_rt/$1';
$route['sid_core/delete_all_rt']                      = 'sid_core/delete_all_rt';
$route['sid_core/cetakx']                             = 'sid_core/cetakx';
$route['sid_core/ajax_wil_maps']                      = 'sid_core/ajax_wil_maps';
$route['sid_core/ajax_wil_maps/(:num)']               = 'sid_core/ajax_wil_maps/$1';
$route['sid_core/update_dusun_map']                   = 'sid_core/update_dusun_map';
$route['sid_core/update_dusun_map/(:num)']            = 'sid_core/update_dusun_map/$1';
$route['sid_core/ajax_rw_maps/(:num)/(:num)']         = 'sid_core/ajax_rw_maps/$1/$2';
$route['sid_core/update_rw_map/(:num)/(:num)']        = 'sid_core/update_rw_map/$1/$2';
$route['sid_core/ajax_rt_maps/(:num)/(:num)/(:num)']  = 'sid_core/ajax_rt_maps/$1/$2/$3';
$route['sid_core/update_rt_map/(:num)/(:num)/(:num)'] = 'sid_core/update_rt_map/$1/$2/$3';
$route['sid_core/warga/(:any)']                       = 'sid_core/warga/$1';
$route['sid_core/warga_kk/(:any)']                    = 'sid_core/warga_kk/$1';
$route['sid_core/warga_l/(:any)']                     = 'sid_core/warga_l/$1';
$route['sid_core/warga_p/(:any)']                     = 'sid_core/warga_p/$1';
$route['sid_core/migrate']                            = 'sid_core/migrate';
$route['sid_core/pre_migrate']                        = 'sid_core/pre_migrate';

// Siteman
$route['siteman']       = 'siteman';
$route['siteman/index'] = 'siteman';
$route['siteman/auth']  = 'siteman/auth';
$route['siteman/login'] = 'siteman/login';

// Sms
$route['sms']                                    = 'sms';
$route['sms/index']                              = 'sms';
$route['sms/index/(:num)']                       = 'sms/index/$1';
$route['sms/index/(:num)/(:num)']                = 'sms/index/$1/$2';
$route['sms/clear']                              = 'sms/clear';
$route['sms/setting']                            = 'sms/setting';
$route['sms/setting/(:num)']                     = 'sms/setting/$1';
$route['sms/setting/(:num)/(:num)']              = 'sms/setting/$1/$2';
$route['sms/insert_autoreply']                   = 'sms/insert_autoreply';
$route['sms/polling']                            = 'sms/polling';
$route['sms/polling/(:num)']                     = 'sms/polling/$1';
$route['sms/polling/(:num)/(:num)']              = 'sms/polling/$1/$2';
$route['sms/outbox']                             = 'sms/outbox';
$route['sms/outbox/(:num)']                      = 'sms/outbox/$1';
$route['sms/outbox/(:num)/(:num)']               = 'sms/outbox/$1/$2';
$route['sms/sentitem']                           = 'sms/sentitem';
$route['sms/sentitem/(:num)']                    = 'sms/sentitem/$1';
$route['sms/sentitem/(:num)/(:num)']             = 'sms/sentitem/$1/$2';
$route['sms/pending']                            = 'sms/pending';
$route['sms/pending/(:num)']                     = 'sms/pending/$1';
$route['sms/pending/(:num)/(:num)']              = 'sms/pending/$1/$2';
$route['sms/form/(:num)/(:num)/(:num)/(:num)']   = 'sms/form/$1/$2/$3/$4';
$route['sms/carikontak']                         = 'sms/carikontak';
$route['sms/carikontak/(:num)']                  = 'sms/carikontak/$1';
$route['sms/formaftercari']                      = 'sms/formaftercari';
$route['sms/formaftercari/(:num)']               = 'sms/formaftercari/$1';
$route['sms/send_broadcast']                     = 'sms/send_broadcast';
$route['sms/broadcast_proses']                   = 'sms/broadcast_proses';
$route['sms/broadcast']                          = 'sms/broadcast';
$route['sms/ajax_penduduk_rw']                   = 'sms/ajax_penduduk_rw';
$route['sms/ajax_penduduk_rw/(:any)']            = 'sms/ajax_penduduk_rw/$1';
$route['sms/ajax_penduduk_rt']                   = 'sms/ajax_penduduk_rt';
$route['sms/ajax_penduduk_rt/(:any)']            = 'sms/ajax_penduduk_rt/$1';
$route['sms/ajax_penduduk_rt/(:any)/(:any)']     = 'sms/ajax_penduduk_rt/$1/$2';
$route['sms/search']                             = 'sms/search';
$route['sms/search_kontak']                      = 'sms/search_kontak';
$route['sms/search_grup']                        = 'sms/search_grup';
$route['sms/search_anggota']                     = 'sms/search_anggota';
$route['sms/search_anggota/(:num)']              = 'sms/search_anggota/$1';
$route['sms/filter']                             = 'sms/filter';
$route['sms/insert']                             = 'sms/insert';
$route['sms/insert/(:num)']                      = 'sms/insert/$1';
$route['sms/update/(:any)/(:num)/(:num)']        = 'sms/update/$1/$2/$3';
$route['sms/delete/(:num)/(:num)/(:num)/(:any)'] = 'sms/delete/$1/$2/$3/$4';
$route['sms/delete_all/(:num)/(:num)/(:num)']    = 'sms/delete_all/$1/$2/$3';
$route['sms/sms_lock/(:any)']                    = 'sms/sms_lock/$1';
$route['sms/sms_unlock/(:any)']                  = 'sms/sms_unlock/$1';
$route['sms/kontak']                             = 'sms/kontak';
$route['sms/kontak/(:num)']                      = 'sms/kontak/$1';
$route['sms/kontak/(:num)/(:num)']               = 'sms/kontak/$1/$2';
$route['sms/form_kontak']                        = 'sms/form_kontak';
$route['sms/form_kontak/(:num)']                 = 'sms/form_kontak/$1';
$route['sms/kontak_insert']                      = 'sms/kontak_insert';
$route['sms/kontak_delete']                      = 'sms/kontak_delete';
$route['sms/kontak_delete/(:num)']               = 'sms/kontak_delete/$1';
$route['sms/delete_all_kontak']                  = 'sms/delete_all_kontak';
$route['sms/group']                              = 'sms/group';
$route['sms/group/(:num)']                       = 'sms/group/$1';
$route['sms/group/(:num)/(:num)']                = 'sms/group/$1/$2';
$route['sms/form_grup']                          = 'sms/form_grup';
$route['sms/form_grup/(:num)']                   = 'sms/form_grup/$1';
$route['sms/grup_insert']                        = 'sms/grup_insert';
$route['sms/grup_update']                        = 'sms/grup_update';
$route['sms/grup_delete']                        = 'sms/grup_delete';
$route['sms/grup_delete/(:num)']                 = 'sms/grup_delete/$1';
$route['sms/delete_all_grup']                    = 'sms/delete_all_grup';
$route['sms/anggota']                            = 'sms/anggota';
$route['sms/anggota/(:num)']                     = 'sms/anggota/$1';
$route['sms/anggota/(:num)/(:num)']              = 'sms/anggota/$1/$2';
$route['sms/anggota/(:num)/(:num)/(:num)']       = 'sms/anggota/$1/$2/$3';
$route['sms/form_anggota']                       = 'sms/form_anggota';
$route['sms/form_anggota/(:num)']                = 'sms/form_anggota/$1';
$route['sms/anggota_insert']                     = 'sms/anggota_insert';
$route['sms/anggota_insert/(:num)']              = 'sms/anggota_insert/$1';
$route['sms/anggota_delete']                     = 'sms/anggota_delete';
$route['sms/anggota_delete/(:num)']              = 'sms/anggota_delete/$1';
$route['sms/anggota_delete/(:num)/(:num)']       = 'sms/anggota_delete/$1/$2';
$route['sms/delete_all_anggota']                 = 'sms/delete_all_anggota';
$route['sms/delete_all_anggota/(:num)']          = 'sms/delete_all_anggota/$1';
$route['sms/form_polling']                       = 'sms/form_polling';
$route['sms/form_polling/(:num)']                = 'sms/form_polling/$1';
$route['sms/insert_polling']                     = 'sms/insert_polling';
$route['sms/insert_polling/(:num)']              = 'sms/insert_polling/$1';
$route['sms/polling_delete']                     = 'sms/polling_delete';
$route['sms/polling_delete/(:num)']              = 'sms/polling_delete/$1';
$route['sms/delete_all_polling']                 = 'sms/delete_all_polling';
$route['sms/pertanyaan']                         = 'sms/pertanyaan';
$route['sms/pertanyaan/(:num)']                  = 'sms/pertanyaan/$1';
$route['sms/pertanyaan/(:num)/(:num)']           = 'sms/pertanyaan/$1/$2';
$route['sms/pertanyaan/(:num)/(:num)/(:num)']    = 'sms/pertanyaan/$1/$2/$3';
$route['sms/form_pertanyaan']                    = 'sms/form_pertanyaan';
$route['sms/form_pertanyaan/(:num)']             = 'sms/form_pertanyaan/$1';
$route['sms/pertanyaan_insert']                  = 'sms/pertanyaan_insert';
$route['sms/pertanyaan_insert/(:num)']           = 'sms/pertanyaan_insert/$1';

// Sosmed
$route['sosmed']               = 'sosmed';
$route['sosmed/index']         = 'sosmed';
$route['sosmed/twitter']       = 'sosmed/twitter';
$route['sosmed/instagram']     = 'sosmed/instagram';
$route['sosmed/google']        = 'sosmed/google';
$route['sosmed/youtube']       = 'sosmed/youtube';
$route['sosmed/update/(:any)'] = 'sosmed/update/$1';

// Statistik
$route['statistik']                       = 'statistik';
$route['statistik/index']                 = 'statistik';
$route['statistik/index/(:num)']          = 'statistik/index/$1';
$route['statistik/index/(:num)/(:num)']   = 'statistik/index/$1/$2';
$route['statistik/clear']                 = 'statistik/clear';
$route['statistik/graph']                 = 'statistik/graph';
$route['statistik/graph/(:num)']          = 'statistik/graph/$1';
$route['statistik/pie']                   = 'statistik/pie';
$route['statistik/pie/(:num)']            = 'statistik/pie/$1';
$route['statistik/cetak']                 = 'statistik/cetak';
$route['statistik/cetak/(:num)']          = 'statistik/cetak/$1';
$route['statistik/excel']                 = 'statistik/excel';
$route['statistik/excel/(:num)']          = 'statistik/excel/$1';
$route['statistik/warga']                 = 'statistik/warga';
$route['statistik/warga/(:any)']          = 'statistik/warga/$1';
$route['statistik/warga/(:any)/(:any)']   = 'statistik/warga/$1/$2';
$route['statistik/rentang_umur']          = 'statistik/rentang_umur';
$route['statistik/form_rentang']          = 'statistik/form_rentang';
$route['statistik/form_rentang/(:num)']   = 'statistik/form_rentang/$1';
$route['statistik/rentang_insert']        = 'statistik/rentang_insert';
$route['statistik/rentang_update']        = 'statistik/rentang_update';
$route['statistik/rentang_update/(:num)'] = 'statistik/rentang_update/$1';
$route['statistik/rentang_delete']        = 'statistik/rentang_delete';
$route['statistik/rentang_delete/(:num)'] = 'statistik/rentang_delete/$1';
$route['statistik/delete_all_rentang']    = 'statistik/delete_all_rentang';

// Persuratan
$route['persuratan']              = 'persuratan';
$route['persuratan/index']        = 'persuratan';
$route['persuratan/panduan']      = 'persuratan/panduan';
$route['persuratan/form']         = 'persuratan/form';
$route['persuratan/form/(:any)']  = 'persuratan/form/$1';
$route['persuratan/cetak']        = 'persuratan/cetak';
$route['persuratan/cetak/(:any)'] = 'persuratan/cetak/$1';
$route['persuratan/doc']          = 'persuratan/doc';
$route['persuratan/doc/(:any)']   = 'persuratan/doc/$1';
$route['persuratan/search']       = 'persuratan/search';

// Surat_master
$route['surat_master']                                  = 'surat_master';
$route['surat_master/index']                            = 'surat_master';
$route['surat_master/index/(:num)']                     = 'surat_master/index/$1';
$route['surat_master/index/(:num)/(:num)']              = 'surat_master/index/$1/$2';
$route['surat_master/clear']                            = 'surat_master/clear';
$route['surat_master/clear/(:num)']                     = 'surat_master/clear/$1';
$route['surat_master/form']                             = 'surat_master/form';
$route['surat_master/form/(:num)']                      = 'surat_master/form/$1';
$route['surat_master/form/(:num)/(:num)']               = 'surat_master/form/$1/$2';
$route['surat_master/form/(:num)/(:num)/(:any)']        = 'surat_master/form/$1/$2/$3';
$route['surat_master/form_upload/(:num)/(:num)/(:any)'] = 'surat_master/form_upload/$1/$2/$3';
$route['surat_master/atribut/(:any)']                   = 'surat_master/atribut/$1';
$route['surat_master/form_parameter/(:any)']            = 'surat_master/form_parameter/$1';
$route['surat_master/form_parameter/(:any)/(:any)']     = 'surat_master/form_parameter/$1/$2';
$route['surat_master/menu/(:any)']                      = 'surat_master/menu/$1';
$route['surat_master/search']                           = 'surat_master/search';
$route['surat_master/filter']                           = 'surat_master/filter';
$route['surat_master/tipe']                             = 'surat_master/tipe';
$route['surat_master/kategori']                         = 'surat_master/kategori';
$route['surat_master/insert']                           = 'surat_master/insert';
$route['surat_master/update/(:num)/(:num)/(:any)']      = 'surat_master/update/$1/$2/$3';
$route['surat_master/upload/(:num)/(:num)/(:any)']      = 'surat_master/upload/$1/$2/$3';
$route['surat_master/delete/(:num)/(:num)/(:any)']      = 'surat_master/delete/$1/$2/$3';
$route['surat_master/delete_all/(:num)/(:num)']         = 'surat_master/delete_all/$1/$2';
$route['surat_master/p_insert/(:any)']                  = 'surat_master/p_insert/$1';
$route['surat_master/p_update/(:any)/(:any)']           = 'surat_master/p_update/$1/$2';
$route['surat_master/p_delete/(:any)/(:any)']           = 'surat_master/p_delete/$1/$2';
$route['surat_master/p_delete_all']                     = 'surat_master/p_delete_all';
$route['surat_master/lock/(:num)/(:num)']               = 'surat_master/lock/$1/$2';
$route['surat_master/favorit/(:num)/(:num)']            = 'surat_master/favorit/$1/$2';

// User_setting
$route['user_setting']               = 'user_setting';
$route['user_setting/index']         = 'user_setting';
$route['user_setting/update']        = 'user_setting/update';
$route['user_setting/update/(:any)'] = 'user_setting/update/$1';

// Web
$route['web']                                        = 'web';
$route['web/index']                                  = 'web';
$route['web/index/(:num)']                           = 'web/index/$1';
$route['web/index/(:num)/(:num)']                    = 'web/index/$1/$2';
$route['web/index/(:num)/(:num)/(:num)']             = 'web/index/$1/$2/$3';
$route['web/clear']                                  = 'web/clear';
$route['web/pager']                                  = 'web/pager';
$route['web/pager/(:num)']                           = 'web/pager/$1';
$route['web/form/(:num)/(:num)/(:num)']              = 'web/form/$1/$2/$3';
$route['web/form/(:num)/(:num)/(:num)/(:any)']       = 'web/form/$1/$2/$3/$4';
$route['web/search']                                 = 'web/search';
$route['web/search/(:num)']                          = 'web/search/$1';
$route['web/filter']                                 = 'web/filter';
$route['web/filter/(:num)']                          = 'web/filter/$1';
$route['web/insert']                                 = 'web/insert';
$route['web/insert/(:num)']                          = 'web/insert/$1';
$route['web/update/(:num)/(:any)/(:num)/(:num)']     = 'web/update/$1/$2/$3/$4';
$route['web/delete/(:num)/(:num)/(:num)/(:any)']     = 'web/delete/$1/$2/$3/$4';
$route['web/hapus/(:num)/(:num)/(:num)']             = 'web/hapus/$1/$2/$3';
$route['web/delete_all/(:num)/(:num)']               = 'web/delete_all/$1/$2';
$route['web/artikel_lock/(:num)/(:num)']             = 'web/artikel_lock/$1/$2';
$route['web/artikel_unlock/(:num)/(:num)']           = 'web/artikel_unlock/$1/$2';
$route['web/ajax_add_kategori/(:num)/(:num)/(:num)'] = 'web/ajax_add_kategori/$1/$2/$3';
$route['web/insert_kategori/(:num)/(:num)/(:num)']   = 'web/insert_kategori/$1/$2/$3';
$route['web/headline/(:num)/(:num)/(:num)/(:num)']   = 'web/headline/$1/$2/$3/$4';
$route['web/slide/(:num)/(:num)/(:num)/(:num)']      = 'web/slide/$1/$2/$3/$4';

// Widget
$route['widget']                      = 'widget';
$route['widget/index']                = 'widget';
$route['widget/twitter']              = 'widget/twitter';
$route['widget/update/(:any)/(:any)'] = 'widget/update/$1/$2';

$route['default_controller']   = 'main';
$route['404_override']         = 'main';
$route['translate_uri_dashes'] = false;
