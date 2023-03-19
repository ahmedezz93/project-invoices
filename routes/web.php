<?php

use App\Http\Controllers\Archive_InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Customrs_ReportsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Report_InvoicesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return view('auth.login ');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('sections',function(){

    return view('sections.sections');
});

Route::get('newtest',function(){
  return  view('auth.register');
});

Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);

//-------------------------routes invoices------------------------
Route::resource('invoices',InvoiceController::class);
Route::get('edit_invoice/{id}',[InvoiceController::class,'edit'])->name('edit_invoice');
Route::post('update',[InvoiceController::class,'update'])->name('update_invoice');
Route::get('add_invoice',[InvoiceController::class,'add_invoice'])->name('add_invoice');
Route::get('delete_invoice/{id}',[InvoiceController::class,'delete'])->name('delete_invoice');
Route::get('change_payment/{id}',[InvoiceController::class,'change_payment'])->name('change_payment');
Route::post('update_payment',[InvoiceController::class,'update_payment'])->name('update_payment');
Route::get('archive_invoice/{id}',[Archive_InvoiceController::class,'archive_invoice'])->name('archive_invoice');//---------------     نقل الفاتورة للارشيف
Route::get('print_invoice/{id}',[InvoiceController::class,'print_invoice'])->name('print_invoice');
Route::get('paid_invoice',[InvoiceController::class,'paid_invoice'])->name('paid_invoice');
Route::get('unpaid_invoice',[InvoiceController::class,'unpaid_invoice'])->name('unpaid_invoice');
Route::get('partial_paid__invoice',[InvoiceController::class,'partial_paid__invoice'])->name('partial_paid__invoice');
Route::get('archived_invoice',[Archive_InvoiceController::class,'archived_invoice'])->name('archived_invoice'); //------نقل الفواتير  للارشيف

Route::get('delete_paid_invoice',[InvoiceController::class,'delete_paid_invoice'])->name('delete_paid_invoice');//---------------حذف الفاتورة
Route::get('export_invoices',[InvoiceController::class,'export'])->name('export_invoices');


Route::get('invoice_archive',[Archive_InvoiceController::class,'index'])->name('invoice_archive');//--------------- الفواتير المؤرشفة
Route::get('transfer_invoice',[Archive_InvoiceController::class,'transfer_invoice'])->name('transfer_invoice');
Route::get('delete_archived_invoice',[Archive_InvoiceController::class,'delete_archived_invoice'])->name('delete_archived_invoice');
Route::get('get_product/{id}',[InvoiceController::class,'get_product'])->name('get_product');


Route::get('test', function () {
    return view('table-data');
});


//------------------------------------report --------------------------

Route::get("invoices_reports",[Report_InvoicesController::class,'index'])->name('invoices_reports');
Route::post("invoice_search",[Report_InvoicesController::class,'invoice_search'])->name('invoice_search');
Route::get("customers_reports",[Customrs_ReportsController::class,'index'])->name('customers_reports');
Route::post("search_customers_reports",[Customrs_ReportsController::class,'search_customers_reports'])->name('search_customers_reports');

Route::get("get_product",[Customrs_ReportsController::class,'get_product'])->name('get_product');


//---------------------------------------counts-----------------------------------------

Route::get("dashboard",[HomeController::class,'count_invoices'])->name('dashboard');


//-------------------------------------attachments-------------------------------------------------

Route::get('invoice_attachments/{id}',[InvoiceAttachmentController::class,'index'])->name('invoice_attachments');
Route::post('create_attachments',[InvoiceAttachmentController::class,'create'])->name('create_attachments');
Route::get('view_file/{id}',[InvoiceAttachmentController::class,'view_file'])->name('view_file');
Route::get('download_file/{id}',[InvoiceAttachmentController::class,'download_file'])->name('download_file');
Route::get('delete_attachment',[InvoiceAttachmentController::class,'delete_attachment'])->name('delete_attachment');


//------------------------------------notifications---------------------------------------------------------------------

Route::get('read_notification/{id}',[NotificationController::class,'read_notification'])->name('read_notification');




//----------------------------------------------------------------------------------------------------------

    Route::middleware(['auth'])->group(function () {

        Route::resource('roles',RoleController::class);
        Route::post('delete_user',[UserController::class,'destroy'])->name('delete_user');
        Route::resource('users',UserController::class);


    });

require __DIR__.'/auth.php';
