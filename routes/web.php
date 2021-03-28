<?php
use App\Page;
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
// Start Language
// Route::get('language/{locale}', function ($locale) {
//     Session::put('locale', $locale);
//     return redirect()->back();
// });
// End Language
  
Route::group(['middleware'=>['locale']],function(){
    // dd(App::getLocale());
    Route::get('language/{code}', 'PageController@language');

});
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index',
    'middleware' => 'locale'
]);

Route::post('search',[
    'as'=>'search',
    'uses' =>'SearchController@index',
    'middleware' => 'locale'
]);

Route::post('modal_video', [
    'as' => 'video.modal',
    'uses' => 'VideoController@getVideo'
]);

// Route::get('/register', [
//     'as' => 'register',
//     'uses' => 'RegistrationController@create'
// ]);

Route::get('/loadAjax', 'NewsletterController@subcribe')->name('loadajax.subcribe');

Route::get('tu-van-thiet-ke-nha',[
    'as' => 'consultant',
    'uses' => 'PageController@consultant'
]);
Route::post('tu-van-thiet-ke-nha',[
    'as' => 'consultantpost',
    'uses' => 'PageController@consultantForm'
]);
Route::get('newsletter',[
    'as' => 'newsletter',
    'uses' => 'NewsletterController@setNewsletter'
]);

Route::get('san-pham/tim-kiem/{keyword}',[
    'as' => 'timsanpham',
    'uses' => 'ProductController@searchKeyword'
]);

Route::post('/tim-kiem/san-pham', 'ProductController@search');

// Route::get('dang-ky',[
//     'as' => 'register',
//     'uses' => 'PageController@register'
// ]);
Route::get('login',[
    'as' => 'f.login',
    'uses' => 'PageController@login'
]);
// Route::get('thong-tin-tai-khoan',[
//     'as' => 'account',
//     'uses' => 'PageController@account'
// ]);
// Route::post('thong-tin-tai-khoan',[
//     'as' => 'register_account',
//     'uses' => 'ProfileController@edit'
// ]);

Route::post('tinh-thanh',[
    'as' => 'province',
    'uses' => 'ProfileController@getDistrict'
]);
Route::post('dang-ky',[
    'as' => 'register_account',
    'uses' => 'ProfileController@register'
]);
Route::get('logout',[
    'as' => 'f.logout',
    'uses' => 'ProfileController@logout'
]);
Route::get('thong-bao/{order_id}',[
    'as' => 'notify',
    'uses' => 'PageController@notify'
]);
Route::post('/register', [
    'as' => 'store',
    'uses' => 'RegistrationController@store'
]);
Route::post('/login', [
    'as' => 'login',
    'uses' => 'RegistrationController@login'
]);
Route::get('/logout', ['as' => 'logout','uses' => 'RegistrationController@logout']);
Route::get('/user/get-district/{id}', 'RegistrationController@getDistrict');
Route::get('/user/get-ward/{id}', 'RegistrationController@getWard');
Route::get('san-pham/gio-hang',['as' => 'giohang', 'uses' => 'CartController@index']);
Route::get('san-pham/thanh-toan',[
    'as'=>'dathang',
    'uses'=>'CartController@getCheckout'
]);
Route::get('san-pham/dat-hang-thanh-cong',[
    'as' => 'dathangthanhcong',
    'uses' => 'CartController@orderSuccess'
]);
Route::post('/san-pham/thanh-toan',[
    'as' => 'thanhtoan',
    'uses' => 'CartController@setPayment'
]);
Route::get('/banner', 'HomeController@getSource');
Route::get('add-to-cart/{id}', [
    'as' => 'themgiohang',
    'uses' => 'ProductController@addToCart'
]);
Route::post('/add-cart-detail/{id}', [
    'as' => 'addcartdetail',
    'uses' => 'ProductController@addToCartDetail'
]);
// Route::get('/add-cart-detail', [
    // 'as' => 'addcartdetail',
    // 'uses' => 'ProductController@addToCartDetail'
