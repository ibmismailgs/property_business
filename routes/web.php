<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Project\ProjectPackageController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Contactor\ContactorController;
use App\Http\Controllers\Contactor\SubContactorController;
use App\Http\Controllers\Project\PackageTypeController;
use App\Http\Controllers\Project\UnitController;
use App\Http\Controllers\Project\ItemsController;
use App\Http\Controllers\Designation\DesignationController;
use App\Http\Controllers\Project\ProjectAssignController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Inventory\InventoryGroupController;
use App\Http\Controllers\Inventory\InventoryItemController;
use App\Http\Controllers\Inventory\InventoryCategoryController;
use App\Http\Controllers\Inventory\InventorySubCategoryController;
use App\Http\Controllers\Inventory\ComponentController;
use App\Http\Controllers\ItemInventory\ItemInventoryController;
use App\Http\Controllers\BankController;


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
Route::get('/', function () { return view('auth.login'); });


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);
	// dashboard route
	Route::get('/dashboard', function () {
		return view('pages.dashboard');
	})->name('dashboard');

    // get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);
	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example');
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () {
		return view('pages.datatable-editable');
	});

	//Account
    Route::group([], function(){
        Route::resource('banks','account\BankController');
        Route::resource('accounts','account\AccountController');
        Route::resource('transactions','account\TransactionController');

        //Server side data table ajax request
        Route::post('getBankList',[\App\Http\Controllers\Account\BankController::class,'getBankList'])->name('getBankList');
        Route::post('getAccountList',[\App\Http\Controllers\Account\AccountController::class,'getAccountList'])->name('getAccountList');
        Route::post('getTransactionList',[\App\Http\Controllers\Account\TransactionController::class,'getTransactionList'])->name('getTransactionList');

        //Accounts
        Route::get('accounts-transactions-reports/{id}',[\App\Http\Controllers\Account\AccountController::class,'accountsTransactionsReports'])->name('accounts.transactions.reports');
        Route::post('get-accounts-transactions-reports',[\App\Http\Controllers\Account\AccountController::class,'getAccountsTransactionsReports'])->name('get.accounts.transactions.reports');
    });



    Route::group(['namespace' => 'Inventory'], function () {
        //only those have manage_user permission will get access
        Route::group(['middleware' => 'can:manage_user'], function(){
        Route::get('/users', [UserController::class,'index']);
        Route::get('/user/get-list', [UserController::class,'getUserList']);
        Route::get('/user/create', [UserController::class,'create']);
        Route::post('/user/create', [UserController::class,'store'])->name('create-user');
        Route::get('/user/{id}', [UserController::class,'edit']);
        Route::post('/user/update', [UserController::class,'update']);
        Route::get('/user/delete/{id}', [UserController::class,'delete']);
        });

        //only those have manage_role permission will get access
        Route::group(['middleware' => 'can:manage_role'], function(){
            Route::get('/roles', [RolesController::class,'index']);
            Route::get('/role/get-list', [RolesController::class,'getRoleList']);
            Route::post('/role/create', [RolesController::class,'create']);
            Route::get('/role/edit/{id}', [RolesController::class,'edit']);
            Route::post('/role/update', [RolesController::class,'update']);
            Route::get('/role/delete/{id}', [RolesController::class,'delete']);
        });

        //only those have manage_permission permission will get access
        Route::group(['middleware' => 'can:manage_permission'], function(){
            Route::get('/permission', [PermissionController::class,'index']);
            Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
            Route::post('/permission/create', [PermissionController::class,'create']);
            Route::get('/permission/update', [PermissionController::class,'update']);
            Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
        });

    });

});


// Route::get('/register', function () { return view('pages.register'); });
// Route::get('/login-1', function () { return view('pages.login'); });

Route::middleware(['auth'])->group(function(){
    Route::resource('project-type','Project\ProjectTypeController');
});

Route::group([], function(){
    Route::resource('project-packages','Project\ProjectPackageController');
    Route::resource('projects','Project\ProjectController');
    Route::resource('contactors','Contactor\ContactorController');
    Route::resource('designation','Designation\DesignationController');
    Route::resource('employees','Employee\EmployeeController');
    Route::resource('project-assign','Project\ProjectAssignController');
});

Route::group([],function(){
    Route::resource('package-type','Project\PackageTypeController');
    Route::resource('package-unit','Project\UnitController');
    Route::resource('package-items','Project\ItemsController');
    Route::get('view-project-packages', [ProjectController::class,'packageShow']);
});

Route::group([],function(){
    Route::resource('inventory-group','Inventory\InventoryGroupController');
    Route::resource('inventory-items','Inventory\InventoryItemController');
    Route::resource('inventory-category','Inventory\InventoryCategoryController');
    Route::post('getInventoryCategoryList', [InventoryCategoryController::class, 'getInventoryCategoryList'])->name('getInventoryCategoryList');
    Route::resource('inventory-subcategory','Inventory\InventorySubCategoryController');
    Route::post('getInventorySubCategoryList', [InventorySubCategoryController::class, 'getInventorySubCategoryList'])->name('getInventorySubCategoryList');
});

Route::resource('item-inventory','ItemInventory\ItemInventoryController');
Route::post('selectsubcategory',[ItemInventoryController::class, 'subcategory']);

Route::group([],function(){
    Route::resource('components','Inventory\ComponentController');
    Route::get('components-export',[ComponentController::class, 'export']);
    Route::get('components-import-data',[ComponentController::class, 'importdata']);
    Route::get('components-import-download',[ComponentController::class, 'filedownload']);
    Route::post('components-export-data',[ComponentController::class, 'exportdata']);

});


