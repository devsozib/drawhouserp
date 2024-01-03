<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelpersController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\HRIS\Setup\JobPostController;
use App\Http\Controllers\HRIS\Tools\CalendarController;
use App\Http\Controllers\HRIS\Database\EmpUserController;
use App\Http\Controllers\LakeshoreBakery\LbHomeController;
use App\Http\Controllers\HRIS\Applicant\InterviewController;
use App\Http\Controllers\Library\ProductManagement\SCAIngController;
use App\Http\Controllers\Library\ProductManagement\SubCatAddonController;
use App\Http\Controllers\Employee\AttendanceManagement\AttendanceApprovalController;


// login
Route::get('/', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));

Route::group(array('namespace' => 'Auth'), function () {
    Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));
    Route::get('login', array('as' => 'login.get', 'uses' => 'AuthController@getLogin'));
    Route::post('login', array('as' => 'login.post', 'uses' => 'AuthController@postLogin'));
    Route::get('registration', array('as' => 'registration.get', 'uses' => 'AuthController@getRegistration'));
    Route::post('registration', array('as' => 'registration.post', 'uses' => 'AuthController@postRegistration'));
});
//welcome
Route::get('welcome', array('as' => 'welcome', 'middleware' => ['sentinel.auth', 'preventbackhistory'], 'uses' => 'WelcomeController@index'));

//Employee Profile
Route::group(array('prefix' => '/employee', 'namespace' => 'Employee', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'employee.dashboard', 'uses' => 'DashboardController@index'));
    Route::get('empfeedback',array('as' => 'employee.dashboard', 'uses' => 'DashboardController@getFeedback'))->name('emp.feedback');
    Route::get('/events', [CalendarController::class, 'getEvents']);
    Route::get('store-notes', [HelpersController::class, 'storeNotes']);
    Route::get('delete-notes', [HelpersController::class, 'deleteNotes']);
    Route::get('delete-notes', [HelpersController::class, 'deleteNotes']);
    Route::get('get-users', [HelpersController::class, 'getUsers']);
    Route::get('submit-selected-employees', [HelpersController::class, 'submitSelectedEmployees']);
    Route::resource('empperformance', 'PerformanceController');
    Route::post('upload-profile-image', [UserController::class, 'uploadProfileImage'])->name('upload-profile-image');
    //employee_self_service
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('edit-profile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::group(array('prefix' => '/leave_management', 'namespace' => 'LeaveManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('leave_application', 'LeaveApplicationController');
        Route::resource('leave_status', 'LeaveStatusController');
    });
    Route::group(array('prefix' => '/resource_hub', 'namespace' => 'ResourceHub', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('emptask', 'TaskController');
        Route::post('update-task-status', 'TaskController@taskStatusUpdate')->name('update.task.status');
        Route::resource('announcement', 'NoticeController');
        Route::resource('empmeeting', 'MeetingController');
    });

    Route::group(array('prefix' => '/learning_development', 'namespace' => 'LearningDevelopment', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('training_calling', 'TrainingMasterController');
    });

    Route::group(array('prefix' => '/emppayroll', 'namespace' => 'EmpPayroll', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('my-roaster', 'ShiftingController');
    });

    Route::group(array('prefix' => '/attendence_time_management', 'namespace' => 'AttendanceManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::get('attendance_approval', 'AttendanceApprovalController@attendanceApprovalForm');
        Route::post('attendance_approval_request', 'AttendanceApprovalController@store')->name('add_attendance_approval_request');
    });
});
//admin
Route::group(array('prefix' => '/admin', 'namespace' => 'Admin', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'DashboardController@index'));
    Route::resource('user', 'UserController');
    Route::post('user/{id}/toggleactivating', array('as' => 'admin.user.toggleactivating', 'uses' => 'UserController@ToggleActivating'))->where('id', '[0-9]+');
    Route::resource('role', 'RoleController');
    Route::resource('modules', 'ModulesController');
    Route::resource('menus', 'MenusController');
    Route::resource('childmenus', 'ChildMenusController');
    Route::post('childmenus/{id}', 'ChildMenusController@AddChildMenu')->where('id', '[0-9]+');
    Route::get('logactivity', 'LogActivityController@index');
    Route::post('logactivity/search', 'LogActivityController@getSearch');
    Route::resource('mailing', 'MailingController');
    Route::get('feedback',array('as' => 'admin.dashboard', 'uses' => 'DashboardController@getFeedback'))->name('feedback');
});