// ]);
Route::get('gio-hang/del-cart/{id}',[
    'as'=>'xoagiohang',
    'uses'=>'ProductController@getDelItemCart'
]);
Route::get('update-cart/{id}',[
    'as'=>'capnhatgiohang',
    'uses'=>'ProductController@updateItemCart'
]);
Route::post('updatecart/',[ 'as'=>'updatecart', 'uses'=>'ProductController@updateCartItem']);
Route::post('checkcoupon',[ 'as'=>'checkcoupon', 'uses'=>'CouponController@show']);
Route::get('quickview/{id}', [
    'as' => 'quickview',
    'uses' => 'HomeController@quickview'
]);

Route::post('filter-price',[
    'as' => 'filter_price',
    'uses' => 'ProductController@filterPrice'
]);

Route::get('/{slug}', [
    'as' => 'page',
    'uses' => 'PageController@index',
    'middleware' => 'locale'
]);



Route::post('contact',[
    'as' => 'contact.add',
    'uses' => 'ContactController@create'
]);
// Start Language
// Route::get('language/{locale}', function ($locale) {
    // Session::put('locale', $locale);
    // return redirect()->back();
// });
// End Language
// Start Login
Route::get('/admin/login', [
    'as' => 'login',
    'uses' => 'Admin\LoginController@index'
]);
Route::get('/admin', [
    'as' => 'logins',
    'uses' => 'Admin\LoginController@index'
]);
Route::post('admin/login', [
    'as' => 'dologin',
    'uses' => 'Admin\LoginController@doLogin'
]);

Route::get('admin/logout', [
    'as' => 'logout',
    'uses' => 'Admin\LoginController@logout'
]);

Route::get('admin/remember', [
    'as' => 'remember',
    'uses' => 'Admin\LoginController@remember'
]);
Route::post('admin/remember', [
    'as' => 'doremember',
    'uses' => 'LoginController@doRemember'
]);
// End Login



// Start dashboard
Route::get('admin/dashboard', [
    'as' => 'dashboard',
    'middleware' => 'auth',
    'uses' => 'Admin\DashboardController@index'
]);
// End dashboard




Route::group(['prefix' => 'admin'], function() {
    // Start consultant
    Route::get('/consultant/list', [
        'as' => 'listcourse',
        'middleware' => 'auth',
        'uses' => 'Admin\ConsultantController@index'
    ]);
    Route::get('/consultant/delete/{id}', [
        'as' => 'delcourse',
        'middleware' => 'auth',
        'uses' => 'Admin\ConsultantController@destroy'
    ]);
    Route::get('/consultant/view/{id}', [
        'as' => 'viewcourse',
        'middleware' => 'auth',
        'uses' => 'Admin\ConsultantController@show'
    ]);
    // End consultant
    // Start contact
    Route::get('/contact/list', ['as' => 'listcontact', 'uses' => 'Admin\ContactController@index']);
    Route::get('/contact/delete/{id}', ['as' => 'delcontact', 'uses' => 'Admin\ContactController@destroy']);
    Route::get('/contact/view/{id}', ['as' => 'viewcontact', 'uses' => 'Admin\ContactController@show']);
    Route::post('/contact/update/{id}', ['as' => 'updatecontact', 'uses' => 'Admin\ContactController@update']);
    // End contact
});




// Start Post

Route::get('admin/post/list', [
    'as' => 'listpost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@index'
]);
Route::get('admin/post/list/{id_cate}', [
    'as' => 'listcatepost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@listCatePost'
]);

Route::post('admin/post/list?id_cate={id_cate}&keyword={keyword}', [
    'as' => 'searchpostcate',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@searchPostCate'
]);

Route::get('admin/post/view/{id}', [
    'as' => 'viewpost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@show'
]);

