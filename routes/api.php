<?php

use App\PowerData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me'); 
});

Route::post('healthcheck', function () {
    
    foreach (request()->all() as $measurement) {
        $powerData = new PowerData();
        $powerData->sensor = "Fake Wemos D1 Mini";
        $powerData->current = $measurement['currentValue'];
        $powerData->power = $measurement['currentValue'] * 230;
        $powerData->created_at = $measurement['timestamp'];
        $powerData->save();
    }
    
    return 'OK';
});