//api
Route::get('getmenus', 'HelpersController@getMenus');
Route::get('getsubcating', 'HelpersController@getSubCatIng');
Route::get('getsubcatpro', 'HelpersController@getSubCatPro');
Route::get('getsubcataddoning', 'HelpersController@getSubCatAddonIng');
Route::get('changewebstatus', 'HelpersController@changeWebStatus');
Route::get('getproducting', 'HelpersController@getProductIng');
Route::get('getprooptntitle', 'HelpersController@getProOptnTitle');
Route::get('getprooptiontitle', 'HelpersController@getProOptionTitle');
Route::get('getprooptions', 'HelpersController@getProOptions');
Route::get('getprooptioningdata', 'HelpersController@getProOptionIngData');
Route::get('productaddoning', 'HelpersController@productAddonIng');
Route::get('getingredient', 'HelpersController@getIngredient');
Route::get('getasset', 'HelpersController@getAsset');
Route::get('getunit', 'HelpersController@getUnit');
Route::get('getrequisition', 'HelpersController@getRequisition');
Route::get('getpurhaseid', 'HelpersController@getPurhaseId');
Route::get('getpurhaseiteminfo', 'HelpersController@getPurhaseItemInfo');
Route::get('gatecheckedpurchid', 'HelpersController@gateCheckPurchId');
Route::get('getCategory', 'HelpersController@getCategory');
Route::get('updateApplicant', 'HelpersController@updateApplicant');
Route::get('getempandjobappraisal', 'HelpersController@empAndJobAppraisal');
Route::get('getempinfo', 'HelpersController@getempinfo');
Route::get('getthana', 'HelpersController@getThana');
Route::get('getdepartment', 'HelpersController@getDepartment');
Route::get('getdesignation', 'HelpersController@getDesignation');
Route::get('getparticipant', 'HelpersController@getParticipant');
Route::get('attendence', 'HelpersController@attendence');
Route::get('meetingattendence', 'HelpersController@meetingAttendence');
Route::get('notifications', 'HelpersController@notifications');
// Route::post('upload-profile-image', 'HelpersController@uploadProfileImage')->name('upload-profile-image');
Route::get('product-sizes', 'HelpersController@getProductSizes')->name('product_sizes');
Route::get('product-option-addon', 'HelpersController@getProductOptinAndAddon')->name('product_option_addon');
Route::get('search-customer', 'HelpersController@searchCustomer')->name('search_customer');
Route::get('add-customer-by-ajax', 'HelpersController@addCustomer')->name('add_customer_by_ajax');
Route::get('get-table-by-ajax', 'HelpersController@getTableAndRooms')->name('get_tables_and_rooms_by_ajax');
Route::get('get-server-by-ajax', 'HelpersController@getServer')->name('get_server_by_ajax');
Route::get('get_concern_wise_category_by_ajax', 'HelpersController@getCetegory')->name('get_concern_wise_category_by_ajax');
Route::get('get_concern_wise_product_by_ajax', 'HelpersController@getProduct')->name('get_concern_wise_product_by_ajax');
Route::get('add_product_to_list_by_ajax', 'HelpersController@addProductToListFromPos')->name('add_product_to_list_by_ajax');
Route::get('get_table_item_list_by_ajax', 'HelpersController@getTableItems')->name('get_table_item_list_by_ajax');
Route::get('table_item_quantity_update_by_ajax', 'HelpersController@updateTableItemQuantity')->name('table_item_quantity_update_by_ajax');
Route::get('remove_table_item_by_ajax', 'HelpersController@removeTableItem')->name('remove_table_item_by_ajax');
Route::get('get_payment_method_selectOptions_by_ajax', 'HelpersController@getPaymentMethodSelectOption')->name('get_payment_method_selectOptions_by_ajax');
Route::post('update_column_value_by_ajx', 'HelpersController@updateColumnValue')->name('update_column_value_by_ajx');

Route::post('save_pos_order_by_ajax', 'HelpersController@savePosOrder')->name('save_pos_order_by_ajax');
Route::get('make_order_complimentary_by_ajax', 'HelpersController@makeOrderComplimentary')->name('make_order_complimentary_by_ajax');

