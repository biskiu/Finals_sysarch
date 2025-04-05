<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DepartmentController;
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

Route::get('/', [CollegeController::class, 'showColleges'])->name('college');//first makita ig open
Route::get('/departments/{collegeId}', [DepartmentController::class, 'showDepartments'])->name('departments.by.college');

//college
Route::post('/store-college', [CollegeController::class, 'store']);
Route::put('/update-college/{id}', [CollegeController::class, 'update']);
Route::delete('/delete-college/{id}', [CollegeController::class, 'destroy'])->name('delete.college');
Route::post('/restore-college/{id}', [CollegeController::class, 'restore'])->name('restore.college');
Route::delete('/colleges/permanent-delete/{id}', [CollegeController::class, 'permanentDelete'])->name('delete.permanent.college');

//departments
Route::post('/store-department', [DepartmentController::class, 'store'])->name('store.department');
Route::put('/departments/update/{id}', [DepartmentController::class, 'update']);
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('delete.department');
Route::post('/departments/restore/{id}', [DepartmentController::class, 'restore'])->name('restore.department');
Route::delete('/departments/delete/permanent/{id}', [DepartmentController::class, 'forceDelete'])->name('delete.permanent.department');




