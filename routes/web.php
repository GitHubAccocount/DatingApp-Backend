<?php

use App\Events\Hello;
use App\Events\PrivateTest;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/broadcast', function () {

    broadcast(new Hello());
    return "Event has been sent!";
});

Route::get('/broadcastPrivate', function () {
    $user = App\Models\User::find(5);
    broadcast(new PrivateTest($user));
    return "Event has been sent!";
});

require __DIR__ . '/auth.php';