Route::get('updateOrder_from_pos_by_ajax', 'HelpersController@updatePosOrder')->name('updateOrder_from_pos_by_ajax');
Route::get('cancel_pos_order_by_ajax', 'HelpersController@cancelPosOrder')->name('cancel_pos_order_by_ajax');
Route::get('get_booked_table_by_ajax', 'HelpersController@getBookedTables')->name('get_booked_table_by_ajax');
Route::get('get_customer_address_by_ajax', 'HelpersController@getCustomerAddress')->name('get_customer_address_by_ajax');
Route::get('get_customer_profile_by_ajax', 'HelpersController@getCustomerProfile')->name('get_customer_profile_by_ajax');
Route::get('set_discount_to_customer_by_ajax', 'HelpersController@setDiscountToCustomer')->name('set_discount_to_customer_by_ajax');



Route::post('add_kot_comment', 'HelpersController@addKotComment')->name('add_kot_comment');
//Feedbacks
Route::post('feedback','HelpersController@addfeedback')->name('add.feedback');




//library
Route::group(array('prefix' => '/library', 'namespace' => 'Library', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'library.dashboard', 'uses' => 'DashboardController@index'));
    //general
    Route::group(array('prefix' => '/general', 'namespace' => 'General', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'library.general', 'uses' => 'GeneralController@index'));
        Route::resource('company', 'CompanyController');
        Route::resource('customers', 'CustomerController');
        // Route::resource('customer_profile', 'CustomerController');
        Route::resource('suppliers', 'SupplierController');
        Route::resource('asset-list', 'AssetItemController');
        Route::resource('table', 'TableController');
        Route::resource('room', 'RoomController');
        // Route::post('room', 'RoomController@storeRoom');
        Route::resource('payment_method', 'PaymentMethodController');
        Route::resource('discount_category', 'DiscountCategoryController');
    });
    //ProductManagement
    Route::group(array('prefix' => '/product_management', 'namespace' => 'ProductManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        route::resource('ingredient_category', 'IngredientCategoryController');
        route::resource('ingredient_sub_category', 'IngredientSubCategoryController');
        route::resource('ingredient', 'IngredientController');
        route::resource('unit', 'UnitController');
        route::resource('product_category', 'ProductCategoryController');
        route::resource('product_sub_category', 'ProductSubCategoryController');
        route::resource('products', 'ProductController');
        //addon for sub category
        Route::get('sub_cat_addon/{cat_id}', [SubCatAddonController::class, 'index'])->name('sca.index');
        Route::post('sub_cat_addon', [SubCatAddonController::class, 'store'])->name('sca.store');
        Route::get('sub_cat_addon/{id}', [SubCatAddonController::class, 'edit'])->name('sca.edit');
        Route::post('sub_cat_addon_update', [SubCatAddonController::class, 'update'])->name('sca.update');
        Route::delete('sub_cat_addon/{id}', [SubCatAddonController::class, 'destroy'])->name('sca.delete');
        //Sub Cat addon ingredients
        Route::get('sca-ingredient/{id}', [SCAIngController::class, 'index'])->name('sca_ing.index');
        Route::post('sca-ingredient-store', [SCAIngController::class, 'store'])->name('sca_ing.store');
        Route::get('delete-adn-ing/{id}', [SCAIngController::class, 'destroy'])->name('sca_ing.delete');
        //Product Size
        Route::get('product-size/{id}', 'ProductSizeController@index')->name('productsize.index');
        Route::post('product-size', 'ProductSizeController@store')->name('productsize.store');
        Route::patch('product-size', 'ProductSizeController@update')->name('productsize.update');
        Route::delete('productsize-delete/{id}', 'ProductSizeController@destroy')->name('productsize.delete');
        //Product Ingredient
        Route::get('product-ingredients/{id}', 'ProductIngController@index')->name('producting.index');
        Route::post('product-ingredients', 'ProductIngController@store')->name('producting.store');
        Route::get('product-ingredients-edit/{id}', 'ProductIngController@edit')->name('producting.edit');
        Route::patch('product-ingredients-update', 'ProductIngController@update')->name('producting.update');
        Route::get('product-ingredients-delete/{id}', 'ProductIngController@destroy')->name('producting.delete');

        //product option titles
        Route::get('product-option-title/{id}', 'ProOptionTitleController@index')->name('proopttitle.index');
        Route::post('product-option-title', 'ProOptionTitleController@store')->name('proopttitle.store');
        Route::get('product-option-title-edit/{id}', 'ProOptionTitleController@edit')->name('proopttitle.edit');
        Route::patch('product-option-title-update', 'ProOptionTitleController@update')->name('proopttitle.update');
        Route::get('product-option-title-delete/{id}', 'ProOptionTitleController@destroy')->name('proopttitle.delete');

        //product option
        Route::get('product-option/{id}', 'ProOptionController@index')->name('prooption.indx');
        Route::post('product-option', 'ProOptionController@store')->name('prooption.store');
        Route::get('product-option-edit/{id}', 'ProOptionController@edit')->name('prooption.edit');
        Route::patch('product-option', 'ProOptionController@update')->name('prooption.update');
        Route::get('product-option-delete/{id}', 'ProOptionController@destroy')->name('prooption.delete');
        //product option Ingredients
        Route::get('product-option-ing/{id}', 'ProductOptnIngController@index')->name('prooptioning.indx');
        Route::post('product-option-ing', 'ProductOptnIngController@store')->name('prooptioning.store');
        Route::get('product-option-ing-edit/{id}', 'ProductOptnIngController@edit')->name('prooptioning.edit');
        Route::patch('product-option-ing', 'ProductOptnIngController@update')->name('prooptioning.update');
        Route::get('product-option-ing-delete/{id}', 'ProductOptnIngController@destroy')->name('prooptioning.delete');
        //product addon
        Route::get('product-addon/{id}', 'ProductAdonController@index')->name('proaddon.indx');
        Route::post('product-addon', 'ProductAdonController@store')->name('proaddon.store');
        Route::get('product-addon-edit/{id}', 'ProductAdonController@edit')->name('proaddon.edit');
        Route::patch('product-addon', 'ProductAdonController@update')->name('proaddon.update');
        Route::delete('product-addon', 'ProductAdonController@destroy')->name('proaddon.delete');
        //product addon ingredient
        Route::get('product-addon-ing/{id}', 'ProductAdnIngController@index')->name('proaddoning.indx');
        Route::post('product-addon-ing', 'ProductAdnIngController@store')->name('proaddoning.store');
        // Route::get('product-addon-ing-edit/{id}', 'ProductAdnIngController@edit')->name('proaddoning.edit');
        // Route::patch('product-addon-ing', 'ProductAdnIngController@update')->name('proaddoning.update');
        Route::get('product-addon-ing-delete/{id}', 'ProductAdnIngController@destroy')->name('proaddoning.delete');
    });

    //Expense Management
    Route::group(array('prefix' => '/expense_management', 'namespace' => 'ExpenseManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'library.general', 'uses' => 'GeneralController@index'));
        Route::resource('expense_type', 'ExpenseTypeController');
        Route::resource('expenses', 'ExpenseController');
    });

    Route::group(array('prefix' => '/order_management', 'namespace' => 'OrderManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::get('web-order', 'OrderManagementController@webOrder')->name('web.order');
        Route::get('all-order', 'OrderManagementController@posOrder')->name('pos.order');
        Route::get('kot-order', 'OrderManagementController@kotOrder')->name('kot.order');
        Route::get('ready_to_delivery', 'OrderManagementController@readyToDelivery')->name('ready.to.delivery');
        Route::get('discount_approval', 'OrderManagementController@discountApproval')->name('discount_approval');
        Route::post('update_discount_approval_status_by_ajax', 'OrderManagementController@updateDiscountApproval')->name('update_discount_approval_status_by_ajax');

        Route::get('pos-order-by-ajax', 'OrderManagementController@getPosOrder')->name('get_pos_order_by_ajax');
        Route::get('get_kot_order_by_ajax', 'OrderManagementController@getkotOrder')->name('get_kot_order_by_ajax');
        Route::get('get_ready_to_delivery_order_by_ajax', 'OrderManagementController@getReadyToDeliveryOrderList')->name('get_ready_to_delivery_order_by_ajax');

        Route::get('get_todays_orders_by_ajax', 'OrderManagementController@getTodaysOrders')->name('get_todays_orders_by_ajax');
        Route::get('cooking_start_by_ajax', 'OrderManagementController@cookingStart')->name('cooking_start_by_ajax');
        Route::get('cooking_end_by_ajax', 'OrderManagementController@cookingEnd')->name('cooking_end_by_ajax');
        Route::get('ready_to_serve_by_ajax', 'OrderManagementController@readyToServe')->name('ready_to_serve_by_ajax');
        Route::get('delivered_by_ajax', 'OrderManagementController@delivered')->name('delivered_by_ajax');

        Route::get('pos/kot/{id}', 'OrderManagementController@makeKot')->name('pos_kot');
        Route::get('pos/invoice/{id}', 'OrderManagementController@makeInvoice')->name('pos_invoice');
    });
    Route::group(array('prefix' => '/report', 'namespace' => 'OrderManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::get('sales_report', 'OrderManagementController@salesReport')->name('sales_report');
        Route::get('daily_report', 'OrderManagementController@dailyReport')->name('daily_report');
        Route::get('generate_sales_report_by_ajax', 'OrderManagementController@generateReport')->name('generate_sales_report_by_ajax');
        Route::get('generate_daily_sales_report_by_ajax', 'OrderManagementController@generateDailyReport')->name('generate_daily_sales_report_by_ajax');

    });
});

