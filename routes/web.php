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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    // Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    // Route::get('/search', [AdminController::class, 'search'])->name('global.search');

    // Show All Categories
    // Route::get('all-categories', [CategoryController::class, 'index'])->name('categories');
    // Route::post('store-category', [CategoryController::class, 'store'])->name('categories.store');
    // Route::get('edit-category/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    // Route::post('update-category/{id}', [CategoryController::class, 'update'])->name('categories.update');
    // Route::get('delete-category/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

    // Products Routes
    // Route::get('/products', [ProductController::class, 'index'])->name('products');
    // Route::delete('/product-image/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');
    // Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    // Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    // Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    // Route::get('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');


    //Order Management
    // Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    // Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    // Route::post('/orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');
    // Route::get('/orders/delete/{id}', [OrderController::class, 'destroy'])->name('orders.delete');

    // Route::patch('orders/{order}/status',  [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    // Route::patch('orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('admin.orders.payment');

    //Instructions Routes
    // Route::get('/instruction-guides', [InstructionGuideController::class, 'index'])->name('instructionguides');
    // Route::post('/instruction-guides/store', [InstructionGuideController::class, 'store'])->name('instructionguides.store');
    // Route::get('/instruction-guides/edit/{id}', [InstructionGuideController::class, 'edit'])->name('instructionguides.edit');
    // Route::post('/instruction-guides/update/{id}', [InstructionGuideController::class, 'update'])->name('instructionguides.update');
    // Route::get('/instruction-guides/delete/{id}', [InstructionGuideController::class, 'destroy'])->name('instructionguides.delete');

    //Contact Messages
    // Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contactmessages');
    // Route::get('/contact-messages/delete/{id}', [ContactMessageController::class, 'destroy'])->name('contactmessages.delete');

    // Route::post('/contact', [ContactMessageController::class, 'submit'])->name('contact.submit');


    // Index - All Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');

    //Roles Management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');

    //Permissions Management
    // routes/web.php
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.delete');
});
