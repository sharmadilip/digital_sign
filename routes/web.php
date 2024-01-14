<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('addtemplate', ['as' => 'pages.addtemplate', 'uses' => 'App\Http\Controllers\PDFController@add_pdf_template']);
		Route::post('generatepdf', ['as' => 'pages.generatepdf', 'uses' => 'App\Http\Controllers\PDFController@view_pdf_data']);
		Route::get('generatepdf_template', ['as' => 'pages.generatepdf_template', 'uses' => 'App\Http\Controllers\PDFController@view_pdf_template']);
		Route::post('savepdftemplate', ['as' => 'pages.savepdftemplate', 'uses' => 'App\Http\Controllers\PDFController@save_pdf_template']);
		Route::post('deletepdftemplate', ['as' => 'pages.deletepdftemplate', 'uses' => 'App\Http\Controllers\PDFController@delete_pdf_tempalte']);
        Route::get('templatelist', ['as' => 'pages.templatelist', 'uses' => 'App\Http\Controllers\PDFController@list_pdf_template']);
		Route::get('invoicelist', ['as' => 'pages.invoicelist', 'uses' => 'App\Http\Controllers\InvoiceController@view_invoice']);
		Route::get('addinvoice', ['as' => 'pages.addinvoice', 'uses' => 'App\Http\Controllers\InvoiceController@add_invoice']);
		Route::get('delete_contract', ['as' => 'pages.deletecontract', 'uses' => 'App\Http\Controllers\InvoiceController@delete_contract_data']);
		Route::post('saveinvoice', ['as' => 'pages.saveinvoice', 'uses' => 'App\Http\Controllers\InvoiceController@save_invoice']);
		Route::get('viewinvoice', ['as' => 'pages.viewinvoice', 'uses' => 'App\Http\Controllers\InvoiceController@view_invoice_pdf']);
		Route::post('sendcontract', ['as' => 'pages.sendcontract', 'uses' => 'App\Http\Controllers\InvoiceController@send_contract_client']);
		Route::get('add_email_template', ['as' => 'pages.addemailtemplate', 'uses' => 'App\Http\Controllers\HomeController@add_email_template']);
		Route::post('save_email_template', ['as' => 'pages.saveemailtemplate', 'uses' => 'App\Http\Controllers\HomeController@save_email_template']);
		Route::get('view_email_template', ['as' => 'pages.viewemailtemplate', 'uses' => 'App\Http\Controllers\HomeController@view_email_tempalte']);
		Route::get('delete_email_template', ['as' => 'pages.deleteemailtemplate', 'uses' => 'App\Http\Controllers\HomeController@delete_template']);
		
});
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
//---------without login------------------
Route::get('invoice_view_client', ['as' => 'pages.invoiceviewcleint', 'uses' => 'App\Http\Controllers\SignController@display_pdf_for']);
Route::post('save_signature_db', ['as' => 'pages.savesignaturedb', 'uses' => 'App\Http\Controllers\SignController@save_signature_to_db']);
Route::post('approve_contract', ['as' => 'pages.approvecontract', 'uses' => 'App\Http\Controllers\SignController@approve_invoice_signature']);
Route::get('viewcontract', ['as' => 'pages.viewcontract', 'uses' => 'App\Http\Controllers\SignController@download_invoice']);



