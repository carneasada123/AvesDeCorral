<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PDFController;
//use App\Http\Middleware;

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

// Página de inicio (welcome) para el inicio de sesión
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Ruta de inicio de sesión
Route::post('/login', [AuthController::class, 'login']);

// Ruta protegida para Administrador
Route::middleware(['jwt.auth', 'role_and_status:Administrador'])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    });
});

// Ruta protegida para Cliente
Route::middleware(['jwt.auth', 'role_and_status:Cliente'])->group(function () {
    Route::get('/cliente', function () {
        return view('cliente');
    });
});

// Ruta protegida para Almacen
Route::middleware(['jwt.auth', 'role_and_status:Almacen'])->group(function () {
    Route::get('/almacen', function () {
        return view('almacen');
    });
});

// Insertar Formulario para agregar materiales
Route::post('/insert-data', [DataController::class, 'insertData'])->name('insertData');

//Editar data del mantenimiento
Route::put('/actualizar-servicio/{id}', [DataController::class, 'updateService']);

// Enlistar Materiales de la tabla con la librería DataTable
Route::get('/listar-servicios', [DataController::class, 'listarServiciosActivos'])->name('listarServicios');
Route::post('/eliminar-servicio/{id}', [DataController::class, 'eliminarServicio']);

// Mostrar detalles en el modal
Route::get('/obtener-detalles-servicio/{id}', [DataController::class, 'getServiceDetails']);

// Mostrar detalles en el modal Almacen Materiales
Route::get('/obtener-detalles-materiales-almacen/{id}', [DataController::class, 'getMaterialesAlmacenDetails']);
Route::post('/guardar-entrega-parcial', [DataController::class, 'guardarEntregaParcial'])->name('guardar.entrega.parcial');

// Insertar tipo de servicio
Route::post('/tipos-servicios', [DataController::class, 'storeTipoServicio']);

// Insertar materiales y tipo de presentación
Route::post('/material', [DataController::class, 'storeMaterial'])->name('material.store');

// Mostrar usuarios y cambiar estado
Route::get('/obtener-usuarios', [DataController::class, 'obtenerUsuarios']);
Route::post('/cambiar-estado-usuario/{id}', [DataController::class, 'cambiarEstadoUsuario']);
Route::post('/activar-usuario/{id}', [DataController::class, 'activarUsuario']);
Route::post('/desactivar-usuario/{id}', [DataController::class, 'desactivarUsuario']);

// ACCESO DE LA PAGINA CLIENTE a los datos de los servicios
Route::get('/cliente', [DataController::class, 'listarServiciosActivos'])->name('cliente');

// ACCESO DE LA PAGINA ADMINISTRADOR a los datos de los servicios
Route::get('/admin', [DataController::class, 'listarServiciosActivos'])->name('admin');

// ACCESO DE LA PAGINA ALMACEN a los datos de los servicios
Route::get('/almacen', [DataController::class, 'listarMaterialesActivosAlmacen'])->name('almacen');

//------- PDF ROUTES ---------
//Route::get('pdf', [PDFController::class, 'index']);
Route::post('/generar-pdf', [PDFController::class, 'generatePDF']);

//------- JSON DATOS ROUTES ---------
Route::get('/listar-servicios-json', [DataController::class, 'listarServiciosJson'])->name('listar.servicios.json');
