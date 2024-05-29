<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('landing');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Route::get("/merchants/{merchantUuid}/products", [ProductController::class, 'index'])->name('admin.merchant-products.list');
    // Route::get("/merchants/{merchantUuid}/products/create", [ProductController::class, 'create'])->name('admin.merchant-products.create');
    // Route::get("/merchants/{merchantUuid}/products/{product}/show", [ProductController::class, 'show'])->name('admin.merchant-products.show');

    Route::get("/products/filter", [ProductController::class, 'filter'])->name('admin.products.filter');
    Route::get("/merchant/search", [MerchantController::class, 'search'])->name('admin.accounts.api-search');

    Route::resource("/merchants", MerchantController::class)->names('admin.merchants');
    Route::resource("/products", ProductController::class)->names('admin.products');
    Route::resource("/accounts", AccountController::class)->names('admin.accounts');

    Route::get('/dashboard', function () {
        return Inertia::render('TailAdmin/Dashboard/ECommerceView');
    })->name('dashboard');

    Route::get('/calendar', function () {
        return Inertia::render('TailAdmin/CalendarView');
    })->name('calendar');

    Route::get('/profile', function () {
        return Inertia::render('TailAdmin/ProfileView');
    })->name('profile');

    Route::get('/forms/form-elements', function () {
        return Inertia::render('TailAdmin/Forms/FormElementsView');
    })->name('form.elements');

    Route::get('/forms/form-layout', function () {
        return Inertia::render('TailAdmin/Forms/FormLayoutView');
    })->name('form.layout');

    Route::get('/tables', function () {
        return Inertia::render('TailAdmin/TablesView');
    })->name('tables');

    Route::get('/pages/settings', function () {
        return Inertia::render('TailAdmin/Pages/SettingsView');
    })->name('settings');

    Route::get('/pages/404', function () {
        return Inertia::render('TailAdmin/Pages/NotFoundView');
    })->name('error404');

    Route::get('/charts/basic-chart', function () {
        return Inertia::render('TailAdmin/Charts/BasicChartView');
    })->name('chart.basic');

    Route::get('/ui-elements/alerts', function () {
        return Inertia::render('TailAdmin/UiElements/AlertsView');
    })->name('element.alerts');

    Route::get('/ui-elements/buttons', function () {
        return Inertia::render('TailAdmin/UiElements/ButtonsView');
    })->name('element.buttons');

    Route::get('/auth/signin', function () {
        return Inertia::render('TailAdmin/Authentication/SigninView');
    })->name('auth.signin');

    Route::get('/auth/signup', function () {
        return Inertia::render('TailAdmin/Authentication/SignupView');
    })->name('auth.signup');
});

// Route::get('/dashboard');