Route::group(array('prefix' => '/inventory', 'namespace' => 'Inventory', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'inventory.dashboard', 'uses' => 'DashboardController@index'));
    //waste_management
    Route::group(array('prefix' => '/waste_management', 'namespace' => 'WasteManagement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'library.general', 'uses' => 'GeneralController@index'));
        Route::resource('waste_ingredient', 'WasteIngredientController');
        Route::resource('waste_asset', 'WasteAssetController');
    });
    //procurement
    Route::group(array('prefix' => '/procurement', 'namespace' => 'Procurement', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'library.general', 'uses' => 'GeneralController@index'));
        Route::resource('requisition', 'RequisitionController');
        Route::resource('issuerequisition', 'IssueRequisitionController');
        Route::get('getissuerequisition', 'IssueRequisitionController@getData')->name('getReqItems');
        Route::post('postissuerequisition', 'IssueRequisitionController@IssueReqItems')->name('postReqItems');
        Route::resource('purchaseorder', 'PurchaseOrderController');
        Route::resource('purorderrecv', 'PurOrderRcvController');
        Route::get('getpurorderitems', 'PurOrderRcvController@getPurchItems')->name('getPurchItems');
        Route::post('gatecheckupdate', 'PurOrderRcvController@gatecheckUpdate')->name('gatecheckUpdate');
        Route::resource('receivedbystore', 'ReceivedByStoreController');
        Route::get('purchitemsaftercheck', 'ReceivedByStoreController@getPurchItemsAfterCheck')->name('purchItemsAfterCheck');
        Route::post('storecheckupdate', 'ReceivedByStoreController@storecheckUpdate')->name('storecheckUpdate');
        Route::get('/get-div-content', 'DivController@getDivContent');
        Route::get('inventories', 'InventoryController@index');
        Route::get('central_inventories', 'InventoryController@centralInventories');
    });
});

