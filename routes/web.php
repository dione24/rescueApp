<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CoverageZoneController;
use App\Http\Controllers\FormationController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/client/home', [AnnouncementController::class, 'index'])->name('client.home');
    Route::get('/client/announcements/show/{id}', [AnnouncementController::class, 'showClient'])->name('client.announcements.show');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements/accept/{id}', [AnnouncementController::class, 'accept'])->name('announcements.accept');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::get('/rescuer/home', [CoverageZoneController::class, 'index'])->name('rescuer.home');
    Route::get('/coverage-zone/create', [CoverageZoneController::class, 'create'])->name('coverage_zone.create');
    Route::post('/coverage-zone', [CoverageZoneController::class, 'store'])->name('coverage_zone.store');
    Route::delete('/coverage-zone/{id}', [CoverageZoneController::class, 'destroy'])->name('coverage_zone.destroy');
    Route::get('/users/index', [AdminController::class, 'index'])->name('users.index');
    Route::get('/zones/index', [AdminController::class, 'zones'])->name('zones.index');
    Route::get('/users/edit/{id}', [AdminController::class, 'edit'])->name('users.edit');
    Route::patch('/users/update/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/rescuer/announcements/accept/{id}', [AnnouncementController::class, 'accept'])->name('rescuer.announcements.accept');
    Route::get('/rescuer/announcements/show/{id}', [AnnouncementController::class, 'show'])->name('rescuer.announcements.show');
    Route::post('/rescuer/announcements/comment/store/{id}', [AnnouncementController::class, 'storeComment'])->name('rescuer.announcements.comment.store');
    Route::get('/rescuer/announcements/close/{id}', [AnnouncementController::class, 'close'])->name('rescuer.announcements.close');

    Route::get('/admin/formation/index', [FormationController::class, 'liste'])->name('admin.formation');

    //edit
    Route::get('/admin/formation/edit/{id}', [FormationController::class, 'edit'])->name('admin.formation.edit');
    //delete
    Route::delete('/admin/formation/destroy/{id}', [FormationController::class, 'destroy'])->name('admin.formation.destroy');
    //admin.formation.create
    Route::get('/admin/formation/create', [FormationController::class, 'create'])->name('admin.formation.create');

    //formation.store
    Route::post('/admin/formation/store', [FormationController::class, 'store'])->name('admin.formation.store');
    //admin.formation.show
    Route::get('/admin/formation/show/{id}', [FormationController::class, 'show'])->name('admin.formation.show');
});
