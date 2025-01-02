<?php

use App\Jobs\ProcessTrasactionJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ProcessTrasactionJob::dispatch();
    Log::info('Dispatching Process Transaction Job....');
    return view('welcome');
});