//hris
Route::group(array('prefix' => '/hris', 'namespace' => 'HRIS', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'hris.dashboard', 'uses' => 'DashboardController@index'));
    Route::get('/events', [CalendarController::class, 'getEvents']);
    Route::get('store-notes', [HelpersController::class, 'storeNotes']);
    Route::get('delete-notes', [HelpersController::class, 'deleteNotes']);
    Route::get('delete-notes', [HelpersController::class, 'deleteNotes']);
    Route::get('get-users', [HelpersController::class, 'getUsers']);
    Route::get('submit-selected-employees', [HelpersController::class, 'submitSelectedEmployees']);
    Route::get('hrfeedback',array('as' => 'hris.dashboard', 'uses' => 'DashboardController@getFeedback'))->name('hris.feedback');
    //database
    Route::group(array('prefix' => '/database', 'namespace' => 'Database', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'hris.database', 'uses' => 'DatabaseController@index'));
        //employee
        Route::resource('employee', 'EmployeeController');
        Route::post('employee/search', 'EmployeeController@getSearch');
        Route::post('employee/{id}', 'EmployeeController@addEmployeeData')->where('id', '[0-9]+');
        //Employee list
        Route::get('emlpyees', 'EmployeeController@getEmployeeList')->name('emlpyees');
        Route::get('birth-emlpyees', 'EmployeeController@getBEmployeeList')->name('b_emlpyees');

        //Employee History
        Route::post('employee-history/search', 'EmployeeController@getHistory');
        //dependent dropdown
        Route::get('getsubgrade', 'EmployeeController@getSubGrade');
        Route::get('getthana', 'EmployeeController@getThana');
        Route::get('getthanabn', 'EmployeeController@getThanaBn');
        Route::get('getemployee', 'EmployeeController@getEmployee');
        //employe tab action
        Route::resource('employee/education', 'EducationController');
        Route::resource('employee/training', 'TrainingController');
        Route::resource('employee/experience', 'ExperienceController');
        Route::resource('employee/reference', 'ReferenceController');
        Route::resource('employee/granter', 'GranterController');
        //leave
        Route::resource('leaveapplication', 'LeaveApplicationController');
        Route::get('getlvreason', 'LeaveApplicationController@getLVReason');
        Route::get('getemployeeinfo', 'LeaveApplicationController@getEmployeeInfo');
        Route::resource('leavestatus', 'LeaveStatusController');
        Route::post('leavestatus/{id}', 'LeaveStatusController@getLeaveStatus')->where('id', '[0-9]+');

        Route::resource('employeephoto', 'EmployeePhotoController');
        Route::get('getempphoto', 'EmployeePhotoController@getEmployeeInfo');

        Route::resource('advance', 'AdvanceController');
        Route::get('getadvanceempl', 'AdvanceController@getEmployeeInfo');

        Route::resource('punishment', 'PunishmentController');
        Route::get('getemployeepun', 'PunishmentController@getEmployee');
        Route::get('getemployeepundate', 'PunishmentController@getEmployeePun');
        Route::get('empentry/empentryinfo/{id}', array('as' => 'hris.database.empentry.empentryinfo', 'uses' => 'EmpEntryController@empentryinfo'))->where('id', '[0-9]+');
        Route::resource('empentry', 'EmpEntryController');
        Route::post('empentry/search', 'EmpEntryController@getSearch');
        Route::get('empentry/pdf/{id}', array('as' => 'hris.database.empentry.pdf', 'uses' => 'EmpEntryController@pdf'))->where('id', '[0-9]+');
        Route::get('designation/{id}', array('as' => 'hris.database.empentry.departmentByDesignationGet', 'uses' => 'EmpEntryController@departmentByDesignationGet'))->where('id', '[0-9]+');

        Route::resource('departure', 'DepartureController');
        Route::get('getdepartureemp', 'DepartureController@getEmployeeInfo');
        Route::resource('increment', 'IncrementController');
        Route::post('increment/search', 'IncrementController@getSearch');
        Route::resource('incapproval', 'IncApprovalController');
        Route::resource('leaveentry', 'LeaveEntryController');

        Route::get('attendance_status', 'EmployeeController@attendanceApprovalRequestList');
    });
    //tools
    Route::group(array('prefix' => '/tools', 'namespace' => 'Tools', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('calendar', 'CalendarController');
        Route::resource('shifting', 'ShiftingController');
        Route::get('getshifting', 'ShiftingController@getShifting');
        Route::get('getshiftingtwo', 'ShiftingController@getShiftingTwo');

        Route::resource('punchupload', 'PunchUploadController');
        Route::resource('attendanceprocess', 'AttendanceProcessController');
        Route::resource('advanceprocess', 'AdvanceProcessController');
        Route::resource('salaryprocess', 'SalaryProcessController');
        Route::resource('bonusprocess', 'BonusProcessController');
        Route::resource('service_charge', 'ServiceChargeController');
        Route::resource('salaryadjust', 'SalaryAdjustController');
        Route::get('getadjustemp', 'SalaryAdjustController@getEmployee');
        Route::get('getadjustempsa', 'SalaryAdjustController@getEmployeeSA');
        Route::resource('exceptionalhd', 'ExceptionalHDController');
        Route::get('getexceptionalhd', 'ExceptionalHDController@getExceptionalHD');
    });
    //reports
    Route::group(array('prefix' => '/reports', 'namespace' => 'Reports', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //listing reports
        Route::resource('listing', 'ListingReportController');
        Route::post('listing/preview', 'ListingReportController@preview');
        Route::get('listing/preview', 'ListingReportController@preview');
        Route::get('listing/pdf', 'ListingReportController@pdf');
        //attendance reports
        Route::resource('attendance', 'AttendanceReportController');
        Route::post('attendance/preview', 'AttendanceReportController@preview');
        Route::get('attendance/preview', 'AttendanceReportController@preview');
        Route::get('attendance/pdf', 'AttendanceReportController@pdf');
        //Salary reports
        Route::resource('salary', 'SalaryReportController');
        Route::post('salary/preview', 'SalaryReportController@preview');
        Route::get('salary/preview', 'SalaryReportController@preview');
        Route::get('salary/pdf', 'SalaryReportController@pdf');
        //Auto generation reports
        Route::resource('autogeneration', 'AutoGenerationController');
        Route::post('autogeneration/preview', 'AutoGenerationController@preview');
        Route::get('autogeneration/preview', 'AutoGenerationController@preview');
        Route::get('autogeneration/pdf', 'AutoGenerationController@pdf');
    });
    //Setup
    Route::group(array('prefix' => '/setup', 'namespace' => 'Setup', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('job_appraisal', 'JobAppraisalController');
        Route::resource('department', 'DepartmentController');
        Route::resource('designation', 'DesignationController');
        Route::resource('notice', 'NoticeController');
        Route::resource('job-post', 'JobPostController');
        Route::resource('meeting', 'MeetingController');
        Route::get('meeting-attendence/{id}', 'MeetingController@meetingAttendence')->name('meeting.attendence');
        Route::resource('task', 'TaskController');
        Route::resource('shift', 'ShiftController');
        Route::get('assgin-task/{id}', 'TaskController@assignTask')->name('assign');
        Route::post('assgin-post', 'TaskController@assignTaskPost')->name('assign.task');
        Route::resource('degree', 'DegreeController');
        Route::resource('leave_definitions', 'LeaveDefineController');
        Route::resource('hr_options', 'HROptionController');
        Route::resource('hdexceptions', 'HDExceptionController');
    });
    //Applicant
    Route::group(array('prefix' => '/applicant', 'namespace' => 'Applicant', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('new-applicant', 'ApplicantController');
        Route::post('new-applicant/search', 'ApplicantController@getSearch');
        Route::post('new-applicant/{id}', 'ApplicantController@addApplicantData')->where('id', '[0-9]+');
        Route::resource('interviews', 'InterviewController');
        Route::get('sl-candidates', 'ApplicantController@selectedCandidate')->name('sl.candidate');
        // Route::get('sl-candidates/print', 'ApplicantController@printShortlistedCandidates')->name('candidates.print');
    });
    //Training Management
    Route::group(array('prefix' => '/training', 'namespace' => 'Setup', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        //Route::get('/', array('as' => 'library.general', 'uses' => 'GeneralController@index'));
        Route::resource('training_master', 'TrainingMasterController');
        Route::get('assign-training/{id}', 'TrainingMasterController@assignParticipant')->name('assignParticipant');
        Route::post('assignparticipant', 'TrainingMasterController@assignParticipantPost')->name('assign.training');
        Route::get('tr-attendence/{id}', 'TrainingMasterController@trAttendence')->name('tr.attendence');
    });
    Route::group(array('prefix' => '/performance', 'namespace' => 'Database', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
        Route::resource('performance', 'PerformanceController');
    });
});
// ========== POS ============

