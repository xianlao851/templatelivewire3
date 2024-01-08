<?php

//use App\Livewire\Admin\Index as AdminIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Index;
use App\Livewire\Admin\Permission;
use App\Livewire\Admin\Roles;
use Laravel\Jetstream\Rules\Role;

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

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/templatelivewire3/public/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/templatelivewire3/public/livewire/livewire.js', $handle);
});
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Route::middleware([
//     'auth:sanctum', 'role:admin',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/admin_index', Index::class)->name('admin_index');
// });

Route::middleware([
    'auth:sanctum', 'role:admin',
    config('jetstream.auth_session'),
    'verified',
])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/index', Index::class)->name('index');
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/roles', Roles::class)->name('roles');
});
