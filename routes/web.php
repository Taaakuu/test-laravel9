<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Route::prefix('product')->group(function () {
    // 商品列表页面
    Route::get('index', [ProductController::class, 'index'])->name('product.index');
    //展示创建商品表单
    Route::get('create', function () {
        return view('product.create');
    });
    // 处理产品创建请求
    Route::post('create', [ProductController::class, 'create'])->name('product.create');

    //商品详情页面
    Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');

    //删除商品
    Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    //编辑商品
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');

    //处理编辑商品的请求
    Route::put('edit/{id}', [ProductController::class, 'update'])->name('product.update');
});

    //搜索商品
    Route::get('index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');

