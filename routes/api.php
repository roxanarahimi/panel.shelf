<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::middleware('auth:admin')->group(function () {
//    Route::get('/panel/admin','currentAdmin');
//    Route::post('/panel/admin/logout','adminLogout');
//});


use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

//all
Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    Route::prefix('panel')->group(function () {
        Route::get('/user', 'currentUser');

        Route::get('/user/logout/{user}', 'logout');

        Route::post('/admin/login', 'login');
        Route::post('/admin/register', 'register');
        Route::post('/check/admin/token', 'updateLastActivity');

        Route::post('/user/login', 'login');
        Route::post('/user/register', 'register');
        Route::post('/check/user/token', 'updateLastActivity');
    });


    Route::post('/user/login', 'login');
    Route::post('/user/register', 'register');
    Route::post('/check/user/token', 'updateLastActivity');
    Route::get('/user/logout/{user}', 'logout');
    Route::post('/user/logout', 'logout');

    Route::post('/otp/mobile', 'getOtp');
    Route::post('/mobile/login', 'loginMobile');
});

Route::controller(App\Http\Controllers\UserController::class)->group(function () {

    Route::post('/update/user', 'updateProfile');
    Route::get('/user', 'indexUsers');
    Route::get('/admins', 'indexAdmins');
    Route::get('/user/{user}', 'show');
    Route::post('/user', 'store');
    Route::post('/user/{user}', 'update');
    Route::get('/delete/user/{user}', 'destroy');


    Route::get('/get/otp/{mobile}', 'getOtpNoRedis');//getOtp
    Route::post('/verify/otp', 'verifyOtp');
    Route::get('/login/otp/{user}', 'loginOtp');

    Route::get('/otp1', 'otp1');
    Route::get('/otp2', 'otp2');


    Route::prefix('panel')->group(function () {

        Route::post('/update/user', 'updateProfile');
        Route::get('/user', 'indexUsers');
        Route::get('/user/{user}', 'show');
        Route::post('/user', 'store');
        Route::post('/user/{user}', 'update');
        Route::post('/delete/user', 'destroy');

        Route::post('/update/admin', 'updateProfile');
        Route::get('/admin', 'indexAdmins');
        Route::get('/admin/{admin}', 'show');
        Route::post('/admin', 'store');
        Route::post('/admin/{admin}', 'update');
        Route::get('/delete/admin/{admin}', 'destroy');
    });
});

Route::controller(App\Http\Controllers\ImageController::class)->group(function () {

    Route::prefix('panel')->group(function () {
//        Route::get('/icon', 'index');
//        Route::get('/icon/{icon}', 'show');
//        Route::post('/icon', 'store');
        Route::post('/icon', 'makeIconPack');
        Route::post('/upload/editor/image', 'uploadEditorImage');
//        Route::post('/panel/upload/editor/image',[\App\Http\Controllers\ImageController::class, 'uploadEditorImage']);

    });
});
Route::controller(App\Http\Controllers\BrandController::class)->group(function () {

    Route::get('/brand', 'indexSite');
    Route::get('/brand/{brand}', 'show');
    Route::get('/latest/brand', 'latestSite');
    Route::get('/article/by/brand/{id}', 'byCat');

    Route::prefix('panel')->group(function () {

        Route::get('/brand', 'index');
        Route::get('/brand/{brand}', 'show');
        Route::post('/brand', 'store');
        Route::post('/brand/{brand}', 'update');
        Route::get('/delete/brand/{id}', 'destroy');

        Route::get('/active/brand/{brand}', 'activeToggle');
        Route::get('/latest/brand', 'latest');
    });
});


Route::controller(App\Http\Controllers\SkuController::class)->group(function () {

    Route::get('/sku', 'indexSite');
    Route::get('/sku/{sku}', 'show');
    Route::get('/latest/sku', 'latestSite');
    Route::get('/sizes/sku/{id}/{color}', 'getSizes');
    Route::get('/sku/by/category/{id}', 'byCat');


    Route::prefix('panel')->group(function () {

        Route::get('/sku', 'index');
        Route::get('/sku/{sku}', 'show');
        Route::post('/sku', 'store');
        Route::post('/sku/{sku}', 'update');
        Route::post('/sort/sku/{sku}', 'sort');
        Route::get('/delete/sku/{sku}', 'destroy');

        Route::get('/active/sku/{sku}', 'activeToggle');
        Route::get('/latest/sku', 'latest');

        Route::post('/images/reorder/sku/{sku}', 'updateOrder');
        Route::get('/sku/by/category/{id}', 'byCatPanel');

    });
});

Route::controller(App\Http\Controllers\SkuCategoryController::class)->group(function () {

    Route::get('/category/sku', 'indexSite');
    Route::get('/category/sku/{skuCategory}', 'show');

    Route::prefix('panel')->group(function () {
        Route::get('/category/sku', 'index');
        Route::get('/category/sku/{skuCategory}', 'show');
        Route::post('/category/sku', 'store');
        Route::post('/category/sku/{skuCategory}', 'update');
        Route::post('/delete/category/sku', 'destroy');
        Route::get('/active/category/sku/{skuCategory}', 'activeToggle');
    });
});


