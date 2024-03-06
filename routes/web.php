<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SolicitudeController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\AvalController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\VisitaDomiciliarController;
use App\Http\Controllers\Webhook;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CoberturaRiesgoOpsaciController;
use App\Http\Middleware\Asesor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::resource('clientes', ClienteController::class)->middleware('auth');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('tipo-usuario');


 
Route::get('file-upload', [FileUploadController::class, 'index'])->name('file-upload')->middleware('auth');
Route::post('store', [FileUploadController::class, 'store']);
Route::post('cambiarEstado', [FileUploadController::class, 'cambiarEstado']);

Route::resource('solicitudes', SolicitudeController::class)->middleware('auth');
Route::resource('users', UserController::class);

Route::get('imprimirDatosSolicitud', [PdfController::class, 'imprimirDatosSolicitud'])->name('imprimirDatosSolicitud');

Route::get('confirmarTelefono',[TelefonoController::class, 'index'])->name('confirmarTelefono');
Route::post('confirmarTelefono',[TelefonoController::class, 'verificar'])->name('confirmarTelefono');

Route::get('contacto',[ContactoController::class, 'index'])->name('contacto');
Route::post('contacto',[ContactoController::class, 'metodo'])->name('contacto');

Route::get('fechaYHora',[App\Http\Controllers\HomeController::class, 'fechaHoraActual'])->name('fechaYHora');

Route::get('documentosIntegracion', [SolicitudeController::class, 'abr'])->name('documentosIntegracion');

Route::get('panelAliado',[SolicitudeController::class , 'Aliado'])->name('panelAliado')->middleware('auth');

Route::post('revisarTipoUsuario',[LoginController::class, 'buscarUsuario'])->name('revisarTipoUsuario');

Route::get('imprimirPDF/{solicitude}', [SolicitudeController::class, 'imprimirPDF'])->name('imprimirPDF');

Route::post('webhook',[Webhook::class, 'prueba'])->name('prueba');

Route::get('webhook',[Webhook::class, 'feik'])->name('feik');

Route::get('firma',[FileUploadController::class, 'probarFirma'])->name('firma')->middleware('auth');
Route::post('guardarFirma',[FileUploadController::class, 'guardarFirma'])->name('guardarFirma')->middleware('auth');

Route::get('documentosAval', [AvalController::class, 'index'])->name('documentosAval')->middleware('auth');
Route::post('documentosAval', [AvalController::class, 'guardar']);
Route::post('cambiarEstadoAval', [AvalController::class, 'cambiarEstado']);

Route::get('visitadomiciliar', [VisitaDomiciliarController::class, 'index']);
Route::post('visitadomiciliar', [VisitaDomiciliarController::class, 'guardarDatos']);

Route::get('probarSMS',[TelefonoController::class, 'probarAPISMS']);

Route::get('opsaciRiskCoverage/{days?}',[CoberturaRiesgoOpsaciController::class, 'getValue']);