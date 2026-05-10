<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ================= Controllers =================
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Auth\OTPController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PaymentDashboardController;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Delivery\DeliveryController;


use App\Http\Controllers\Admin\OrderAssignController;


use App\Http\Controllers\Delivery\WalletController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Delivery\DeliveryDashboardController;
use App\Http\Controllers\Admin\AdminSupplierController;


Route::post('/payment/create', [OrderController::class, 'createRazorpay'])->name('payment.create');
Route::post('/payment/verify', [OrderController::class, 'verifyPayment'])->name('payment.verify');


/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// ========== Home ==========
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

// ========== Categories / Sub-Categories ==========
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/subcategory/{slug}', [SubCategoryController::class, 'show'])->name('subcategory.show');
Route::get('/all', [CategoryController::class, 'showAllCategories'])->name('categories.all');



/*
|--------------------------------------------------------------------------
| AUTHENTICATION (OTP BASED)
|--------------------------------------------------------------------------
*/
Route::get('/register', [OTPController::class, 'showRegister'])->name('register.page');
Route::post('/register', [OTPController::class, 'register'])->name('register');

Route::get('/login', function () {
    return redirect()->route('login');
})->name('login');

Route::get('/login', [OTPController::class, 'showLogin'])->name('login.page');


Route::post('/send-otp', [OTPController::class, 'sendOtp'])->name('send.otp');


Route::get('/verify-otp', [OTPController::class, 'showVerifyOtp'])->name('verify.otp.page');
Route::post('/verify-otp', [OTPController::class, 'verifyOtp'])->name('verify.otp');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');




// SUPPLIER
Route::get('/supplier/password-login', [OTPController::class, 'showSupplierPasswordForm'])->name('supplier.password.login');
Route::post('/supplier/password-login', [OTPController::class, 'supplierPasswordLogin'])
    ->name('supplier.password.submit');

Route::middleware(['auth'])->group(function () {

     Route::get('/supplier/index', [AdminSupplierController::class, 'supplierLoginDashboard'])
        ->name('admin.supplier.index');

});



Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/payments', [PaymentDashboardController::class, 'index'])
         ->name('admin.payments-dashboard');
});

/*
|--------------------------------------------------------------------------
| WISHLIST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('wishlist')->name('wishlist.')->group(function () {

    Route::get('/', [WishlistController::class, 'show'])->name('show');

    Route::post('/add/{id}', [WishlistController::class, 'add'])->name('add');
    Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');

    Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('remove');
});



/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('cart')->name('cart.')->group(function () {

    Route::get('/', [CartController::class, 'show'])->name('show');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');

    Route::post('/update/{id}', [CartController::class, 'updateQty'])->name('updateQty');
    Route::post('/buy-now/{product}', [CartController::class, 'buyNow'])->name('buyNow');
    Route::post('/buy-all', [CartController::class, 'buyAll'])->name('buyAll');
  

});



/*
|--------------------------------------------------------------------------
| ORDERS & CHECKOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Checkout
    Route::prefix('checkout')->group(function () {
        Route::get('/', [OrderController::class, 'showCheckout'])->name('checkout.show');
        Route::post('/', [OrderController::class, 'placeOrder'])->name('checkout.place');
        Route::get('order/success/{order}', [OrderController::class, 'success'])->name('order.success');
    });

    // My Orders (Customer)
    Route::get('/my_orders', [OrderController::class, 'myOrders'])->name('orders.my');

    // Cancel Order
    Route::post('/order/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel');
});

// Track Order 
Route::get('/order/track/{order}', [OrderController::class, 'track'])->name('order.track');



/*
|--------------------------------------------------------------------------
| ADMIN PASSWORD LOGIN 
|--------------------------------------------------------------------------
*/
Route::get('/admin/password-login', [OTPController::class, 'showAdminPasswordForm'])->name('admin.password.login');
Route::post('/admin/password-login', [OTPController::class, 'adminPasswordLogin'])->name('admin.password.submit');



/*--------------------------------------------------------------------------
 ADMIN PANEL ROUTES
 --------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->name('admin.')
    ->group(function () {

                
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])
        ->name('dashboard');


    // Orders
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminDashboardController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{id}/update', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.update');


// Delivery Partner Requests
Route::get('/delivery-requests', [AdminDashboardController::class, 'deliveryRequests'])
    ->name('delivery.requests');

Route::post('/delivery-approve/{id}', [AdminDashboardController::class, 'approveDelivery'])
    ->name('delivery.approve');

Route::post('/delivery-reject/{id}', [AdminDashboardController::class, 'rejectDelivery'])
    ->name('delivery.reject');


Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
        ->name('admin.dashboard');
});


// Users List
Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');

// Payments
Route::get('/payments', [PaymentDashboardController::class, 'index'])->name('payments');


// Products 
Route::resource('products', AdminProductController::class);
});

Route::get('/admin/subcategories/by-category/{id}', [SubcategoryController::class, 'getByCategory']);

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/payment/create', [PaymentController::class, 'createOrder'])->name('payment.create');
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('checkout.order_success');
    Route::post('/checkout/place', [CheckoutController::class, 'place']) ->name('checkout.place');
    Route::get('/checkout/order/success/{order}', [CheckoutController::class, 'success']) ->name('order.success');



Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin/assign-orders', [OrderAssignController::class,'orders']);
    Route::post('/admin/assign-orders/{order}', [OrderAssignController::class,'assign']);

});





/* DELIVERY */
Route::middleware(['auth'])->group(function () {
    Route::get('/delivery/wallet', [WalletController::class,'index']);
    Route::post('/delivery/wallet/withdraw', [WalletController::class,'withdraw']);
});

