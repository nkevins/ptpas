<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/2fa', function () {
    return redirect('/admin/dashboard');
})->name('2fa')->middleware('2fa');

Route::group(['middleware' => ['auth', '2fa']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/logout', 'Auth\LoginController@logout');
        
        Route::get('/dashboard', 'DashboardController@index')->name('home');
        Route::get('/dashboard/data/totalFlights', 'DashboardController@totalFlightsStatisticData');
        Route::get('/dashboard/data/flightHours', 'DashboardController@flightHoursStatisticData');
        Route::get('/dashboard/data/crewHours', 'DashboardController@crewHoursStatisticData');
        
        Route::get('/myProfile', 'UserController@myProfile');
        Route::post('/myProfile/changePassword', 'UserController@changeMyPassword');
        Route::post('/myProfile/changeOTP', 'UserController@changeMyOTPToken');
        
        Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
            
            Route::get('/aircraft', 'AircraftController@index');
            Route::get('/aircraft/create', 'AircraftController@create');
            Route::post('/aircraft/save', 'AircraftController@save');
            Route::get('/aircraft/{id}/edit', 'AircraftController@edit');
            Route::post('/aircraft/{id}/edit', 'AircraftController@update');
            
            Route::get('/airport', 'AirportController@index');
            Route::get('/airport/create', 'AirportController@create');
            Route::post('/airport/save', 'AirportController@save');
            Route::get('/airport/{id}/edit', 'AirportController@edit');
            Route::post('/airport/{id}/edit', 'AirportController@update');
            
            Route::get('/user', 'UserController@index');
            Route::get('/user/create', 'UserController@create');
            Route::post('/user/save', 'UserController@save');
            Route::get('/user/{id}/edit', 'UserController@edit');
            Route::post('/user/{id}/edit', 'UserController@update');
            Route::post('/user/{id}/changePassword', 'UserController@changePassword');
            Route::post('/user/changeOTPToken', 'UserController@changeOTPToken');
            
            Route::get('/flight_log', 'FlightLogController@index');
            Route::get('/flight_log/create', 'FlightLogController@create');
            Route::post('/flight_log/save', 'FlightLogController@save');
            Route::get('/flight_log/{id}/edit', 'FlightLogController@edit');
            Route::post('/flight_log/{id}/edit', 'FlightLogController@update');
            Route::post('/flight_log/remove', 'FlightLogController@delete');
        });
        
        Route::get('/flight_log/data', 'FlightLogController@flightLogData');
    });
});
