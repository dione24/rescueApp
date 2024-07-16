<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CoverageZoneController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/client/home', [AnnouncementController::class, 'index'])->name('client.home');
    Route::get('/rescuer/home', [CoverageZoneController::class, 'index'])->name('rescuer.home');


    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements/accept/{id}', [AnnouncementController::class, 'accept'])->name('announcements.accept');
    //admin.announcements.destroy
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');



    Route::get('/coverage-zone/create', [CoverageZoneController::class, 'create'])->name('coverage_zone.create');
    Route::post('/coverage-zone', [CoverageZoneController::class, 'store'])->name('coverage_zone.store');
    //'coverage_zone.destroy
    Route::delete('/coverage-zone/{id}', [CoverageZoneController::class, 'destroy'])->name('coverage_zone.destroy');

    Route::get('/users/index', [AdminController::class, 'index'])->name('users.index');
    Route::get('/zones/index', [AdminController::class, 'zones'])->name('zones.index');

    //{{route('users.edit',$user->id)}}
    Route::get('/users/edit/{id}', [AdminController::class, 'edit'])->name('users.edit');
    Route::patch('/users/update/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');

    Route::post('/rescuer/announcements/accept/{id}', [AnnouncementController::class, 'accept'])->name('rescuer.announcements.accept');
});
