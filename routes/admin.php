<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\ContactMailController; 
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\User\UserController;

//admin part start
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
    Route::get('dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard')->middleware('is_admin');
    //profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile/{id}', [AdminController::class, 'adminProfileUpdate']);
    Route::post('changepassword', [AdminController::class, 'changeAdminPassword']);
    Route::put('image/{id}', [AdminController::class, 'adminImageUpload']);
    //profile end
    //admin registration
    Route::get('register','App\Http\Controllers\Admin\AdminController@adminindex');
    Route::post('register','App\Http\Controllers\Admin\AdminController@adminstore');
    Route::get('register/{id}/edit','App\Http\Controllers\Admin\AdminController@adminedit');
    Route::put('register/{id}','App\Http\Controllers\Admin\AdminController@adminupdate');
    Route::get('register/{id}', 'App\Http\Controllers\Admin\AdminController@admindestroy');
    //admin registration end

    
    // account
    Route::get('/account', [AccountController::class, 'index'])->name('admin.account');
    Route::post('/account', [AccountController::class, 'store']);
    Route::get('/account/{id}/edit', [AccountController::class, 'edit']);
    Route::put('/account/{id}', [AccountController::class, 'update']);
    Route::get('/account/{id}', [AccountController::class, 'delete']);


    // photo
    Route::get('/photo', [ImageController::class, 'index'])->name('admin.photo');
    Route::post('/photo', [ImageController::class, 'store']);
    Route::get('/photo/{id}/edit', [ImageController::class, 'edit']);
    Route::put('/photo/{id}', [ImageController::class, 'update']);
    Route::get('/photo/{id}', [ImageController::class, 'delete']);

    
    // customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('/customer/{id}', [CustomerController::class, 'update']);
    Route::get('/customer/{id}', [CustomerController::class, 'delete']);
    Route::post('/getcustomer', [CustomerController::class, 'getcustomer']);
    Route::post('/customer-deposit', [CustomerController::class, 'customerDeposit']);
    Route::get('/customer-transaction/{id}', [CustomerController::class, 'getCustomerTransaction'])->name('customer.tran');
    Route::post('/customer-tran-update', [CustomerController::class, 'customerTranUpdate']);
    
    // sale
    Route::get('/sale', [SalesController::class, 'index'])->name('admin.sale');
    Route::post('/sale', [SalesController::class, 'store']);
    Route::get('/sale/{id}/edit', [SalesController::class, 'edit']);
    Route::put('/sale/{id}', [SalesController::class, 'update']);
    Route::get('/sale/{id}', [SalesController::class, 'delete']);

    // transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction');
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update']);


    // contact mail 
    Route::get('/contact-mail', [ContactMailController::class, 'index'])->name('admin.contact-mail');
    Route::get('/contact-mail/{id}/edit', [ContactMailController::class, 'edit']);
    Route::put('/contact-mail/{id}', [ContactMailController::class, 'update'])->name('admin.contact.update');

    // report
    Route::get('/sales-report', [ReportController::class, 'salesReport'])->name('admin.salesreport');
    Route::post('/sales-report', [ReportController::class, 'salesReport'])->name('salesReport.search');
    
    Route::get('/transaction-report', [ReportController::class, 'transactionReport'])->name('admin.transactionreport');
    Route::post('/transaction-report', [ReportController::class, 'transactionReport'])->name('transactionReport.search');


});
//admin part end