Route::group(array('prefix' => '/pos', 'namespace' => 'POS', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'pos.dashboard', 'uses' => 'PosOrderController@index'));
    Route::get('split-bill', array('as' => 'save_split_bill_by_ajax', 'uses' => 'PosOrderController@saveSplitBill'));
    // Route::get('product_sizes', array('as' => 'product_sizes', 'uses' => 'DashboardController@getProductSizes'));
});
Route::group(array('prefix' => '/whole_sale', 'namespace' => 'POS', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'whole_sale.dashboard', 'uses' => 'PosOrderController@wholeSales'));
});
Route::group(array('prefix' => '/corporate_sale', 'namespace' => 'POS', 'middleware' => ['sentinel.auth', 'preventbackhistory']), function () {
    Route::get('dashboard', array('as' => 'corporate_sale.dashboard', 'uses' => 'PosOrderController@corporateSale'));
});


// Login Routes
Route::get('/empuser/login', [EmpUserController::class, 'showLoginForm'])->name('empuser.login');
Route::post('/empuser/login', [EmpUserController::class, 'login'])->name('empuser.login.post');
Route::post('/empuser/switch', [EmpUserController::class, 'switchAccount'])->name('switch_account');


// Registration Routes
Route::get('/empuser/register', [EmpUserController::class, 'showRegistrationForm'])->name('empuser.register');
Route::post('/empuser/register', [EmpUserController::class, 'register'])->name('empuser.register.post');

