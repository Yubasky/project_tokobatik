<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── Redirect root ───────────────────────────────────────────────────────────
$routes->get('/', 'AuthController::index');

// ─── Auth ─────────────────────────────────────────────────────────────────────
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// ─── Admin Routes (role: admin) ───────────────────────────────────────────────
$routes->group('admin', ['filter' => ['auth', 'admin']], function ($routes) {
    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Produk
    $routes->get('produk', 'Admin\ProdukController::index');
    $routes->get('produk/create', 'Admin\ProdukController::create');
    $routes->post('produk/store', 'Admin\ProdukController::store');
    $routes->get('produk/edit/(:num)', 'Admin\ProdukController::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\ProdukController::update/$1');
    $routes->get('produk/delete/(:num)', 'Admin\ProdukController::delete/$1');

    // Pelanggan
    $routes->get('pelanggan', 'Admin\PelangganController::index');
    $routes->get('pelanggan/create', 'Admin\PelangganController::create');
    $routes->post('pelanggan/store', 'Admin\PelangganController::store');
    $routes->get('pelanggan/edit/(:num)', 'Admin\PelangganController::edit/$1');
    $routes->post('pelanggan/update/(:num)', 'Admin\PelangganController::update/$1');
    $routes->get('pelanggan/delete/(:num)', 'Admin\PelangganController::delete/$1');

    // Transaksi
    $routes->get('transaksi', 'Admin\TransaksiController::index');
    $routes->get('transaksi/create', 'Admin\TransaksiController::create');
    $routes->post('transaksi/store', 'Admin\TransaksiController::store');
    $routes->get('transaksi/show/(:num)', 'Admin\TransaksiController::show/$1');
    $routes->get('transaksi/delete/(:num)', 'Admin\TransaksiController::delete/$1');
    $routes->get('transaksi/getProduk/(:num)', 'Admin\TransaksiController::getProduk/$1');

    // Pembelian (Restock)
    $routes->get('pembelian', 'Admin\PembelianController::index');
    $routes->get('pembelian/create', 'Admin\PembelianController::create');
    $routes->post('pembelian/store', 'Admin\PembelianController::store');
    $routes->get('pembelian/show/(:num)', 'Admin\PembelianController::show/$1');
    $routes->get('pembelian/delete/(:num)', 'Admin\PembelianController::delete/$1');

    // Pemasukan
    $routes->get('pemasukan', 'Admin\PemasukanController::index');
    $routes->get('pemasukan/create', 'Admin\PemasukanController::create');
    $routes->post('pemasukan/store', 'Admin\PemasukanController::store');
    $routes->get('pemasukan/edit/(:num)', 'Admin\PemasukanController::edit/$1');
    $routes->post('pemasukan/update/(:num)', 'Admin\PemasukanController::update/$1');
    $routes->get('pemasukan/delete/(:num)', 'Admin\PemasukanController::delete/$1');

    // Pengeluaran
    $routes->get('pengeluaran', 'Admin\PengeluaranController::index');
    $routes->get('pengeluaran/create', 'Admin\PengeluaranController::create');
    $routes->post('pengeluaran/store', 'Admin\PengeluaranController::store');
    $routes->get('pengeluaran/edit/(:num)', 'Admin\PengeluaranController::edit/$1');
    $routes->post('pengeluaran/update/(:num)', 'Admin\PengeluaranController::update/$1');
    $routes->get('pengeluaran/delete/(:num)', 'Admin\PengeluaranController::delete/$1');

    // Laporan Kas
    $routes->get('kas', 'Admin\KasController::index');
    $routes->post('kas/filter', 'Admin\KasController::filter');

    // User Management
    $routes->get('user', 'Admin\UserController::index');
    $routes->get('user/create', 'Admin\UserController::create');
    $routes->post('user/store', 'Admin\UserController::store');
    $routes->get('user/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('user/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('user/delete/(:num)', 'Admin\UserController::delete/$1');
});

// ─── Kasir Routes (role: kasir & admin) ──────────────────────────────────────
$routes->group('kasir', ['filter' => ['auth', 'kasir']], function ($routes) {
    // Dashboard
    $routes->get('/', 'Kasir\DashboardController::index');
    $routes->get('dashboard', 'Kasir\DashboardController::index');

    // Pelanggan (read only)
    $routes->get('pelanggan', 'Kasir\PelangganController::index');

    // Transaksi
    $routes->get('transaksi', 'Kasir\TransaksiController::index');
    $routes->get('transaksi/create', 'Kasir\TransaksiController::create');
    $routes->post('transaksi/store', 'Kasir\TransaksiController::store');
    $routes->get('transaksi/show/(:num)', 'Kasir\TransaksiController::show/$1');
    $routes->get('transaksi/getProduk/(:num)', 'Kasir\TransaksiController::getProduk/$1');

    // Pemasukan
    $routes->get('pemasukan', 'Kasir\PemasukanController::index');
    $routes->get('pemasukan/create', 'Kasir\PemasukanController::create');
    $routes->post('pemasukan/store', 'Kasir\PemasukanController::store');
    $routes->get('pemasukan/edit/(:num)', 'Kasir\PemasukanController::edit/$1');
    $routes->post('pemasukan/update/(:num)', 'Kasir\PemasukanController::update/$1');
    $routes->get('pemasukan/delete/(:num)', 'Kasir\PemasukanController::delete/$1');

    // Pengeluaran
    $routes->get('pengeluaran', 'Kasir\PengeluaranController::index');
    $routes->get('pengeluaran/create', 'Kasir\PengeluaranController::create');
    $routes->post('pengeluaran/store', 'Kasir\PengeluaranController::store');
    $routes->get('pengeluaran/edit/(:num)', 'Kasir\PengeluaranController::edit/$1');
    $routes->post('pengeluaran/update/(:num)', 'Kasir\PengeluaranController::update/$1');
    $routes->get('pengeluaran/delete/(:num)', 'Kasir\PengeluaranController::delete/$1');

    // Laporan Kas
    $routes->get('kas', 'Kasir\KasController::index');
    $routes->get('kas/filter', 'Kasir\KasController::filter');
});
