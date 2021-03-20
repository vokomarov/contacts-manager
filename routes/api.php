<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\ContactsController;
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

Route::post('/auth/login', [LoginController::class, 'login'])->name('auth.login');

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('contacts', ContactsController::class)->missing(function (Request $request) {
        return response()->json([
            'message' => 'Contact not found.',
            'error' => 'Unable to find contact by given ID.'
        ], \Illuminate\Http\Response::HTTP_NOT_FOUND);
    });
});