// Logout Route
Route::get('/empuser/logout', [EmpUserController::class, 'logout'])->name('empuser.logout');
Route::get('/empuser/profile/{id}', [EmpUserController::class, 'profile'])->name('empuser.profile')->middleware('auth.empuser');
//Career
Route::get('/careers', [InterviewController::class, 'careerIndex'])->name('careers');
Route::get('job/{id}', [JobPostController::class, 'show'])->name('job.details');
Route::get('apply-job/{id}', [InterviewController::class, 'applyJob'])->name('apply.job');
Route::post('/careers', [InterviewController::class, 'applyPost'])->name('careers.post')->middleware('auth.empuser');
Route::get('apply-job-mannually',[JobPostController::class,'applyJobManually'])->name('apply.job.manually')->middleware('auth.empuser');
Route::post('apply-job-mannually',[JobPostController::class,'applyJobManuallyPost'])->name('apply.job.manually')->middleware('auth.empuser');


//Frontend
Route::get('/frontend', [HomeController::class, 'index'])->name('frontend');
Route::get('product-details/{id}', [HomeController::class, 'productDetails'])->name('product.details');
Route::get('/frontend/about', function () {
    return view('frontend.about');
});
Route::get('/frontend/login', function () {

    if (Auth::guard('customer')->check()) {
        return redirect()->route('frontend');
    } else {
        return view('frontend.login');
    }
});
Route::get('/frontend/register', function () {

    if (Auth::guard('customer')->check()) {
        return redirect()->route('frontend');
    } else {
        return view('frontend.register');
    }
});
Route::get('/frontend/menu/{id?}/{subcat?}', [HomeController::class, 'menu'])->name('menu');
Route::get('/frontend/event', function () {
    return view('frontend.event');
});
Route::get('/frontend/cart', function () {
    return view('frontend.cart');
});
Route::get('/frontend/checkout', function () {
    return view('frontend.checkout');
});
Route::get('/frontend/termsandconditions', function () {
    return view('frontend.termsandconditions');
});



