<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Book\BookController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Book\BookIssueLogController;
use App\Http\Controllers\API\Authentication\AuthenticationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication 
Route::post('register',                     [AuthenticationController::class, 'register']);
Route::post('login',                        [AuthenticationController::class, 'login']);

// Login user profile api
Route::get('profile',                       [UserController::class, 'profile'])->middleware('auth:api');

// Book api resource route for crud 
Route::resource('book',                     BookController::class)->middleware('auth:api');

// Book Issue Log 
Route::get('issue_book_list',               [BookIssueLogController::class, 'issue_book_list'])->name('issue_book_list')->middleware('auth:api');
Route::post('book/{book}/issue',            [BookIssueLogController::class, 'issue_book'])->name('issue_book')->middleware('auth:api');
Route::post('book/{book_issue}/return',     [BookIssueLogController::class, 'return_book'])->name('return_book')->middleware('auth:api');