Route::post('admin/post/edit/{id}', [
    'as' => 'editpost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@edit'
]);
Route::get('admin/post/add', [
    'as' => 'addpost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@add'
]);
Route::post('admin/post/doAdd', [
    'as' => 'doaddpost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@doAdd'
]);
Route::get('admin/post/delete/{id}', [
    'as' => 'deletepost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@destroy'
]);
Route::post('admin/post/list', [
    'as' => 'searchpostcate',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@searchPostCate'
]);
Route::get('admin/post/listcategorypost', [
    'as' => 'listcategorypost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@categoryPost'
]);
Route::get('admin/post/viewcategorypost/{id}', [
    'as' => 'viewcategorypost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@viewCategoryPost'
]);
Route::post('admin/post/editcategorypost/{id}', [
    'as' => 'editcategorypost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@editCategoryPost'
]);
Route::get('admin/post/destroycatepost/{id}', [
    'as' => 'destroycatepost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@destroyCatePost'
]);
Route::get('admin/post/addcategorypost', [
    'as' => 'addcategorypost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@addCategoryPost'
]);
Route::post('admin/post/doaddcatepost', [
    'as' => 'doaddcatepost',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@doAddCatePost'
]);

Route::get('admin/post/listcollectionpost', [
    'as' => 'listcollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@index'
]);
Route::get('admin/post/viewcollectionpost/{id}', [
    'as' => 'viewcollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@viewCollectionPost'
]);
Route::post('admin/post/editcollectionpost/{id}', [
    'as' => 'editcollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@editCollectionPost'
]);
Route::get('admin/post/addcollectionpost', [
    'as' => 'addcollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@addCollectionPost'
]);
Route::post('admin/post/doaddcollectionpost', [
    'as' => 'doaddcollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@doAddCollectionPost'
]);
Route::get('admin/post/destroycollectionpost/{id}', [
    'as' => 'destroycollectionpost',
    'middleware' => 'auth',
    'uses' => 'Admin\CollectionController@destroyCollectionPost'
]);

Route::post('admin/post/image/edit/{id}', [
    'as' => 'delimage',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@delImage'
]);

// process work
Route::get('admin/post/work',[
    'as' => 'post_work_list',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@work'
]);
Route::get('admin/post/workadd',[
    'as' => 'post_work_add',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@workAdd'
]);
Route::post('admin/post/workadd',[
    'as' => 'post_work_create',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@workCreate'
]);
Route::get('admin/post/work/{id_work}',[
    'as' => 'post_work_show',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@workShow'
]);
Route::post('admin/post/work/{id_work}',[
    'as' => 'post_work_edit',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@workEdit'
]);
Route::get('admin/post/workdelete/{id_work}',[
    'as' => 'post_work_delete',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@destroyWork'
]);
// end process work

// process project type
Route::get('admin/post/project_type',[
    'as' => 'post_projecttype_list',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@projecttype'
]);
Route::get('admin/post/project_type_add',[
    'as' => 'post_projecttype_add',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@projecttypeAdd'
]);
Route::post('admin/post/project_type_add',[
    'as' => 'post_projecttype_create',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@projecttypeCreate'
]);
Route::get('admin/post/project_type/{id_project_type}',[
    'as' => 'post_projecttype_show',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@projecttypeShow'
]);
Route::post('admin/post/project_type/{id_project_type}',[
    'as' => 'post_projecttype_edit',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@projecttypeEdit'
]);
Route::get('admin/post/project_type_delete/{id_project_type}',[
    'as' => 'post_projecttype_delete',
    'middleware' => 'auth',
    'uses' => 'Admin\PostController@destroyProjecttype'
]);
// end process project type

// End Post
//Start Page

Route::get('admin/page/list', [
    'as' => 'listpage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@index'
]);

Route::get('admin/page/view/{id}', [
    'as' => 'viewpage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@show'
]);

Route::get('admin/page/add', [
    'as' => 'addpage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@add'
]);

Route::post('admin/page/doAdd', [
    'as' => 'doaddpage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@doAdd'
]);

Route::get('admin/page/delete/{id}', [
    'as' => 'deletepage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@destroy'
]);

Route::post('admin/page/edit/{id}', [
    'as' => 'editpage',
    'middleware' => 'auth',
    'uses' => 'Admin\PageController@edit'
]);


// End Page
// Start banner
Route::get('admin/banner/list', [
    'as' => 'listbanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@index'
]);
Route::get('admin/banner/destroy/{id}', [
    'as' => 'delbanner',
    'uses' => 'Admin\BannerController@destroy'
]);
Route::get('admin/banner/view/{id}', [
    'as' => 'viewbanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@show'
]);
Route::post('admin/banner/edit/{id}', [
    'as' => 'editbanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@edit'
]);

