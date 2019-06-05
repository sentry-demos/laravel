<?php
// NO
// use Sentry;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

// https://sentry.io/for/laravel/
Route::get('/handled', function () {
    // logs nothing
    // Log::info('XXXXXXXXXXXXXXXXXX');
    echo "XXXXXXXXXX";
    try {
        $this->functionFailsForSure();
    } catch (\Throwable $exception) {
        // echo "1111";

        // if (app()->bound('Laravel') && $this->shouldReport($exception)) {
        //     // app('Laravel')->captureException($exception);
        // echo "2222";

        // }
        // NO
        // Sentry\captureException($exception);
    }
    return 'HEYOOOOOOH';
});
Route::get('/unhandled', function () {
    1/0;
});
Route::post('/checkout', function () {
    // TODO produce the /checkout logic in PHP
});