<?php

use App\Http\Controllers\Api\ApiController;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/serie', ApiController::class);
Route::post('/serie/upload', [ApiController::class, 'upload']);

Route::get('/serie/{series}/seasons', function (Series $series) {
    return $series->seasons;
});

Route::get('/serie/{series}/episodes', function (Series $series) {
    // usar o metodo show
    return $series->episodes;
});

Route::patch('/episodes/{episode}', function (Episode $episode, Request $request) {
    $episode->watched = $request->watched;
    $episode->save();

    return $episode;
});