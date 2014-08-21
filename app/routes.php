<?php

Route::post('/newTask','HomeController@newTask');
Route::post('/setStatusTask','HomeController@setStatusTask');

Route::controller('/','HomeController');