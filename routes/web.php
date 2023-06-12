<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HomesController;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Http\Resources\V1\HomesResource;
use App\Http\Resources\V1\HomesCollection;
use App\Services\V1\HomesQuery;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/api/v1/homes', [HomesController::class, 'index'] );