Route::post('admin/banner/update/{id}', [
    'as' => 'updatebanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@update'
]);

Route::get('admin/banner/add', [
    'as' => 'addbanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@add'
]);
Route::post('admin/banner/create', [
    'as' => 'createbanner',
    'middleware' => 'auth',
    'uses' => 'Admin\BannerController@create'
]);

// End banner
// Start section
Route::get('admin/section/list', [
    'as' => 'listsection',
    'middleware' => 'auth',
    'uses' => 'Admin\SectionController@index'
]);
Route::get('admin/section/view/{id}', [
    'as' => 'editsection',
    'middleware' => 'auth',
    'uses' => 'Admin\SectionController@show'
]);
Route::post('admin/banner/edit/{id}', [
    'as' => 'editsection',
    'middleware' => 'auth',
    'uses' => 'Admin\SectionController@edit'
]);
// End section
// Start Newsletter
Route::get('admin/newsletter/list', [
    'as' => 'listnewsletter',
    'middleware' => 'auth',
    'uses' => 'Admin\NewsletterController@index'
]);
Route::get('admin/newsletter/delete/{id}', [
    'as' => 'delnewsletter',
    'middleware' => 'auth',
    'uses' => 'Admin\NewsletterController@destroy'
]);
Route::get('admin/newsletter/view/{id}', [
    'as' => 'viewnewsletter',
    'middleware' => 'auth',
    'uses' => 'Admin\NewsletterController@show'
]);

Route::post('admin/newsletter/update/{id}', [
    'as' => 'updatenewsletter',
    'middleware' => 'auth',
    'uses' => 'Admin\NewsletterController@update'
]);
// End Newsletter
// Start Screenshot
Route::get('admin/screenshot/list', [
    'as' => 'listscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@index'
]);
Route::get('admin/screenshot/delete/{id}', [
    'as' => 'delscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@destroy'
]);
Route::get('admin/screenshot/view/{id}', [
    'as' => 'viewscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@show'
]);
Route::post('admin/screenshot/edit/{id}', [
    'as' => 'editscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@edit'
]);
Route::get('admin/screenshot/add', [
    'as' => 'addscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@add'
]);
Route::post('admin/screenshot/doAdd/{id}', [
    'as' => 'doaddscreenshot',
    'middleware' => 'auth',
    'uses' => 'Admin\ScreenshotController@doAdd'
]);
// End Screenshot

// Start coupon
Route::get('admin/coupon/list', [
    'as' => 'listcoupon',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@index'
]);
Route::get('admin/coupon/add', [
    'as' => 'addcoupon',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@add'
]);
Route::post('admin/coupon/create', [
    'as' => 'createcoupon',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@create'
]);
Route::post('admin/coupon/productcategory', [
    'as' => 'coupon.productcategory',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@getProductCategory'
]);
Route::get('admin/coupon/view/{id}', [
    'as' => 'coupon.show',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@show'
]);
Route::post('admin/coupon/view/{id}', [
    'as' => 'coupon.edit',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@edit'
]);
Route::get('admin/coupon/delete/{id}', [
    'as' => 'coupon.delete',
    'middleware' => 'auth',
    'uses' => 'Admin\CouponController@destroy'
]);
// End coupon


// Start Customer
Route::get('admin/customer/list', [
    'as' => 'listcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@index'
]);


