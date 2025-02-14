<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
| File ini mendefinisikan perintah Artisan khusus yang dapat Anda jalankan
| dari terminal. Perintah ini digunakan untuk memberikan motivasi dengan
| menampilkan kutipan inspirasi.
*/

// Perintah `php artisan inspire`
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote()); // Menampilkan kutipan inspirasi di terminal
})->purpose('Display an inspiring quote'); // Deskripsi perintah