/* ADMIN */
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/withdraw-requests', [WithdrawController::class,'requests']);
    Route::post('/admin/withdraw-approve/{id}', [WithdrawController::class,'approve']);
    Route::post('/admin/withdraw-reject/{id}', [WithdrawController::class,'reject']);
});



// DELIVERY APPLY (USER)
Route::middleware(['auth'])->group(function () {
    Route::get('/apply-delivery', [DeliveryController::class, 'applyForm'])->name('delivery.apply');
    Route::post('/apply-delivery', [DeliveryController::class, 'applySubmit'])->name('delivery.apply.submit');
});

// DELIVERY DASHBOARD 
Route::middleware(['auth'])->prefix('delivery')->group(function () {
    Route::get('/dashboard', [DeliveryDashboardController::class, 'dashboard'])->name('delivery.dashboard');
    Route::post('/accept-order/{id}', [DeliveryDashboardController::class, 'acceptOrder'])->name('delivery.accept');
    Route::post('/update-status/{id}', [DeliveryDashboardController::class, 'updateStatus'])->name('delivery.updateStatus');
});


Route::post('/delivery/cancel', [DeliveryController::class, 'cancelRequest'])->middleware('auth')->name('delivery.cancel');
Route::post('/delivery/order/{id}/status', [DeliveryOrderController::class,'updateStatus'])
     ->name('delivery.updateStatus');
Route::post('/admin/order/{order}/assign', 
    [\App\Http\Controllers\Admin\OrderAssignController::class, 'assign']
)->name('admin.order.assign');
Route::post('/admin/order/{order}/assign', 
    [OrderAssignController::class, 'assign']
)->name('admin.order.assign');
Route::middleware(['auth'])->group(function () {
    Route::get('/delivery/dashboard', [DeliveryDashboardController::class, 'dashboard'])
        ->name('delivery.dashboard');

    Route::post('/delivery/order/{id}/accept', [DeliveryDashboardController::class, 'acceptOrder'])
        ->name('delivery.order.accept');

    Route::post('/delivery/order/{id}/status', [DeliveryDashboardController::class, 'updateStatus'])
        ->name('delivery.updateStatus');
});
 Route::get('delivery-partner/{userId}/orders', [AdminDashboardController::class, 'partnerOrdersPage'])
        ->name('delivery.partner.orders');
        Route::get('admin/delivery-partner/{userId}/orders', [AdminDashboardController::class, 'partnerOrdersPage'])
    ->name('admin.delivery.partner.orders');


Route::middleware(['auth'])->group(function () {

    Route::get('/delivery/dashboard', 
        [DeliveryDashboardController::class, 'dashboard']
    )->name('delivery.dashboard');

    Route::post('/delivery/toggle-status', 
        [DeliveryDashboardController::class, 'toggleStatus']
    )->name('delivery.toggleStatus');

});


Route::post('/delivery/order/{id}/on-the-way', 
    [DeliveryDashboardController::class, 'onTheWay']
)->name('delivery.onTheWay');

Route::post('/delivery/order/{id}/verify-otp', 
    [DeliveryDashboardController::class, 'verifyOtp']
)->name('delivery.verifyOtp');


Route::post('delivery/order/{id}/verify-otp', [DeliveryDashboardController::class, 'verifyOtp'])
    ->name('delivery.verifyOtp')
    ->middleware('auth');

 // Delivery partners page
Route::get('/admin/delivery-partners', [AdminDashboardController::class, 'deliveryPartners'])
     ->name('admin.delivery.partners');

// AJAX call for partner orders
Route::get('/admin/delivery-partner/{id}/orders', [AdminDashboardController::class, 'partnerOrders']);


Route::get('/admin/delivery-live-tracking', [AdminDashboardController::class, 'liveTracking'])
     ->name('admin.delivery.live-tracking');

Route::get('/supplier/index', [AdminSupplierController::class, 'supplierLoginDashboard'])
    ->name('admin.supplier.index');

Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->name('admin.')
    ->group(function () {

// Suppliers Panel
Route::get('/suppliers', [AdminSupplierController::class, 'showSuppliersPanel'])
        ->name('suppliers_panel');

// Add Supplier

    Route::post('/suppliers/add', [AdminSupplierController::class, 'createSupplier'])
->name('suppliers.add');

    
Route::get('/suppliers/add', [AdminSupplierController::class, 'showAddSupplierForm'])
->name('supplier.add-form');


// Show
Route::get('/suppliers/purchase', [AdminSupplierController::class, 'showPurchaseForm'])
        ->name('suppliers.purchase.form');

// Submit 
Route::post('/suppliers/purchase', [AdminSupplierController::class, 'submitPurchase'])
        ->name('suppliers.purchase.submit');


Route::get('/suppliers/{id}', [AdminSupplierController::class, 'supplierDashboard'])
->name('suppliers.dashboard');

Route::delete('/suppliers/{id}', [AdminSupplierController::class, 'deleteSupplier'])
->name('supplier.delete');



});

Route::middleware(['auth'])->group(function () {

    Route::post('/supplier/products/add', 
        [AdminSupplierController::class, 'supplierAddProduct']
    )->name('supplier.products.add');

});

Route::get('/admin/supplier/pending-products', 
    [AdminDashboardController::class, 'supplierPendingProducts']
)->name('admin.supplier.pending.products');

Route::get(
    'admin/purchase/{product}',
    [AdminSupplierController::class, 'purchaseForm']
)->name('admin.supplier.purchase.form');

Route::post(
    'admin/purchase/{product}',
    [AdminSupplierController::class, 'purchaseStore']
)->name('admin.purchase.store');

