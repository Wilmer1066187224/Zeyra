<?php
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\ReporteCompraController;
use App\Http\Controllers\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProveedorController;


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
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::resource('productos', ProductoController::class)->middleware(['auth']);
Route::resource('categorias', CategoriaController::class)->middleware(['auth']);
Route::resource('movimientos', MovimientoController::class)->middleware(['auth']);
Route::resource('compras', CompraController::class)->middleware(['auth']);

Route::resource('ventas', VentaController::class)->middleware(['auth']);
Route::get('/ventas/{venta}/factura',[VentaController::class, 'generarFactura'])->name('ventas.factura');// web.php
Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');


Route::get('/ventas/export', function () {
    return Excel::download(new VentasExport, 'ventas.xlsx');
})->name('ventas.export');


Route::get('/reportes/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');

Route::get('/reporte-compras', [ReporteController::class, 'descargarReporte'])->name('reporte.compras');
Route::get('/compras/pdf/{id}', [ReporteCompraController::class, 'generarPDF'])->name('compras.pdf');

Route::resource('proveedores', ProveedorController::class)
    ->parameters(['proveedores' => 'proveedor']);



Route::resource('clientes',ClienteController::class)->middleware(['auth']);


Route::middleware(['auth', 'permission:gestionar roles'])->prefix('admin')->name('admin.')->group(function () {
Route::get('user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');
Route::post('user-roles/{user}', [UserRoleController::class, 'update'])->name('user-roles.update');
    
});
Route::view('/sin-permiso', 'errors.permission')->name('permission.denied');

Route::get('/prohibido', function () {
    abort(403);
});
Route::patch('/notificaciones/{id}', function ($id) {
    auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    return back();
})->name('notificaciones.leer')->middleware('auth');


Route::post('/notificaciones/{id}/leida', function ($id, Request $request) {
    $notificacion = $request->user()->notifications()->findOrFail($id);
    $notificacion->markAsRead();

    return back();
})->middleware('auth')->name('notificaciones.marcarLeida');
Route::view('/notificaciones', 'notificaciones.index')->middleware('auth');

Route::get('/devoluciones/crear', [DevolucionController::class, 'create'])->name('devoluciones.create');
Route::post('/devoluciones', [DevolucionController::class, 'store'])->name('devoluciones.store');
Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index');
Route::post('/abonos', [AbonoController::class, 'store'])->name('abonos.store');








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
