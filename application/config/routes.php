<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'UserController';
$route['404_override'] = 'ErrorController';
$route['translate_uri_dashes'] = false;

$route['sppd/(:any)'] = 'sppdController/sppd/$1';
$route['surat-tugas'] = 'SuratTugasController/surattugas';
$route['list-sppd'] = 'sppdController/listsppd';
$route['list-st'] = 'SuratTugasController/listst';
$route['list-rincian'] = 'RincianController/listrincian';
$route['rincian'] = 'RincianController/rincian';
$route['read_st'] = 'sppdController/readST';
$route['daftar-pegawai'] = 'PegawaiController/daftarpegawai';
$route['rekap-keuangan'] = 'sppdController/rekapkeuangan';
$route['unduh-sppd/(:any)'] = 'sppdController/exportSPPD/$1';
$route['ubah-password'] = 'UserController/ubahPassword';
$route['daftar-kegiatan'] = 'KegiatanController/daftarkegiatan';
$route['rekap-keuangan'] = 'RincianController/rekapkeuangan';
$route['home'] = 'UserController/home';
