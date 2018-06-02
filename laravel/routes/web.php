<?php

//http://localhost:8080/laravel/public/
Route::get('/', function () {
    return view('welcome');
});

//http://localhost:8080/laravel/public/articulos/1
Route::get('datoscliente/{id}', 'ClientsController@showClientInfo');