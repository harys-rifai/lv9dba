<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
use App\Models\Uatmetric;

Route::get('/api/uatmetric/chart-data', function () {
    $data = Uatmetric::orderBy('timestamp', 'desc')->limit(10)->get();

    return response()->json([
        'labels' => $data->pluck('timestamp')->map(fn($t) => \Carbon\Carbon::parse($t)->format('H:i'))->reverse()->values(),
        'cpu' => $data->pluck('CPU')->reverse()->values(),
    ]);
})->name('api.uatmetric.chart.data');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
