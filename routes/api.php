<?php

use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/invoices', [InvoiceController::class, 'getById']);
Route::patch('/invoices/approve/{id}', [InvoiceController::class, 'approve']);
Route::patch('/invoices/reject/{id}', [InvoiceController::class, 'reject']);
