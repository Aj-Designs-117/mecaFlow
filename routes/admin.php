<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('hierarchy')->group(function(){
    Route::view('/roles', 'admin.roles.index')->middleware('can:admin.roles.index')->name('admin.roles.index');
    Route::view('/permissions', 'admin.permissions.index')->middleware('can:admin.permissions.index')->name('admin.permissions.index');
    Route::view('/roles-permissions', 'admin.rolesPermissions.index')->middleware('can:admin.roles-permissions.index')->name('admin.rolesPermissions.index');
    Route::view('/users', 'admin.users.index')->middleware('can:admin.users.index')->name('admin.users.index');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/posts', 'admin.posts.index')->middleware('can:admin.posts.index')->name('admin.posts.index');
    Route::view('/posts/create', 'admin.posts.create')->middleware('can:admin.posts.create')->name('admin.posts.create');
    Route::view('/post/edit/{slug}', 'admin.posts.edit')->middleware('can:admin.posts.edit')->name('admin.posts.edit');
    Route::view('/categories/create', 'admin.categories.index')->middleware('can:admin.categories.index')->name('admin.categories.index');
    Route::view('/settings/web', 'admin.settings.index')->middleware('admin.setting.index')->name('admin.settings.index');
});
