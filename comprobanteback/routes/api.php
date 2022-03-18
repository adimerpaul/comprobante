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
Route::get('/prueba',[\App\Http\Controllers\DbfController::class,'prueba']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::get('/contrib/{comun}',[\App\Http\Controllers\ComprobanteController::class,'contribuyente']);
//    Route::get('/item',[\App\Http\Controllers\detalleController::class,'item']);
//    Route::get('/subitem/{id}',[\App\Http\Controllers\detalleController::class,'subitem']);
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::apiResource('/item',\App\Http\Controllers\ItemController::class);

    Route::post('/itemunidad',[\App\Http\Controllers\ItemController::class,'itemunidad']);

    Route::post('/eliminaritemunid',[\App\Http\Controllers\ItemController::class,'eliminaritemunid']);
    Route::post('/misitems',[\App\Http\Controllers\ItemController::class,'misitems']);

    Route::post('/misitemcrear',[\App\Http\Controllers\ItemController::class,'misitemcrear']);

    Route::get('/cambio/{item}',[\App\Http\Controllers\ItemController::class,'cambio']);
    Route::apiResource('/empresa',\App\Http\Controllers\EmpresaController::class);
    Route::apiResource('/comprobante',\App\Http\Controllers\ComprobanteController::class);
    Route::post('/ultimoscomprobante',[\App\Http\Controllers\ComprobanteController::class,'ultimoscomprobante']);
    Route::post('/buscarimpreso',[\App\Http\Controllers\ComprobanteController::class,'buscarimpreso']);
    Route::post('/mispagos',[\App\Http\Controllers\ComprobanteController::class,'mispagos']);
    Route::post('/misimpreso',[\App\Http\Controllers\ComprobanteController::class,'misimpreso']);
    Route::post('/reporteunidad',[\App\Http\Controllers\ComprobanteController::class,'reporteunidad']);
    Route::post('/impresosunidad',[\App\Http\Controllers\ComprobanteController::class,'impresosunidad']);
    Route::post('/historial',[\App\Http\Controllers\ComprobanteController::class,'historial']);
    Route::post('/historial2',[\App\Http\Controllers\ComprobanteController::class,'historial2']);
    Route::post('/historial3',[\App\Http\Controllers\ComprobanteController::class,'historial3']);
    Route::put('/pago/{comprobante}',[\App\Http\Controllers\ComprobanteController::class,'pago']);
    Route::post('/proforma/{id}',[\App\Http\Controllers\ComprobanteController::class,'proforma']);
    Route::post('/loscomprobantes',[\App\Http\Controllers\ComprobanteController::class,'loscomprobantes']);
    Route::put('/pagocaja/{comprobante}',[\App\Http\Controllers\ComprobanteController::class,'pagocaja']);
    Route::post('/verificadocaja',[\App\Http\Controllers\ComprobanteController::class,'verificadocaja']);
    Route::post('/verificadosistema',[\App\Http\Controllers\ComprobanteController::class,'verificadosistema']);
    Route::post('/mistramites',[\App\Http\Controllers\ComprobanteController::class,'listramite']);
    Route::post('/modcomp/{id}',[\App\Http\Controllers\ComprobanteController::class,'modcomp']);
    Route::post('/modcomprobante',[\App\Http\Controllers\ComprobanteController::class,'modcomprobante']);
    Route::post('/nombreitem',[\App\Http\Controllers\ItemController::class,'nombreitem']);

    Route::post('/mispagoscaja',[\App\Http\Controllers\ComprobanteController::class,'mispagoscaja']);
    Route::post('/convertirletra/{total}',[\App\Http\Controllers\ComprobanteController::class,'convertirletra']);



    Route::apiResource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::apiResource('/subitem',\App\Http\Controllers\SubitemController::class);
    Route::apiResource('/permiso',\App\Http\Controllers\PermisoController::class);
    Route::get('/cambiosubitem/{subitem}',[\App\Http\Controllers\SubitemController::class,'cambiosubitem']);

    Route::apiResource('/unid',\App\Http\Controllers\UnidController::class);
    Route::apiResource('/user',\App\Http\Controllers\UserController::class);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);

    Route::get('/lista/{ci}',[\App\Http\Controllers\ClienteController::class,'listacliente']);
    Route::get('/subitemlist/{id}',[\App\Http\Controllers\SubitemController::class,'listasubitem']);
    Route::get('/todoitems',[\App\Http\Controllers\ItemController::class,'todoitems']);

    Route::resource('/anulado',\App\Http\Controllers\AnuladoController::class);
    Route::resource('/exportar',\App\Http\Controllers\ExportController::class);
    Route::resource('/mercado',\App\Http\Controllers\MercadoController::class);
    Route::resource('/catastro',\App\Http\Controllers\CatastroController::class);
    Route::resource('/sistema',\App\Http\Controllers\SistemaController::class);
    Route::resource('/caja',\App\Http\Controllers\CajaController::class);
    Route::post('/subir',[\App\Http\Controllers\ExportController::class,'subir']);
    Route::post('/reportecomp',[\App\Http\Controllers\ComprobanteController::class,'reportecomp']);
    Route::post('/reportitem',[\App\Http\Controllers\ComprobanteController::class,'reportitem']);
    Route::post('/reimprimir',[\App\Http\Controllers\ComprobanteController::class,'reimprimir']);
    Route::post('/imprimir',[\App\Http\Controllers\ComprobanteController::class,'imprimir']);
});
