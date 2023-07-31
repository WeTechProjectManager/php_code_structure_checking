<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Api\AdBannerController;
use App\Http\Controllers\Api\ApiDefaultCommentController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\HelpAndSupportController;
use App\Http\Controllers\Api\UserRegistrationController;
use App\Http\Controllers\Api\StroyController;
use App\Http\Controllers\Api\ChoiceController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ApiPostCommentController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiPostReactController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserBioDataController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UserSearchController;
use App\Http\Controllers\PrivacyPoliciesController;
use App\Http\Controllers\TermConditionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



# login
Route::post('login', [ApiLoginController::class, 'login']);
# registration
Route::post('registration', [UserRegistrationController::class, 'registration']);

Route::middleware('auth:sanctum')->group(function () {
    # profile
    Route::get('profile', [ApiLoginController::class, 'profile']);
    # showOtherProfile
    Route::get('profile/others', [ApiLoginController::class, 'showOtherProfile']);
    # logout
    Route::post('logout', [ApiLoginController::class, 'logout']);

    # mobile number verify
    Route::post('loginOrRegister-using-otp', [UserRegistrationController::class, 'loginOrRegister_using_otp']);
    Route::post('otp-verify', [UserRegistrationController::class, 'otp_verify']);
    # email verify
    Route::post('email-verify-using-otp', [UserRegistrationController::class, 'email_verify_using_otp']);
    Route::post('email-otp-verify', [UserRegistrationController::class, 'email_otp_verify']);

    # forget password
    Route::post('forget-password', [UserRegistrationController::class, 'forget_password']);

    Route::post('update-Passwords', [UserRegistrationController::class, 'update_password']);
});

Route::middleware('auth:sanctum')->group(function () {
    # story
    Route::post('save-story', [StroyController::class, 'save_story']);
    Route::get('show-story', [StroyController::class, 'show_story']);
    Route::post('delete-story', [StroyController::class, 'delete_story']);


    # my choice
    Route::post('my-choice', [ChoiceController::class, 'my_choice']);
    Route::get('show-my-choice', [ChoiceController::class, 'show_my_choice']);
    Route::post('delete-my-choice', [ChoiceController::class, 'delete_my_choice']);

    # choice me
    Route::get('show-choice-me', [ChoiceController::class, 'show_choice_me']);
    Route::post('delete-choice-me', [ChoiceController::class, 'delete_choice_me']);

    # my friend
    // Route::post('my-choice', [StroyController::class, 'my_friend']);
    Route::get('show-my-friend', [ChoiceController::class, 'show_my_friend']);
    Route::post('delete-my-friend', [ChoiceController::class, 'delete_my_friend']);
});

Route::middleware('auth:sanctum')->group(function () {
    # chat
    Route::post('/create-Conversation', [ChatController::class, 'create_Conversation']);
    Route::post('/show-Conversation', [ChatController::class, 'show_Conversation']);

    Route::post('/delete-chat', [ChatController::class, 'delete_chat']);

    Route::get('/single-chat-delete-for-everyone/{chat_id?}', [ChatController::class, 'single_chat_delete_for_everyone']);

    #messenger
    Route::get('/show-all-chat', [ChatController::class, 'show_all_Conversation']);

    #delete a full user conversation
    Route::get('/delete-Conversation-for-me/{chat_id?}', [ChatController::class, 'delete_Conversation_for_me']);
    Route::get('/delete-Conversation-for-everyone/{friend_id?}', [ChatController::class, 'delete_Conversation_for_everyone']);
});


Route::middleware('auth:sanctum')->group(function () {
    # payment
    Route::post('/payment', [PaymentController::class, 'payment']);
});


Route::middleware('auth:sanctum')->group(function () {
    # payment
    Route::post('/visit-my-profile', [VisitorController::class, 'visit_my_profile']);
    Route::get('/show-visit-my-profile', [VisitorController::class, 'show_visit_my_profile']);
});

Route::middleware('auth:sanctum')->group(function () {
    # transaction details
    Route::get('/show-my-transaction', [PaymentController::class, 'show_my_transaction']);
});

Route::middleware('auth:sanctum')->group(function () {
    # notification
    Route::get('/show-my-notification', [NotificationController::class, 'show_my_notification']);
});


Route::middleware('auth:sanctum')->group(function () {
    # block
    Route::post('/block-user', [BlockController::class, 'block_user']);
});

Route::middleware('auth:sanctum')->group(function () {
    # question and ans for help and support
    Route::get('/question-and-ans-for-help-support', [HelpAndSupportController::class, 'question_ans']);
});


#---------- forget password ---------------------------#
Route::post('forgetPassword/send-email',[UserRegistrationController::class,'sendEmail']);


Route::middleware('auth:sanctum')->group(function () {

    # user profile pic
    Route::get('profile/pic', [UserProfileController::class, 'profilePic']);
    # user profile upload
    Route::post('profile/upload', [UserProfileController::class, 'uploadProfile']);
    # user profile details upload
    Route::post('profile/details/update', [UserProfileController::class, 'profileDetailsUpdate']);
    # user cover pic
    Route::get('cover/pic', [UserProfileController::class, 'coverPic']);
    # user cover upload
    Route::post('cover/upload', [UserProfileController::class, 'uploadCover']);
    # user shortBio
    Route::post('short/bio', [UserProfileController::class, 'shortBioStore']);
    #showProfilePost
    Route::get('profile/post', [UserProfileController::class, 'showProfilePost']);
    #ProfileMakePublic
    Route::get('profile/make/private/public', [UserProfileController::class, 'profileMakePublicPrivate']);
    // #profileMakePrivate
    // Route::get('profile/make/private', [UserProfileController::class, 'profileMakePrivate']);


});

