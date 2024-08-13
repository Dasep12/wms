<?php

use Illuminate\Support\Facades\Route;
use Modules\Administrator\App\Http\Controllers\AdministratorController;

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

Route::middleware(['check.session', 'check.menuAccess'])->prefix('administrator')->group(function () {

    // DASHBOARD ROUTES 
    Route::get('dashboard', 'DashboardController@index');
    Route::get('countCustomers', 'DashboardController@countCustomers');
    Route::get('countMaterial', 'DashboardController@countMaterial');
    Route::get('countInbound', 'DashboardController@countInbound');
    Route::get('countOutbound', 'DashboardController@countOutbound');
    Route::get('countAdjust', 'DashboardController@countAdjust');

    // UNITS ROUTES 
    Route::get('units', 'UnitsController@index');
    Route::get('jsonUnits', 'UnitsController@jsonUnits');
    Route::post('jsonCreateUnits', 'UnitsController@jsonCreate');
    Route::post('jsonDetailUnits', 'UnitsController@jsonDetail');
    Route::post('jsonUpdateUnits', 'UnitsController@jsonUpdate');
    Route::post('jsonDeleteUnits', 'UnitsController@jsonDelete');
    Route::get('jsonForListUnit', 'UnitsController@jsonForListUnit');


    // PACKAGING STORAGE ROUTES 
    Route::get('packaging', 'PackagingController@index');
    Route::get('jsonPackaging', 'PackagingController@jsonPackaging');
    Route::post('jsonCreatePackaging', 'PackagingController@jsonCreate');
    Route::post('jsonDetailPackaging', 'PackagingController@jsonDetail');
    Route::post('jsonUpdatePackaging', 'PackagingController@jsonUpdate');
    Route::post('jsonDeletePackaging', 'PackagingController@jsonDelete');
    Route::get('jsonForListPackaging', 'PackagingController@jsonForListPackaging');


    // MATERIAL ROUTES 
    Route::get('material', 'MaterialController@index');
    Route::get('jsonMaterial', 'MaterialController@jsonMaterial');
    Route::post('jsonCreateMaterial', 'MaterialController@jsonCreate');
    Route::post('jsonDetailMaterial', 'MaterialController@jsonDetail');
    Route::post('jsonUpdateMaterial', 'MaterialController@jsonUpdate');
    Route::post('jsonDeleteMaterial', 'MaterialController@jsonDelete');

    // CUSTOMERS ROUTES 
    Route::get('customers', 'CustomersController@index');
    Route::get('jsonCustomers', 'CustomersController@jsonCustomers');
    Route::post('jsonCreateCustomers', 'CustomersController@jsonCreate');
    Route::post('jsonDetailCustomers', 'CustomersController@jsonDetail');
    Route::post('jsonUpdateCustomers', 'CustomersController@jsonUpdate');
    Route::post('jsonDeleteCustomers', 'CustomersController@jsonDelete');
    Route::get('jsonForListCustomer', 'CustomersController@jsonForListCustomer');

    //  HANDLING  ROUTES
    Route::get('handling', 'HandlingController@index');
    Route::get('jsonHandling', 'HandlingController@jsonHandling');
    Route::post('jsonCreateHandling', 'HandlingController@jsonCreate');
    Route::post('jsonDetailHandling', 'HandlingController@jsonDetail');
    Route::post('jsonUpdateHandling', 'HandlingController@jsonUpdate');
    Route::post('jsonDeleteHandling', 'HandlingController@jsonDelete');


    //  WAREHOUSE  ROUTES
    Route::get('warehouse', 'WarehouseController@index');
    Route::get('jsonWarehouse', 'WarehouseController@jsonWarehouse');
    Route::post('jsonCreateWarehouse', 'WarehouseController@jsonCreate');
    Route::post('jsonDetailWarehouse', 'WarehouseController@jsonDetail');
    Route::post('jsonUpdateWarehouse', 'WarehouseController@jsonUpdate');
    Route::post('jsonDeleteWarehouse', 'WarehouseController@jsonDelete');


    // LOCATION ROUTES 
    Route::get('location', 'LocationController@index');
    Route::get('jsonLocation', 'LocationController@jsonLocation');
    Route::post('jsonCreateLocation', 'LocationController@jsonCreate');
    Route::post('jsonDetailLocation', 'LocationController@jsonDetail');
    Route::post('jsonUpdateLocation', 'LocationController@jsonUpdate');
    Route::post('jsonDeleteLocation', 'LocationController@jsonDelete');
    Route::get('jsonForListLocation', 'LocationController@jsonForListLocation');


    // INBOUND ROUTES 
    Route::get('inbound', 'InboundController@index');
    Route::get('jsonInbound', 'InboundController@jsonInbound');
    Route::post('jsonCreateInbound', 'InboundController@jsonCreateInbound');
    Route::post('jsonUpdateInbound', 'InboundController@jsonUpdateInbound');
    Route::post('jsonDeleteInbound', 'InboundController@jsonDeleteInbound');
    Route::post('jsonPutawayInbound', 'InboundController@jsonPutawayInbound');


    Route::get('jsonDetailMaterial', 'InboundController@jsonDetailMaterial');
    Route::get('jsonListUnitsByCustomers', 'InboundController@jsonListUnitsByCustomers');
    Route::get('jsonListMaterialByCustomers', 'InboundController@jsonListMaterialByCustomers');
    Route::get('jsonDetailListMaterialEdit', 'InboundController@jsonDetailListMaterialEdit');


    // OUTBOUND ROUTES 
    Route::get('outbound', 'OutboundController@index');
    Route::get('jsonOutbound', 'OutboundController@jsonOutbound');
    Route::post('jsonCreateOutbound', 'OutboundController@jsonCreateOutbound');
    Route::post('jsonUpdateOutbound', 'OutboundController@jsonUpdateOutbound');
    Route::post('jsonDeleteOutbound', 'OutboundController@jsonDeleteOutbound');
    Route::post('jsonPutawayOutbound', 'OutboundController@jsonPutawayOutbound');
    Route::get('jsonStockListMaterialByCustomers', 'OutboundController@jsonStockListMaterialByCustomers');
    Route::get('jsonSuratJalanOutbound', 'OutboundController@jsonSuratJalanOutbound');
    Route::post('generateDN', 'OutboundController@generateDN');


    // MATERIAL SUMMARY 
    Route::get('summary', 'SummaryController@index');
    Route::get('jsonSummary', 'SummaryController@jsonSummary');
    Route::get('jsonDetailSummary', 'SummaryController@jsonDetailSummary');


    // ROLES ROUTES 
    Route::get('roles', 'RolesController@index');
    Route::get('jsonRole', 'RolesController@jsonRole');
    Route::get('jsonDetailListMenu', 'RolesController@jsonDetailListMenu');
    Route::post('jsonCreateRoles', 'RolesController@jsonCreate');
    Route::post('jsonDeleteRoles', 'RolesController@jsonDelete');
    Route::post('jsonUpdateRoles', 'RolesController@jsonUpdate');
    Route::get('jsonForListRoles', 'RolesController@jsonForListRoles');


    // USERS ROUTES 
    Route::get('users', 'UsersController@index');
    Route::get('jsonUsers', 'UsersController@jsonUsers');
    Route::get('jsonListMenuForUsers', 'UsersController@jsonListMenuForUsers');
    Route::post('jsonCreateUsers', 'UsersController@jsonCreate');
    Route::post('jsonDeleteUsers', 'UsersController@jsonDelete');
    Route::post('jsonUpdateUsers', 'UsersController@jsonUpdate');



    // ADJUSTMENT ROUTES 
    Route::get('adjustment', 'AdjustmentController@index');
    Route::get('jsonAdjustment', 'AdjustmentController@jsonAdjustment');
    Route::post('jsonCreateAdjustment', 'AdjustmentController@jsonCreateAdjustment');
    Route::post('jsonUpdateAdjustment', 'AdjustmentController@jsonUpdateAdjustment');
    Route::post('jsonDeleteAdjustment', 'AdjustmentController@jsonDeleteAdjustment');
    Route::post('jsonPutawayAdjustment', 'AdjustmentController@jsonPutawayAdjustment');
    Route::get('jsonStockListMaterialByCustomers', 'AdjustmentController@jsonStockListMaterialByCustomers');
    Route::post('generateDN', 'AdjustmentController@generateDN');
});
