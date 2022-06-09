<?php

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




Route::get('/login', function () {
    return redirect('login');
});


Auth::routes();

Route::get('/', 'HomeController@host');
Route::post('contact-us', 'HomeController@contact_us')->name('contact-us');

Route::get('artist-cancellation-policy','HomeController@ArtistCancellationPolicy');
Route::get('cancellation-policy','HomeController@cancellationPolicy');
Route::get('privacy-policy','HomeController@PrivacyPolicy');
Route::get('refund-policy','HomeController@RefundPolicy');
Route::get('about-us','HomeController@About');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => ['Super-Admin']], function () {
Route::get('/home', 'HomeController@index')->name('home');
  
    
    // Route::get('/', 'HomeController@index');
    Route::resource('roles', 'Admin\RolesController');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::resource('users', 'Admin\UsersController');
    Route::get('provider', 'Admin\UsersController@provider');
    Route::get('TotalActiveJobs', 'Admin\UsersController@TotalActiveJobs');
    Route::get('posts', 'Admin\UsersController@notGetOffer');
    Route::get('user-status', 'Admin\UsersController@updateUserStatus');
    Route::get('report-management', 'Admin\UsersController@ReportManagement');
    Route::resource('pages', 'Admin\PagesController');
    Route::resource('activitylogs', 'Admin\ActivityLogsController')->only([
        'index', 'show', 'destroy'
    ]);
    Route::resource('settings', 'Admin\SettingsController');
//    Admin Routes
    Route::get('main-category', 'Admin\Main_categoriesController@index');
    Route::get('deleteCategory/{id}', 'Admin\Main_categoriesController@deleteCategory');
    Route::get('sub-category', 'Admin\Main_categoriesController@SubCategories');
    Route::get('deleteSubcategory/{id}', 'Admin\Main_categoriesController@deleteSubcategory');
    Route::post('add-main-category', 'Admin\Main_categoriesController@store')->name('add-main-category');
    
    Route::post('edit-subcategories', 'Admin\Main_categoriesController@EditSubcategories');
    
    Route::post('edit-categories', 'Admin\Main_categoriesController@EditCategories');
    
    Route::post('add-sub-category', 'Admin\Main_categoriesController@storeSubcategory')->name('add-sub-category');

    Route::get('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
    Route::resource('vehicle-damage', 'Admin\VehicleDamageController');
    
    Route::get('blogs', 'Admin\ArtistController@blogs')->name('view.blog'); 
    Route::get('create-blog', 'Admin\ArtistController@create_blog');
    Route::post('add-blog', 'Admin\ArtistController@add_blog');
    Route::get('view-blog/{id}', 'Admin\ArtistController@view_blog');
    
    Route::get('edit-blog/{id}', 'Admin\ArtistController@edit_blog');
    Route::post('edit-blog-details', 'Admin\ArtistController@edit_blog_details');
    Route::get('delete-blog', 'Admin\ArtistController@delete_blog');
    Route::resource('admin/metas', 'Admin\MetasController');
    Route::get('artist-management','Admin\ArtistController@artists');
    Route::get('artist-management-detail/{id}','Admin\ArtistController@artist_detail');
    Route::get('user-management','Admin\UsersController@user');
    Route::get('user-detail/{id}','Admin\UsersController@user_detail');
    Route::post('change_mobile_no','Admin\UsersController@change_mobile_no');
    
    
}); 

  
Route::get('admin/privacy_policy', 'Admin\MetasController@privacy_policy');  
Route::get('admin/terms_and_condition', 'Admin\MetasController@terms_and_condition');

Route::resource('admin/messag-messages', 'Admin\\MessagMessagesController');

Route::resource('admin/conversations', 'Admin\\ConversationsController');
Route::resource('admin/chats', 'Admin\\ChatsController');   


Route::resource('payments', 'PaymentsController');

Route::resource('main_categories', 'Admin\Main_categoriesController');
Route::resource('sub-categories', 'Sub-categoriesController');
Route::resource('sub_categories', 'Sub_categoriesController');
Route::resource('admin/subcategories', 'Admin\SubcategoriesController');
Route::resource('admin/ratings', 'Admin\RatingsController');


// Route::get('admin/report-management','Admin\UsersController@report');
Route::get('admin/setting','Admin\UsersController@setting');

Route::POST('change-image','Admin\UsersController@changeImage')->name('change-image');

Route::POST('admin/change-password','Admin\UsersController@changePassword')->name('admin/change-password');
Route::get('admin/payment-transaction','Admin\PaymentController@payment');
Route::get('admin/payment-detail','Admin\PaymentController@payment_detail');
Route::get('admin/deletImage/{id}', 'Admin\UsersController@deletImage');


