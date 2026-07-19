<?php

use App\Http\Controllers\Admin\ColivingBookingController;
use App\Http\Controllers\Admin\ColivingRoomController;
use App\Http\Controllers\Admin\CafeEventBookingController;
use App\Http\Controllers\Admin\HomepageSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ColivingController;
use App\Http\Controllers\CafeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColivingReportController;
use App\Http\Controllers\CafeReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page (umum)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/check-availability', [HomeController::class, 'checkAvailability'])->name('check.availability');

// 🏘️ Coliving Routes (public)
Route::prefix('coliving')->name('coliving.')->group(function () {

    // daftar kamar
    Route::get('/', [ColivingController::class, 'index'])
        ->name('index');

    Route::post('check-availability', [ColivingController::class, 'checkAvailability'])
        ->name('check.availability');

    // payment
    Route::get('payment-callback', [ColivingController::class, 'paymentCallback'])->name('payment.callback');
    Route::post('snap-token/{bookingReference}', [ColivingController::class, 'snapToken'])->name('snap-token');
    Route::get('payment-status/{bookingReference}', [ColivingController::class, 'paymentStatus'])->name('payment.status');
    Route::get('payment-success/{bookingReference}', [ColivingController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment/{bookingReference}', [ColivingController::class, 'payment'])->name('payment');

    // route customer
    Route::middleware(['auth', 'role:customer'])->group(function () {

        Route::post('{room}/book', [ColivingController::class, 'book'])
            ->name('book');
    });

    // detail kamar (SELALU taruh paling bawah)
    Route::get('{room}', [ColivingController::class, 'show'])
        ->name('show');

    Route::get('/my-booking/coliving/invoice/{reference}', [ColivingController::class, 'invoice'])
        ->name('coliving.invoice');
});

Route::post('coliving/payment/webhook', [ColivingController::class, 'paymentWebhook'])
    ->name('coliving.payment.webhook');

// ☕ Cafe & Events Routes (public)
Route::prefix('cafe')->name('cafe.')->group(function () {

    // Halaman publik
    Route::get('/', [CafeController::class, 'index'])->name('index');
    Route::get('/menu', [CafeController::class, 'menu'])->name('menu');

    // Semua fitur booking wajib login
    Route::middleware('auth')->group(function () {

        // Booking Event
        Route::get('/book-event', [CafeController::class, 'bookEvent'])->name('book-event');
        Route::post('/book-event', [CafeController::class, 'storeBooking'])->name('store-booking');

        // Payment
        Route::get('payment/{bookingReference}', [CafeController::class, 'payment'])->name('payment');
        Route::post('payment/{bookingReference}/snap-token', [CafeController::class, 'snapToken'])->name('snap-token');
        Route::get('payment-success/{bookingReference}', [CafeController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('payment-status/{bookingReference}', [CafeController::class, 'paymentStatus'])->name('payment.status');

    });

    // Callback Midtrans (jangan pakai auth)
    Route::get('payment-callback', [CafeController::class, 'paymentCallback'])
        ->name('payment.callback');
});


Route::post('cafe/payment/webhook', [CafeController::class, 'paymentWebhook'])
    ->name('cafe.payment.webhook');

// 🧑‍💻 Dashboard Routes - Pakai prefix 'dashboard' aja
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('admin.')
    ->group(function () {

        // Dashboard - semua role bisa akses
        Route::get('/', [DashboardController::class, 'index'])
            ->middleware('role:admin|operator')
            ->name('dashboard');

        // Profile - semua role bisa akses
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->middleware('role:admin|operator')
            ->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])
            ->middleware('role:admin|operator')
            ->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->middleware('role:admin|operator')
            ->name('profile.destroy');


        // ====== MODUL UNTUK ADMIN & OPERATOR ======

        Route::middleware('role:admin|operator')->group(function () {
            // Coliving Rooms
            Route::get('coliving-rooms/stats', [ColivingRoomController::class, 'stats'])
                ->name('coliving-rooms.stats');
            // Coliving Bookings
            Route::get('coliving-bookings/stats', [ColivingBookingController::class, 'stats'])
                ->name('coliving-bookings.stats');

            
            Route::resource('coliving-bookings', ColivingBookingController::class)
                ->only(['index', 'show', 'edit', 'update'])->names([
                    'index' => 'coliving-bookings.index',
                    'show' => 'coliving-bookings.show',
                    'edit' => 'coliving-bookings.edit',
                    'update' => 'coliving-bookings.update',
                ]);

            // Cafe Event Bookings
            Route::get('cafe-bookings/stats', [CafeEventBookingController::class, 'stats'])
                ->name('cafe-bookings.stats');
            Route::post('cafe-bookings/{cafeBooking}/approve', [CafeEventBookingController::class, 'approve'])
                ->name('cafe-bookings.approve');
            Route::resource('cafe-bookings', CafeEventBookingController::class)->names([
                'index' => 'cafe-bookings.index',
                'show' => 'cafe-bookings.show',
                'edit' => 'cafe-bookings.edit',
                'update' => 'cafe-bookings.update',
                'destroy' => 'cafe-bookings.destroy',
            ])->except(['create', 'store']);

            // Contact Messages
            Route::get('contact-messages/stats', [ContactMessageController::class, 'stats'])
                ->name('contact-messages.stats');
            Route::resource('contact-messages', ContactMessageController::class)
                ->only(['index', 'show', 'destroy'])
                ->names([
                    'index' => 'contact-messages.index',
                    'show' => 'contact-messages.show',
                    'destroy' => 'contact-messages.destroy',
                ]);

            // Halaman pilih rentang waktu
            Route::get('/reports/print/{type}', function ($type) {

                abort_unless(in_array($type, ['coliving', 'cafe']), 404);

                return view('reports.print-report', compact('type'));

            })->name('reports.print');

            // Generate PDF Coliving
            Route::get('/reports/coliving', [ColivingReportController::class, 'index'])
                ->name('coliving.report.print');

            // Generate PDF Cafe
            Route::get('/reports/cafe', [CafeReportController::class, 'index'])
                ->name('cafe.report.print');
        });





        // ====== MODUL KHUSUS Operator ONLY ======
        Route::middleware('role:operator')->group(function () {
            // Coliving Rooms
            Route::resource('coliving-rooms', ColivingRoomController::class)
            ->except(['show'])
            ->names([
                'index'   => 'coliving-rooms.index',
                'create'  => 'coliving-rooms.create',
                'store'   => 'coliving-rooms.store',
                'edit'    => 'coliving-rooms.edit',
                'update'  => 'coliving-rooms.update',
                'destroy' => 'coliving-rooms.destroy',
            ]);
            // Hero Sliders
            Route::get('hero-sliders/stats', [HeroSliderController::class, 'stats'])
                ->name('hero-sliders.stats');
            Route::resource('hero-sliders', HeroSliderController::class)->names([
                'index' => 'hero-sliders.index',
                'create' => 'hero-sliders.create',
                'store' => 'hero-sliders.store',
                'edit' => 'hero-sliders.edit',
                'update' => 'hero-sliders.update',
                'destroy' => 'hero-sliders.destroy',
            ]);

            // Homepage Sections
            Route::get('homepage/stats', [HomepageSectionController::class, 'stats'])
                ->name('homepage.stats');
            Route::resource('homepage', HomepageSectionController::class)->except(['show'])->names([
                'index' => 'homepage.index',
                'create' => 'homepage.create',
                'store' => 'homepage.store',
                'edit' => 'homepage.edit',
                'update' => 'homepage.update',
                'destroy' => 'homepage.destroy',
            ]);

            // Features
            Route::get('features/stats', [FeatureController::class, 'stats'])
                ->name('features.stats');
            Route::resource('features', FeatureController::class)->names([
                'index' => 'features.index',
                'create' => 'features.create',
                'store' => 'features.store',
                'edit' => 'features.edit',
                'update' => 'features.update',
                'destroy' => 'features.destroy',
            ])->except(['show']);

            // Testimonials
            Route::get('testimonials/stats', [TestimonialController::class, 'stats'])
                ->name('testimonials.stats');
            Route::resource('testimonials', TestimonialController::class)->names([
                'index' => 'testimonials.index',
                'create' => 'testimonials.create',
                'store' => 'testimonials.store',
                'edit' => 'testimonials.edit',
                'update' => 'testimonials.update',
                'destroy' => 'testimonials.destroy',
            ])->except(['show']);

            // Gallery
            Route::get('galleries/stats', [GalleryController::class, 'stats'])
                ->name('galleries.stats');
            Route::resource('galleries', GalleryController::class)->names([
                'index' => 'galleries.index',
                'create' => 'galleries.create',
                'store' => 'galleries.store',
                'edit' => 'galleries.edit',
                'update' => 'galleries.update',
                'destroy' => 'galleries.destroy',
            ])->except(['show']);

            // FAQs
            Route::get('faqs/stats', [FaqController::class, 'stats'])
                ->name('faqs.stats');
            Route::resource('faqs', FaqController::class)->names([
                'index' => 'faqs.index',
                'create' => 'faqs.create',
                'store' => 'faqs.store',
                'edit' => 'faqs.edit',
                'update' => 'faqs.update',
                'destroy' => 'faqs.destroy',
            ]);

            // Site Settings
            Route::get('site-settings/stats', [SiteSettingController::class, 'stats'])
                ->name('site-settings.stats');
            Route::get('site-settings', [SiteSettingController::class, 'index'])
                ->name('site-settings.index');
            Route::post('site-settings', [SiteSettingController::class, 'update'])
                ->name('site-settings.update');
            Route::get('site-settings/create', [SiteSettingController::class, 'create'])
                ->name('site-settings.create');
            Route::post('site-settings/store', [SiteSettingController::class, 'store'])
                ->name('site-settings.store');
        });
    });

Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/my-booking', [ColivingController::class, 'myBooking'])
        ->name('my-booking');

    // Cafe
    Route::get('/my-booking/cafe/invoice/{reference}', [CafeController::class, 'invoice'])
        ->name('cafe.invoice');

    // Coliving
    Route::get('/my-booking/coliving/invoice/{reference}', [ColivingController::class, 'invoice'])
        ->name('coliving.invoice');

});

// 🔐 Auth routes
require __DIR__ . '/auth.php';
