<?php

use App\Jobs\ProcessTrasactionJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    logger()->info('I was inside the serverless architecture');
    ProcessTrasactionJob::dispatch();  // Dispatch a job via AWS SQS
    return view('welcome');
});