Route::post('/frontend/add-to-cart', [HomeController::class, 'addToCart'])->name('addToCart');
Route::post('/frontend/remove-to-cart', [HomeController::class, 'removeToCart'])->name('removeToCart');
Route::post('/frontend/update-cart-quantity', [HomeController::class, 'updateQty'])->name('updateCartqty');
Route::get('/frontend/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/frontend/checkout', [HomeController::class, 'checkout'])->name('checkout');

Route::post('/frontend/save/order', [OrderController::class, 'index'])->name('saveOrder');
Route::post('/online_payment_success/{id}', [OrderController::class, 'onlinePaymentSuccess'])->name('online_payment_success');

Route::post('/frontend/customer-register', [CustomerAuthController::class, 'registration'])->name('customer.register');
Route::post('/frontend/customer-login', [CustomerAuthController::class, 'login'])->name('customer.login');

Route::middleware(['auth:customer'])->group(function () {
    // Your authenticated customer routes go here
    Route::get('/frontend/customer-profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
    Route::patch('/frontend/customer-profile-edit', [CustomerController::class, 'customerProfileEdit'])->name('cedit.profile');
    Route::get('/frontend/customer-logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::post('/frontend/customer-make-own-pokebowl', [CustomerController::class, 'makeOwnPokeBowl'])->name('make.pokebowl');
    Route::patch('/frontend/customer-update-own-pokebowl/{id}', [CustomerController::class, 'updateOwnPokeBowl'])->name('update.pokebowl');
    Route::get('/frontend/customer-order-details/{id}', [OrderController::class, 'orderDetails'])->name('customer.order.details');
    // Add more authenticated routes as needed

    //Customer Profile Routes

    // Rotue::get('profile')
});


//Lakeshore Bakery Website Route
Route::get('/lakeshorebakery', [LbHomeController::class, 'index'])->name('lakeshore_bakery');
Route::get('product-details/{id}', [LbHomeController::class, 'productDetails'])->name('lbproduct.details');
Route::get('/lakeshorebakery/about-us', function () {
    return view('lakeshore_bakery.about');
});
Route::get('/lakeshorebakery/contact-us', function () {
    return view('lakeshore_bakery.contact');
});