Route::controller(App\Http\Controllers\ProductController::class)->group(function () {

    Route::get('/product', 'indexSite');
    Route::get('/product/{product}', 'show');
    Route::get('/latest/product', 'latestSite');
    Route::get('/stock/product', 'stockSite');
    Route::get('/sizes/product/{id}/{color}', 'getSizes');
    Route::get('/product/by/category/{id}', 'byCat');


    Route::prefix('panel')->group(function () {

        Route::get('/product', 'index');
        Route::get('/product/{product}', 'show');
        Route::post('/product', 'store');
        Route::post('/product/{product}', 'update');
        Route::post('/sort/product/{product}', 'sort');
        Route::get('/delete/product/{product}', 'destroy');

        Route::get('/active/product/{product}', 'activeToggle');
        Route::get('/latest/product', 'latest');

        Route::post('/images/reorder/product/{product}', 'updateOrder');
        Route::get('/product/by/category/{id}', 'byCatPanel');

    });
});

Route::controller(App\Http\Controllers\ProductCategoryController::class)->group(function () {

    Route::get('/category/product', 'indexSite');
    Route::get('/category/product/{productCategory}', 'show');

    Route::prefix('panel')->group(function () {
        Route::get('/category/product', 'index');
        Route::get('/category/product/{productCategory}', 'show');
        Route::post('/category/product', 'store');
        Route::post('/category/product/{productCategory}', 'update');
        Route::post('/delete/category/product', 'destroy');
        Route::get('/active/category/product/{productCategory}', 'activeToggle');
    });
});


Route::controller(App\Http\Controllers\ProvinceController::class)->group(function () {

    Route::get('/province', 'indexSite');
    Route::get('/province/{province}', 'show');
    Route::get('/latest/province', 'latestSite');
    Route::get('/article/by/province/{id}', 'byCat');

    Route::prefix('panel')->group(function () {

        Route::get('/province', 'index');
        Route::get('/province/{province}', 'show');
        Route::post('/province', 'store');
        Route::post('/province/{province}', 'update');
        Route::get('/delete/province/{id}', 'destroy');

        Route::get('/active/province/{province}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\CityController::class)->group(function () {

    Route::get('/city', 'indexSite');
    Route::get('/city/{brand}', 'show');
    Route::get('/latest/city', 'latestSite');
    Route::get('/city/by/province/{id}', 'byProvince');

    Route::prefix('panel')->group(function () {

        Route::get('/city', 'index');
        Route::get('/city/{city}', 'show');
        Route::post('/city', 'store');
        Route::post('/city/{city}', 'update');
        Route::get('/delete/city/{id}', 'destroy');

        Route::get('/active/city/{city}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\RegionController::class)->group(function () {

    Route::get('/region', 'indexSite');
    Route::get('/region/{region}', 'show');
    Route::get('/latest/region', 'latestSite');
    Route::get('/region/by/city/{id}', 'byCity');

    Route::prefix('panel')->group(function () {
        Route::get('/region', 'index');
        Route::get('/region/{region}', 'show');
        Route::post('/region', 'store');
        Route::post('/region/{region}', 'update');
        Route::get('/delete/region/{id}', 'destroy');

        Route::get('/active/region/{region}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\SectorController::class)->group(function () {

    Route::get('/sector', 'indexSite');
    Route::get('/sector/{sector}', 'show');
    Route::get('/latest/sector', 'latestSite');
    Route::get('/sector/by/region/{id}', 'byRegion');

    Route::prefix('panel')->group(function () {

        Route::get('/sector', 'index');
        Route::get('/sector/{sector}', 'show');
        Route::post('/sector', 'store');
        Route::post('/sector/{sector}', 'update');
        Route::get('/delete/sector/{id}', 'destroy');

        Route::get('/active/sector/{sector}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\CustomerController::class)->group(function () {

    Route::get('/customer', 'indexSite');
    Route::get('/customer/{customer}', 'show');
    Route::get('/latest/customer', 'latestSite');
    Route::get('/customer/by/region/{id}', 'byRegion');
    Route::get('/customer/by/code/{code}', 'byCode');

    Route::prefix('panel')->group(function () {

        Route::get('/customer', 'index');
        Route::get('/customer/{customer}', 'show');
        Route::post('/customer', 'store');
        Route::post('/customer/{customer}', 'update');
        Route::get('/delete/customer/{id}', 'destroy');

        Route::get('/active/customer/{customer}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\CustomerGradeScoreController::class)->group(function () {

    Route::get('/score', 'indexSite');
    Route::get('/score/{customer_id}', 'show');
    Route::post('/score', 'update');

    Route::prefix('panel')->group(function () {

    });
});

Route::controller(App\Http\Controllers\VisitorController::class)->group(function () {

    Route::get('/visitor', 'indexSite');
    Route::get('/visitor/{visitor}', 'show');
    Route::get('/latest/visitor', 'latestSite');
    Route::get('/article/by/visitor/{id}', 'byCat');
    Route::post('/visitor/login', 'login');

    Route::prefix('panel')->group(function () {

        Route::get('/visitor', 'index');
        Route::get('/visitor/{visitor}', 'show');
        Route::post('/visitor', 'store');
        Route::post('/visitor/{visitor}', 'update');
        Route::get('/delete/visitor/{id}', 'destroy');

        Route::get('/active/visitor/{visitor}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\FormController::class)->group(function () {

    Route::get('/form', 'indexSite');
    Route::get('/form/{form}', 'show');

    Route::post('/form', 'store');
    Route::post('/form/{form}', 'update');


    Route::prefix('panel')->group(function () {

        Route::get('/form', 'index');
        Route::get('/form/{form}', 'show');

        Route::get('/delete/form/{id}', 'destroy');
    });
});

//other API'S
Route::get('/category/product', [\App\Http\Controllers\ProductCategoryController::class, 'indexSite']);
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search']);
Route::get('/fix', [\App\Http\Controllers\ProductController::class, 'fix']);

