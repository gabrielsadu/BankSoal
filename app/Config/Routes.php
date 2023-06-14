<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/banksoal', 'BankSoal::index');
$routes->get('/banksoal/(:num)', 'BankSoal::daftarBab/$1');
$routes->get('/banksoal/(:num)/tambah_bab', 'BankSoal::tambahBab/$1');
$routes->post('/banksoal/(:num)/simpan_bab', 'BankSoal::simpanBab/$1');
$routes->get('/banksoal/(:num)/ubah_bab/(:num)', 'BankSoal::ubahBab/$1/$2');
$routes->post('/banksoal/(:num)/update_bab/(:num)', 'BankSoal::updateBab/$1/$2');
$routes->delete('/banksoal/(:num)/hapus_bab/(:num)', 'BankSoal::hapusBab/$1/$2');

$routes->get('/banksoal/(:num)/bab/(:num)', 'Soal::daftarSoal/$1/$2');
$routes->get('/banksoal/(:num)/bab/(:num)/tambah_soal', 'Soal::tambahSoal/$1/$2');
$routes->post('/banksoal/(:num)/bab/(:num)/simpan_soal', 'Soal::simpanSoal/$1/$2');
$routes->get('/banksoal/(:num)/bab/(:num)/ubah_soal/(:num)', 'Soal::ubahSoal/$1/$2/$3');
$routes->post('/banksoal/(:num)/bab/(:num)/update_soal/(:num)', 'Soal::updateSoal/$1/$2/$3');
$routes->delete('/banksoal/(:num)/bab/(:num)/hapus_soal/(:num)', 'Soal::hapusSoal/$1/$2/$3');
$routes->get('/banksoal/(:num)/bab/(:num)/detail_soal/(:num)', 'Soal::detailSoal/$1/$2/$3');
$routes->post('/bankSoal/uploadGambar', 'Soal::uploadGambar');
$routes->post('/bankSoal/deleteGambar', 'Soal::deleteGambar');

$routes->get('/banksoal/(:num)/tambah_ujian', 'Ujian::tambahUjian/$1');
$routes->post('/banksoal/(:num)/simpan_ujian', 'Ujian::simpanUjian/$1');
$routes->get('/banksoal/(:num)/ubah_ujian/(:num)', 'Ujian::ubahUjian/$1/$2');
$routes->post('/banksoal/(:num)/update_ujian/(:num)', 'Ujian::updateUjian/$1/$2');
$routes->delete('/banksoal/(:num)/hapus_ujian/(:num)', 'Ujian::hapusUjian/$1/$2');
$routes->get('/banksoal/(:num)/detail_ujian/(:num)', 'Ujian::detailUjian/$1/$2');

$routes->get('/banksoal/masuk_ujian', 'Mahasiswa::masukUjian');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