// Route::get('admin/customer/list?type={customer_type}', [
//     'as' => 'customer.filter.type',
//     'middleware' => 'auth',
//     'uses' => 'Admin\CustomerController@customerType'
// ]);
Route::get('admin/customer/delete/{id}', [
    'as' => 'delcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@destroy'
]);
Route::get('admin/customer/view/{id}', [
    'as' => 'viewcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@show'
]);
Route::post('admin/customer/edit/{id}', [
    'as' => 'editcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@edit'
]);
Route::get('admin/customer/add', [
    'as' => 'addcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@add'
]);
Route::post('admin/customer/doAdd', [
    'as' => 'doaddcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@doAdd'
]);
Route::get('admin/customer/import', [
    'as' => 'importcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@import'
]);
Route::post('admin/customer/doimport', [
    'as' => 'doimportcustomer',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@doImport'
]);
Route::post('admin/customer/quicklyadd',[
    'as' => 'customer.quicklyadd',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@quicklyAdd'
]);
Route::post('admin/customer/quicklylist',[
    'as' => 'customer.quicklylist',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@getAllCustomer'
]);
Route::post('admin/customer/phonenumber',[
    'as' => 'customer.phonenumber',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@getPhoneNumber'
]);
Route::get('admin/customer/export',[
    'as' => 'customer.export',
    'middleware' => 'auth',
    'uses' => 'Admin\CustomerController@export'
]);
Route::post('admin/customer/quan-huyen',[
    'as' => 'customer.district',
    'uses' => 'Admin\CustomerController@getDistrict'
]);

// End Customer

// Start Video
Route::get('admin/video/list', [
    'as' => 'video.list',
    'middleware' => 'auth',
    'uses' => 'Admin\VideoController@index'
]);
Route::get('admin/video/view/{id}', [
    'as' => 'video.view',
    'middleware' => 'auth',
    'uses' => 'Admin\VideoController@show'
]);
Route::post('admin/video/edit/{id}', [
    'as' => 'video.edit',
    'middleware' => 'auth',
    'uses' => 'Admin\VideoController@edit'
]);
Route::get('admin/video/add', [
    'as' => 'video.add',
    'middleware' => 'auth',
    'uses' => 'Admin\VideoController@add'
]);
Route::post('admin/video/create', [
    'as' => 'video.create',
    'middleware' => 'auth',
    'uses' => 'Admin\VideoController@create'
]);
// End Video

// Start setting
Route::get('admin/setting/mail', [
    'as' => 'mail',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@configMail'
]);
Route::get('admin/setting/advertising', [
    'as' => 'advertising',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setAds'
]);
Route::post('admin/setting/doupdate', [
    'as' => 'doupdate',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setAdvertising'
]);
Route::post('admin/setting/setMail', [
    'as' => 'setmail',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setMail'
]);
Route::get('admin/setting/frontend', [
    'as' => 'frontend',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@frontend'
]);
Route::post('admin/setting/social', [
    'as' => '',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setSocial'
]);
Route::post('admin/setting/currency', [
    'as' => '',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setCurrency'
]);

Route::post('admin/setting/header', [
    'as' => '',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setHeader'
]);
Route::post('admin/setting/footer', [
    'as' => '',
    'middleware' => 'auth',
    'uses' => 'Admin\SettingController@setFooter'
]);
// End setting
// Start User
Route::get('admin/user/profile', [
    'as' => 'userprofile',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@setProfile'
]);
Route::get('admin/user/list', [
    'as' => 'userlist',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@index'
]);
Route::get('admin/user/view/{id}', [
    'as' => 'userview',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@view'
]);
Route::post('admin/user/edit/{id}', [
    'as' => 'useredit',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@edit'
]);
Route::get('admin/user/add', [
    'as' => 'useradd',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@add'
]);
Route::post('admin/user/create', [
    'as' => 'usercreate',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@create'
]);
Route::get('admin/user/delete/{id}', [
    'as' => 'userdelete',
    'middleware' => 'auth',
    'uses' => 'Admin\UserController@destroy'
]);
// End User
// Start Menu
Route::get('admin/menu/list', [
    'as' => 'listmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@index'
]);
Route::get('admin/menu/catemenu/{id_catemenu}', [
    'as' => 'catemenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@showCate'
]);
Route::get('admin/menu/detailmenu/{id}', [
    'as' => 'detailmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@showMenu'
]);
Route::post('admin/menu/updatelinhvuc/{id}', [
    'as' => 'detailmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@setMenu'
]);
Route::get('admin/menu/delete/{id}', [
    'as' => 'deletemenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@destroy'
]);
Route::get('admin/menu/deletecatemenu/{id}', [
    'as' => 'deletecatemenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@destroyCateMenu'
]);
Route::get('admin/menu/add', [
    'as' => 'addmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@create'
]);
Route::post('admin/menu/doAdd', [
    'as' => 'doaddmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@doAddMenu'
]);
Route::post('admin/menu/detailmenu/{id}',[
    'as' => 'parentmenu',
    'middleware' => 'auth',
    'uses' => 'Admin\MenuController@getParentMenu'
]);
// End Menu

