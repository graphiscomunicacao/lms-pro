<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupportLinkController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\LearningArtifactController;

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

Route::redirect('/', '/admin/')->name('login');

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::middleware(['auth:sanctum', 'verified'])
//    ->get('/dashboard', function () {
//        return view('dashboard');
//    })
//    ->name('dashboard');
//
//Route::prefix('/')
//    ->middleware(['auth:sanctum', 'verified'])
//    ->group(function () {
//        Route::resource('categories', CategoryController::class);
//        Route::resource('groups', GroupController::class);
//        Route::resource('jobs', JobController::class);
//        Route::resource('roles', RoleController::class);
//        Route::resource('support-links', SupportLinkController::class);
//        Route::resource('teams', TeamController::class);
//        Route::resource('certificates', CertificateController::class);
//        Route::resource(
//            'learning-artifacts',
//            LearningArtifactController::class
//        );
//        Route::resource('menus', MenuController::class);
//        Route::resource('learning-paths', LearningPathController::class);
//        Route::resource('quizzes', QuizController::class);
//        Route::resource('users', UserController::class);
//    });
