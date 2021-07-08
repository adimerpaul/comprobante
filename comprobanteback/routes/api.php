<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::get('/contrib/{comun}',[\App\Http\Controllers\ComprobanteController::class,'contribuyente']);
//    Route::get('/item',[\App\Http\Controllers\detalleController::class,'item']);
//    Route::get('/subitem/{id}',[\App\Http\Controllers\detalleController::class,'subitem']);
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::apiResource('/item',\App\Http\Controllers\ItemController::class);
    Route::get('/cambio/{item}',[\App\Http\Controllers\ItemController::class,'cambio']);
    Route::apiResource('/empresa',\App\Http\Controllers\EmpresaController::class);
    Route::apiResource('/comprobante',\App\Http\Controllers\ComprobanteController::class);
    Route::apiResource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::apiResource('/subitem',\App\Http\Controllers\SubitemController::class);
    Route::get('/cambiosubitem/{subitem}',[\App\Http\Controllers\SubitemController::class,'cambiosubitem']);

    Route::apiResource('/unid',\App\Http\Controllers\UnidController::class);
    Route::apiResource('/user',\App\Http\Controllers\UserController::class);
    Route::get('/lista/{ci}',[\App\Http\Controllers\ClienteController::class,'listacliente']);
    Route::get('/subitemlist/{id}',[\App\Http\Controllers\SubitemController::class,'listasubitem']);
});
