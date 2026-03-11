<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\View;
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

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


// Authentication Routes...
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::resource('/', 'App\Http\Controllers\homeFrController');
Route::resource('/contacts', 'App\Http\Controllers\contactFrController');
Route::resource('/booked', 'App\Http\Controllers\bookedCourseFrController');
Route::resource('/abouts', 'App\Http\Controllers\aboutFrController');
Route::resource('/blogs', 'App\Http\Controllers\blogFrController');
Route::resource('/blogsSingles', 'App\Http\Controllers\blogSingleFrController');
Route::resource('/teachers', 'App\Http\Controllers\teacherFrController');
Route::resource('/courses', 'App\Http\Controllers\coursesFrController');
Route::resource('/events', 'App\Http\Controllers\eventFrController');
Route::resource('/notices', 'App\Http\Controllers\noticeFrController');
Route::resource('/messages', 'App\Http\Controllers\messagefromprincipalFrController');
Route::resource('/galleries', 'App\Http\Controllers\galleryFrController');
Route::resource('/enroll', 'App\Http\Controllers\enrollFrController');
Route::resource('/awards', 'App\Http\Controllers\awardsFrController');
Route::resource('/results', 'App\Http\Controllers\resultFrController');
Route::resource('/boards', 'App\Http\Controllers\boardsFrController');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->middleware('auth')->group(function () {
    if (Auth::user() && Auth::user()->role == 0) {
        return redirect()->back();
    }
    Route::get('/', function () {
        return view('school.admin.index');
    });
    Route::resource('/admin', 'App\Http\Controllers\AdminsController');
    Route::resource('/messagefromprincipal', 'App\Http\Controllers\MessageFromPrincipalController');
    Route::resource('/file', 'App\Http\Controllers\FilesController');
    Route::resource('/fact', 'App\Http\Controllers\FactsController');
    Route::resource('/admission', 'App\Http\Controllers\AdmissionsController');
    Route::resource('/about', 'App\Http\Controllers\AboutsController');
    Route::resource('/aboutDetail', 'App\Http\Controllers\AboutsDetailsController');
    Route::resource('/blog', 'App\Http\Controllers\BlogsController');
    Route::resource('/blogReview', 'App\Http\Controllers\BlogReviewController');
    Route::resource('/contactForm', 'App\Http\Controllers\ContactFormController');
    Route::resource('/course', 'App\Http\Controllers\CoursesController');
    Route::resource('/direction', 'App\Http\Controllers\DirectionsController');
    Route::resource('/gallery', 'App\Http\Controllers\GalleriesController');
    Route::resource('/history', 'App\Http\Controllers\HistoriesController');
    Route::resource('/notice', 'App\Http\Controllers\NoticesController');
    Route::resource('/result', 'App\Http\Controllers\ResultsController');
    Route::resource('/setting', 'App\Http\Controllers\SettingController');
    Route::resource('/slider', 'App\Http\Controllers\SlidersController');
    Route::resource('/students', 'App\Http\Controllers\StudentController');
    Route::resource('/teacher', 'App\Http\Controllers\TeachersController');
    Route::resource('/testimonial', 'App\Http\Controllers\TestimonialsController');
    Route::resource('/event', 'App\Http\Controllers\EventsController');
    Route::resource('/award', 'App\Http\Controllers\AwardsController');
    Route::resource('/boardsOfDirector', 'App\Http\Controllers\BoardsOfDirectorController');
});