// Start File Manager
Route::get('admin/filemanage/filemanager', [
    'as' => 'filemanager',
    'middleware' => 'auth',
    'uses' => 'Admin\FileController@index'
]);
// End File Manager
//Start Gallery

Route::get('admin/gallery/list', [
    'as' => 'listgallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@index'
]);

Route::get('admin/gallery/view/{id}', [
    'as' => 'viewgallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@show'
]);

Route::get('admin/gallery/add', [
    'as' => 'addgallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@add'
]);

Route::post('admin/gallery/doAdd', [
    'as' => 'doaddgallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@doAdd'
]);

Route::get('admin/gallery/delete/{id}', [
    'as' => 'deletegallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@destroy'
]);

Route::post('admin/gallery/edit/{id}', [
    'as' => 'editgallery',
    'middleware' => 'auth',
    'uses' => 'Admin\GalleryController@edit'
]);


// End Gallery

/* Start Product */

Route::get('admin/product/list', [
    'as' => 'listproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@index'
]);
Route::post('admin/product/list', [
    'as' => 'listproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@index'
]);
Route::get('admin/product/view/{id}', [
    'as' => 'viewproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@show'
]);
Route::post('admin/product/edit/{id}', [
    'as' => 'editproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@edit'
]);
Route::get('admin/product/add', [
    'as' => 'addproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@create'
]);
Route::post('admin/product/add', [
    'as' => 'doaddproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@doAdd'
]);
Route::get('admin/product/delete/all', [
    'as' => 'product.deleteall',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroyProductAll'
]);
Route::get('admin/product/delete/{id}', [
    'as' => 'delproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroy'
]);
Route::get('admin/product/category', [
    'as' => 'cateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@category'
]);

Route::get('admin/product/category/delete/all', [
    'as' => 'product.category.deleteall',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroyProductCategoryAll'
]);
Route::get('admin/product/category/{id}', [
    'as' => 'viewcateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@viewCategory'
]);
Route::post('admin/product/category/{id}', [
    'as' => 'editcateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@editCategory'
]);
Route::get('admin/product/categoryproduct/add', [
    'as' => 'addcateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@addCategory'
]);
Route::post('admin/product/categoryproduct/add', [
    'as' => 'doaddcateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@doAddCategory'
]);
Route::get('admin/product/category/delete/{id}', [
    'as' => 'cateproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroyCategory'
]);
// Route::post('admin/product/category/deleteall',[
//     'as' => 'product.category.deleteall',
//     'middleware' => 'auth',
//     'uses' => 'Admin\ProductController@destroyCategoryAll'
// ]);

Route::get('admin/product/group', [
    'as' => 'grouplist',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@group'
]);
Route::get('admin/product/group/add', [
    'as' => 'addgroupproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@addGroup'
]);
Route::post('admin/product/group/add', [
    'as' => 'doaddgroupproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@doAddGroup'
]);
Route::get('admin/product/group/{id}', [
    'as' => 'viewgroupproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@viewGroup'
]);
Route::post('admin/product/group/{id}', [
    'as' => 'editgroupproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@editGroup'
]);


Route::get('admin/product/group/delete/{id}', [
    'as' => 'groupproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroyGroup'
]);

