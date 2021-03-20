<?php

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

Route::group([
    'middleware' => 'api',
], function () {
    Route::apiResource('contacts', ContactsController::class)->missing(function (Request $request) {
        return response()->json([
            'message' => 'Contact not found.',
            'error' => 'Unable to find contact by given ID.'
        ], \Illuminate\Http\Response::HTTP_NOT_FOUND);
    });;
});