//ad banner
Route::middleware('auth:sanctum')->group(function () {

    //store adbanner
    Route::post('adBanner/store',[AdBannerController::class, 'store']);
    //show adbanner
    Route::get('adBanner/show',[AdBannerController::class, 'show']);
    //delete adbanner
    Route::get('adBanner/delete/{ad_banner_id}',[AdBannerController::class, 'delete']);

});

Route::middleware('auth:sanctum')->group(function () {

    # user search By name
    Route::get('user', [UserSearchController::class, 'userSearchByName']);
    # user search By name
    Route::get('user/feilter', [UserSearchController::class, 'allsearch']);



});

Route::middleware('auth:sanctum')->group(function () {

    # user search By name
    Route::get('user', [UserSearchController::class, 'userSearchByName']);
    # user search By name
    Route::get('user/feilter', [UserSearchController::class, 'allsearch']);



});


Route::middleware('auth:sanctum')->group(function () {

    // # terms conditions
    // Route::get('/terms/conditions',[TermConditionsController::class, 'apiTermsConditions']);
    # terms privacyPolicies
    Route::get('/privacy/policies',[PrivacyPoliciesController::class, 'apiPrivacyPolicies']);
    # about us
    Route::get('/about/us',[AboutController::class, 'apiAboutUs']);

    #setting part
    #reset password
    Route::post('/password/reset', [SettingController::class, 'resetPassword']);
    #reset email
    Route::post('/email/reset', [SettingController::class, 'resetEmail']);
    #reset Email Passord
    Route::post('/email/password/reset', [SettingController::class, 'resetEmailPassword']);



});

Route::middleware('auth:sanctum')->group(function () {

    # country nationlity
    Route::get('country', [UserBioDataController::class, 'country']);
    # user bodytype
    Route::get('body/type', [UserBioDataController::class, 'bodyType']);
    # user hairColor
    Route::get('hair/color', [UserBioDataController::class, 'hairColor']);
    # user eyeColor
    Route::get('eye/color', [UserBioDataController::class, 'eyeColor']);
     # user bodyColor
    Route::get('body/color', [UserBioDataController::class, 'bodyColor']);
    # user disabilities
    Route::get('disabilities', [UserBioDataController::class, 'disabilities']);
    # user prayers
    Route::get('prayers', [UserBioDataController::class, 'prayers']);
    # user eductionGeneral
    Route::get('eduction/general', [UserBioDataController::class, 'eductionGeneral']);
    # user eductionGeneral
    Route::get('eduction/islamic', [UserBioDataController::class, 'eductionIslamic']);
    # user hajj
    Route::get('hajj', [UserBioDataController::class, 'hajj']);
    # user umrahhajj
    Route::get('umrahhajj', [UserBioDataController::class, 'umrahhajj']);
    # user umrahhajj
    Route::get('zakat', [UserBioDataController::class, 'zakat']);
    # user KnowledgeOfQuran
    Route::get('knowledge/quran', [UserBioDataController::class, 'knowledgeOfQuran']);
    # user userBioData
    Route::get('biodata/{user_id}', [UserBioDataController::class, 'userBioData']);
    # user userBioDataStoreAndUpdate
    Route::post('biodata/update', [UserBioDataController::class, 'userBioDataStore']);




});



Route::middleware('auth:sanctum')->group( function () {

    #post store
    Route::post('post/store',[ApiPostController::class,'store']);
    #post show
    Route::get('post/show',[ApiPostController::class,'show']);
    #post delete
    Route::get('post/delete/{post_id}',[ApiPostController::class,'delete']);
    #post sharePostLink
    Route::get('post/post/link/{post_id}',[ApiPostController::class,'sharePostLink']);
    #post view store
    Route::post('post/view/store',[ApiPostController::class,'postViewStore']);

    #post react store
    Route::post('post/react/store',[ApiPostReactController::class,'store']);

    #post react remove
    Route::post('post/react/remove',[ApiPostReactController::class,'remove']);


    #post default comment
    Route::post('post/default/comment/store',[ApiDefaultCommentController::class,'store']);
    #post default comment
    Route::get('post/default/comment',[ApiDefaultCommentController::class,'show']);

    #post  comment  store
    Route::post('post/comment/store',[ApiPostCommentController::class,'store']);
    #post  comment  show
    Route::get('post/comment/show/{post_id}',[ApiPostCommentController::class,'show']);
    #isComment
    Route::get('post/isComment',[ApiPostCommentController::class,'isComment']);
    #isReact
    Route::get('post/isReact',[ApiPostReactController::class,'isReact']);
    #showEveryPostReact
    Route::get('every/post/react',[ApiPostReactController::class,'showEveryPostReact']);


});

#---------- forget password ---------------------------#
Route::post('forgetPassword/send-email',[UserRegistrationController::class,'sendEmail']);
Route::post('forgetPassword/otp-match',[UserRegistrationController::class,'otpMatch']);
Route::post('forgetPassword/password-update',[UserRegistrationController::class,'passwordUpdate']);

# terms conditions
Route::get('/terms/conditions',[TermConditionsController::class, 'apiTermsConditions']);