Route::post('admin/product/search', [
    'as' => 'searchproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@search'
]);
Route::get('admin/product/trademark', [
    'as' => 'trademarkproduct',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@trademark'
]);
Route::get('admin/product/trademark/add', [
    'as' => 'addtrademark',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@addTrademark'
]);
Route::post('admin/product/trademark/add', [
    'as' => 'doaddtrademark',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@doAddTrademark'
]);
Route::get('admin/product/trademark/{id}', [
    'as' => 'viewtrademark',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@viewTrademark'
]);
Route::post('admin/product/trademark/{id}', [
    'as' => 'edittrademark',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@editTrademark'
]);
Route::get('admin/product/trademark/delete/{id}', [
    'as' => 'trademark',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@destroyTrademark'
]);
Route::get('admin/product/optionautocomplete', [
    'as' => 'optionautocomplete',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@optionautocomplete'
]);
Route::post('admin/product/optionautocomplete', [
    'as' => 'optionautocomplete',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@optionautocomplete'
]);
Route::post('admin/product/accessories', [
    'as' => 'accessories',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@addaccessories'
]);
Route::post('admin/product/getaccessories', [
    'as' => 'getaccessories',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@getaccessories'
]);
Route::post('admin/product/editaccessories', [
    'as' => 'editaccessories',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@editaccessories'
]);
Route::post('admin/product/deleteaccessories', [
    'as' => 'deleteaccessories',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@deleteaccessories'
]);
Route::post('admin/product/getgroup', [
    'as' => 'getgroup',
    'middleware' => 'auth',
    'uses' => 'Admin\ProductController@getgroup'
]);
Route::get('admin/product/export',[
    'as' => 'product.export',
        'middleware' => 'auth',
        'uses' => 'Admin\ProductController@export'
]);
Route::get('admin/product/export/{id_type}',[
    'as' => 'product.exportcategory',
        'middleware' => 'auth',
        'uses' => 'Admin\ProductController@exportCategory'
]);
// End Product

/* Start Order */
Route::group(['prefix' => '/admin/order'], function() {
    Route::get('list', [
        'as' => 'orderlist',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@index'
    ]);
    Route::post('list', [
        'as' => 'orderlist',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@index'
    ]);
    Route::get('view/{id}', [
        'as' => 'orderview',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@orderDetail'
    ]);
    Route::post('view/{id}', [
        'as' => 'orderupdate',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@orderUpdate'
    ]);
    Route::get('pdf/{id}', [
        'as' => 'orderpdf',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@orderPrintPDF'
    ]);
    Route::get('excel/{id}', [
        'as' => 'orderexcel',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@orderPrintExcel'
    ]);
    Route::get('add', [
        'as' => 'orderadd',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@addOrder'
    ]);
    Route::post('add', [
        'as' => 'doaddorder',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@doAddOrder'
    ]);
    Route::get('ajaxgetoptionproduct/{id}', [
        'as' => 'ajaxgetoptionproduct',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@ajaxgetoptionproduct'
    ]);
    Route::post('ajaxgetoptionproduct/{id}', [
        'as' => 'ajaxgetoptionproduct',
        'middleware' => 'auth',
        'uses' => 'Admin\OrderController@ajaxgetoptionproduct'
    ]);
    Route::post('quan-huyen',[
        'as' => 'order.district',
        'uses' => 'Admin\OrderController@getDistrict'
    ]);
    Route::get('delete/{id}',[
        'as' => 'order.delete',
        'uses' => 'Admin\OrderController@destroy'
    ]);
});
/* End Order*/
/*attribute option product*/
Route::group(['prefix' => '/admin/product'], function() {
    
    Route::get('/option', [
        'as' => 'optionlist',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@index'
    ]);
    Route::get('/option/add', [
        'as' => 'addoption',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@addOption'
    ]);
    Route::post('/option/add', [
        'as' => 'doaddoption',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@doAddOption'
    ]);
    Route::get('/option/{id}', [
        'as' => 'viewoption',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@viewOption'
    ]);
    Route::post('/option/{id}', [
        'as' => 'editoption',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@editOption'
    ]);
    Route::get('/option/delete/{id}', [
        'as' => 'option',
        'middleware' => 'auth',
        'uses' => 'Admin\OptionController@destroyOption'
    ]);
    

});
// Start Sitemap XML
//Route::get('/aaa', [
//    'as' => 'sitemap',
////    'middleware' => 'auth',
//    'uses' => 'Admin\SitemapController@index'
//]);

// End Sitemap XML