<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
require base_path('app-modules/User/Presentation/Routes/api.php');
