<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerAdController;
use App\Http\Controllers\DefaultCommentController;
use App\Http\Controllers\HelpSupportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketerCommissionPaymentController;
use App\Http\Controllers\MarketerCommissionReportController;
use App\Http\Controllers\MarketerCommissionSetupController;
use App\Http\Controllers\MarketerController;
use App\Http\Controllers\PaymentSetupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivacyPoliciesController;
use App\Http\Controllers\TermConditionsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserPaymentReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\website\WebsiteController;



Route::get('/', [HomeController::class, 'websiteHomePage'])->name('websiteHomePage');

Auth::routes();

# ------------------------------ register ---------------------------------#
Route::get('/register', function (){ return redirect()->route('login'); })->name('register');
//Route::get('/register', [RegisterController::class, 'register'])->name('register');
//Route::post('/register', [RegisterController::class, 'storeUser'])->name('register');

# -----------------------------login----------------------------------------#
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

# ----------------------------- main dashboard ------------------------------#
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

# ----------------------------- about us ------------------------------#
Route::get('about', [AboutController::class, 'edit'])->middleware('auth')->name('about.edit');
Route::post('about/update', [AboutController::class, 'update'])->middleware('auth')->name('about.update');

# ----------------------------- privacy policy ------------------------------#
Route::get('privacy_policy', [PrivacyPoliciesController::class, 'edit'])->middleware('auth')->name('privacy_policy.edit');
Route::post('privacy_policy/update', [PrivacyPoliciesController::class, 'update'])->middleware('auth')->name('privacy_policy.update');

# ----------------------------- terms & condition ------------------------------#
Route::get('term_condition', [TermConditionsController::class, 'edit'])->middleware('auth')->name('term_condition.edit');
Route::post('term_condition/update', [TermConditionsController::class, 'update'])->middleware('auth')->name('term_condition.update');

# ----------------------------- marketer -----------------------#
Route::get('marketer', [MarketerController::class, 'index'])->middleware('auth')->name('marketer');
Route::post('marketer/store', [MarketerController::class, 'store'])->middleware('auth')->name('marketer.store');
Route::post('marketer/update', [MarketerController::class, 'update'])->middleware('auth')->name('marketer.update');
# marketer commission setup
Route::get('marketer/commission_setup/index', [MarketerCommissionSetupController::class, 'index'])->middleware('auth')->name('marketer.commission_setup.index');
Route::post('marketer/commission_setup/update', [MarketerCommissionSetupController::class, 'update'])->middleware('auth')->name('marketer.commission_setup.update');
# marketer commission received report
Route::get('marketer/commission_report/{marketer_id?}', [MarketerCommissionReportController::class, 'index'])->middleware('auth')->name('marketer.commission_report.index');
# marketer commission payment
Route::get('marketer/commission_payment/{marketer_id?}', [MarketerCommissionPaymentController::class, 'index'])->middleware('auth')->name('marketer.commission_payment.index');
Route::post('marketer/commission_payment/store/{marketer_id?}', [MarketerCommissionPaymentController::class, 'store'])->middleware('auth')->name('marketer.commission_payment.store');

# ----------------------------- user userManagement -----------------------#
# users- real
Route::get('userManagement', [UserManagementController::class, 'index'])->middleware('auth')->name('userManagement');
Route::post('user/add/save', [UserManagementController::class, 'addNewUserSave'])->middleware('auth')->name('user/add/save');
Route::post('search/user/list', [UserManagementController::class, 'searchUser'])->middleware('auth')->name('search/user/list');
Route::post('update', [UserManagementController::class, 'update'])->middleware('auth')->name('update');
Route::get('user/analytics', [UserManagementController::class, 'analytics'])->middleware('auth')->name('user.analytics');
Route::get('user/profile/{id}', [UserManagementController::class, 'profile'])->middleware('auth')->name('user.profile');
# users- fake
Route::get('userManagement/fakeUser', [UserManagementController::class, 'fakeUser'])->middleware('auth')->name('userManagement.fakeUser');

# user payment report
Route::get('user/payment_report/{user_id?}', [UserPaymentReport::class, 'index'])->middleware('auth')->name('user.payment_report.index');

# payment setup
Route::get('user/payment_setup/index', [PaymentSetupController::class, 'index'])->middleware('auth')->name('user.payment_setup.index');
Route::post('user/payment_setup/store', [PaymentSetupController::class, 'store'])->middleware('auth')->name('user.payment_setup.store');

# ----------------------------- forget password ----------------------------#
Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('forget-password');

# ----------------------------- reset password -----------------------------#
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword']);
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword']);

# ----------------------------- post -----------------------#
# post
Route::get('post', [PostController::class, 'index'])->middleware('auth')->name('post.index');
# view increase logic setup
Route::get('post/increaseViewSetup', [PostController::class, 'increaseViewSetup'])->middleware('auth')->name('post.increaseViewSetup');
Route::post('post/store_increaseViewSetup', [PostController::class, 'store_increaseViewSetup'])->middleware('auth')->name('post.store_increaseViewSetup');
Route::post('post/update_increaseViewSetup', [PostController::class, 'update_increaseViewSetup'])->middleware('auth')->name('post.update_increaseViewSetup');

# default comment setup
Route::get('defaultComment/index', [DefaultCommentController::class, 'index'])->middleware('auth')->name('defaultComment.index');
Route::post('defaultComment/store', [DefaultCommentController::class, 'store'])->middleware('auth')->name('defaultComment.store');
Route::post('defaultComment/update', [DefaultCommentController::class, 'update'])->middleware('auth')->name('defaultComment.update');

# ----------------------------- banner ad  -----------------------#
Route::get('banner_ad', [BannerAdController::class, 'index'])->middleware('auth')->name('banner_ad.index');
Route::post('banner_ad/store', [BannerAdController::class, 'store'])->middleware('auth')->name('banner_ad.store');

# ----------------------------- admin notification (message) -----------------------#
Route::get('admin_notification/index', [AdminNotificationController::class, 'index'])->middleware('auth')->name('admin_notification.index');
Route::post('admin_notification/store', [AdminNotificationController::class, 'store'])->middleware('auth')->name('admin_notification.store');

# ----------------------------- help and support -----------------------#
Route::get('help_support/index', [HelpSupportController::class, 'index'])->middleware('auth')->name('help_support.index');
Route::post('help_support/store', [HelpSupportController::class, 'store'])->middleware('auth')->name('help_support.store');
Route::post('help_support/update', [HelpSupportController::class, 'update'])->middleware('auth')->name('help_support.update');

//----------------------------- webisite -----------------------------#
Route::get('/website/home', [WebsiteController::class, 'home']);
//----------------------------- webisite -----------------------------#
