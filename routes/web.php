<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\ManageBookingController;
use App\Http\Controllers\Admin\PaymentManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\NewsletterController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\WebhookController;
use App\Models\Amenity;
use App\Models\GalleryImage;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\RoomType;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $hotels = Hotel::where('is_active', true)->with(['roomTypes', 'images'])->orderBy('name')->get();
    $roomTypes = RoomType::with(['amenities', 'hotel', 'images'])
        ->where('is_active', true)
        ->orderBy('base_price')
        ->get();
    $amenities = Amenity::orderBy('name')->get();
    $gallery = GalleryImage::where('imageable_type', Hotel::class)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    return view('landing.index', compact('hotels', 'roomTypes', 'amenities', 'gallery'));
})->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/hotels/{hotel}', [SearchController::class, 'hotel'])->name('hotels.show');
Route::get('/hotels/{hotel}/room-types/{roomType}', [SearchController::class, 'roomType'])->name('hotels.room-types.show');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('administrator')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole(['hotel-manager', 'receptionist'])) {
        return redirect()->route('staff.dashboard');
    }

    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin-only routes (dashboard)
    Route::middleware('role:administrator')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    });

    // Admin & Manager routes (employees, discounts, content)
    Route::middleware('role:administrator,hotel-manager')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('discounts', DiscountController::class);
        Route::resource('contents', ContentController::class);
    });

    // Manager+ routes (hotels, room-types, rooms, amenities, reports)
    Route::middleware('role:administrator,hotel-manager')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('hotels', HotelController::class);
        Route::resource('hotels.room-types', RoomTypeController::class);
        Route::resource('hotels.room-types.rooms', RoomController::class);
        Route::resource('amenities', AmenityController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/daily-bookings', [ReportController::class, 'dailyBookings'])->name('reports.daily-bookings');
        Route::get('/reports/monthly-revenue', [ReportController::class, 'monthlyRevenue'])->name('reports.monthly-revenue');
        Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
        Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
        Route::get('/reports/room-performance', [ReportController::class, 'roomPerformance'])->name('reports.room-performance');
        Route::get('/reports/cancelled-bookings', [ReportController::class, 'cancelledBookings'])->name('reports.cancelled-bookings');
        Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    });

    // Staff+ routes (manage-bookings, payments, customer lookup)
    Route::middleware('role:administrator,hotel-manager,receptionist')->prefix('admin')->name('admin.')->group(function () {
        // Manage Bookings
        Route::get('/manage-bookings', [ManageBookingController::class, 'index'])->name('manage-bookings.index');
        Route::get('/manage-bookings/{booking}', [ManageBookingController::class, 'show'])->name('manage-bookings.show');
        Route::post('/manage-bookings/{booking}/status', [ManageBookingController::class, 'updateStatus'])->name('manage-bookings.update-status');

        // Payment Management
        Route::get('/payments', [PaymentManagementController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentManagementController::class, 'show'])->name('payments.show');

        // Customer Management
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });

    Route::middleware('role:administrator,hotel-manager,receptionist')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', StaffDashboardController::class)->name('dashboard');
    });

    Route::middleware('role:registered-customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', CustomerDashboardController::class)->name('dashboard');
        Route::get('/book', [BookingController::class, 'create'])->name('book.create');
        Route::post('/book', [BookingController::class, 'store'])->name('book.store');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('/bookings/{booking}/payment', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/bookings/{booking}/checkout', [PaymentController::class, 'checkout'])->name('payments.checkout');
        Route::get('/bookings/{booking}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
        Route::get('/bookings/{booking}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
        Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/webhook/stripe', [WebhookController::class, 'handleStripe'])->withoutMiddleware([VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
