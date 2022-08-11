<?php

use Illuminate\Support\Facades\Route;
use Msucevan\Swapi\Models\Person;
use Msucevan\Swapi\Models\Planet;

/* Route::get('swapi', function () {
    echo "iello world";
}); */

Route::group(['namespace' => 'Msucevan\Swapi\Http\Controllers'], function () {
    Route::get('people/{id}', 'PersonController@getPerson');
    Route::get('people/', 'PersonController@getPeople');
});
