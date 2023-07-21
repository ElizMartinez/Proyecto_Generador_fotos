<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\FotoController;

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


Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/agregar-proyecto', [ProyectosController::class, 'agregarProyecto']);
    Route::patch('/editar-proyecto/{id}', [ProyectosController::class, 'editarProyecto']);
    Route::delete('/eliminar-proyecto/{id}', [ProyectosController::class, 'eliminarProyecto']);
    Route::get('/index', [ProyectosController::class, 'listarProyectos']);
    Route::get('/ver-proyecto/{id}', [ProyectosController::class, 'verProyecto']);
    Route::post('/agregar-coleccion/{id}', [ColeccionController::class, 'agregarColeccion']);
    route::put('/editar-coleccion/{id}',[ColeccionController::class, 'editarColeccion']);
    route::delete('/eliminar-coleccion/{id}',[ColeccionController::class, 'deleteColeccion']);
    route::get('/ver-colecciones/{id}',[ColeccionController::class, 'colecciones']);
    route::get('/ver-coleccion/{id}',[ColeccionController::class, 'coleccion']);
    route::post('/agregar-imagen/{id}',[FotoController::class, 'agregarImagen']);
    route::patch('/editar-imagen/{id}',[FotoController::class, 'editarImagen']);
    route::delete('/eliminar-imagen/{id}',[FotoController::class, 'eliminarImagen']);
    route::get('/ver-imagen/{id}',[FotoController::class, 'verImagen']);
    route::get('/ver-imagenes-coleccion/{id}',[FotoController::class, 'verImagenesColeccion']);
    route::get('/descargar-word/{id}',[ColeccionController::class, 'coleccionWord']);
});

Route::post('/login', [AuthController::class, 'login']);