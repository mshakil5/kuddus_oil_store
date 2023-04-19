<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\User\UserController;

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
// cache clear
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
 });
//  cache clear
// Route::get('/', function () {
//     return view('welcome');
// });


//agent part start
Route::group(['prefix' =>'agent/', 'middleware' => ['auth', 'is_agent']], function(){
    Route::get('dashboard', [HomeController::class, 'agentHome'])->name('agent.dashboard')->middleware('is_agent');
    //profile
    Route::get('/profile', [AgentController::class, 'profile'])->name('profile');
    Route::put('profile/{id}', [AgentController::class, 'agentProfileUpdate']);
    Route::post('changepassword', [AgentController::class, 'changeAgentPassword']);
    Route::put('image/{id}', [AgentController::class, 'agentImageUpload']);
    //profile end
});
//agent part end

//user part start
Route::group(['middleware' => ['auth', 'is_user']], function(){
    Route::get('user/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard')->middleware('is_user');
    //profile
    Route::get('user/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('user/profile/{id}', [UserController::class, 'userProfileUpdate']);
    Route::post('user/changepassword', [UserController::class, 'changeUserPassword']);
    Route::put('user/image/{id}', [UserController::class, 'userImageUpload']);
    //profile end
});
//user part end



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');

 