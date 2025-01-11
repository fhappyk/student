<?php

use App\Http\Controllers\SpecialityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\AdminController;

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

// Route::get('/', function () {
//     return view('frontend.viewStudent');
// })->name('home');

Route::post('/change-language', [WebController::class, 'changeLanguage'])->name('change.language');


Route::get('/', [WebController::class, 'home'])->name('home');


Route::get('/students/filter', [WebController::class, 'filterStudents'])->name('students.filter');

Route::prefix('speciality')->name('speciality')->controller(SpecialityController::class)->group(function () {
    Route::get('children/{speciality}', 'children')->name('children');
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions',  PermissionController::class);
});


Route::get('/edit-profile', [WebController::class, 'editProfile'])->name('edit.profile');
Route::post('/update-profile', [WebController::class, 'updateProfile'])->name('update.profile');


Route::get('/view-profile', [WebController::class, 'viewProfile'])->name('view.profile');

Route::get('/view-student/{id}', [WebController::class, 'viewStudent'])->name('view.student');


Route::get('forgot-password/', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot-password-email/', [AuthController::class, 'sendResetLinkEmail'])->name('forgot.password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');




Route::get('/verification/{id}',[AuthController::class,'verification'])->name('account.verification');
//Route::post('/verify/otp/{id}',[AuthController::class,'verifyOtp'])->name('account.verify.otp');
Route::post('/verified',[AuthController::class,'verifiedOtp'])->name('verifiedOtp');
Route::get('/resend-otp',[AuthController::class,'resendOtp'])->name('resendOtp');




// Route::get('forgot-password/', function () {
//     return view('forgotPassword');
// })->name('forgot.password');

Route::get('register/{uuid}/{email}', [AuthController::class, 'viewRegister'])->name('register');
Route::get('login/', [AuthController::class, 'viewLogin'])->name('login');


Route::post('register/', [AuthController::class, 'register'])->name('user.register');
Route::post('login/', [AuthController::class, 'login'])->name('user.login');
Route::get('logout/', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin'], 'as' => 'admin.'], function(){
// routes/web.php

    Route::get('field-student/', [AdminController::class, 'fieldStudent'])->name('field.setting');
    Route::get('dropdown-student/', [AdminController::class, 'dropdownStudent'])->name('dropdown.setting');
    Route::get('delete-dropdown/{id}', [AdminController::class, 'deleteDropdown'])->name('delete.dropdown');
    Route::post('save-speciality-area/', [AdminController::class, 'saveSpecialityArea'])->name('save.speciality.area');
    Route::post('save-speciality/', [AdminController::class, 'saveSpeciality'])->name('save.speciality');

    Route::post('/fields/update-status/{id}', [AdminController::class, 'updateStatus']);


    Route::get('setting/', [AdminController::class, 'setting'])->name('setting');
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('email/', [AdminController::class, 'emailSettings'])->name('email');
        Route::post('testemail/', [AdminController::class, 'testEmailSettings'])->name('testemail');
        Route::get('twilio/', [AdminController::class, 'twilioSettings'])->name('twilio');
        Route::post('save/', [AdminController::class, 'saveSettings'])->name('save');
        Route::get('email-templates', [AdminController::class, 'emailTemplates'])->name('email-templates');
        Route::get('edit-email-template/{id}', [AdminController::class, 'editEmailTemplates'])->name('edit-email-template');
        Route::post('update-email-template', [AdminController::class, 'updateEmailTemplates'])->name('update-email-template');
        Route::post('email-templates', [AdminController::class, 'emailTemplatesPost'])->name('email-templates-post');
    });


    Route::get('invite-student/', [AdminController::class, 'inviteStudent'])->name('invite.student');
    Route::get('create-invite/', [AdminController::class, 'createInvite'])->name('create.invite');
    Route::post('send-invite/', [AdminController::class, 'sendInvite'])->name('send.invite');

    Route::get('delete-invite/{id}', [AdminController::class, 'deleteInvite'])->name('delete.invite');





    Route::post('/import-students', [AdminController::class, 'import'])->name('students.import');
    Route::post('/import-json', [AdminController::class, 'importJson'])->name('import.json');

    Route::get('/export-json', [AdminController::class, 'exportJson'])->name('export.json');


    Route::get('dashboard/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('re-send-pending-emails/', [AdminController::class, 'runQueue'])->name('runQueue');

    Route::get('all-students/', [AdminController::class, 'allStudent'])->name('student');
    Route::get('login-student/{id}', [AdminController::class, 'loginStudent'])->name('login.student');

    Route::get('pending-students/', [AdminController::class, 'pendingStudent'])->name('pending.student');

    Route::get('active-students/', [AdminController::class, 'activeStudent'])->name('active.student');

    Route::get('inactive-students/', [AdminController::class, 'inactiveStudent'])->name('inactive.student');

    Route::get('change-status/{id}/{status}', [AdminController::class, 'changeStatus'])->name('change.status');


    Route::get('create-students/', [AdminController::class, 'createStudent'])->name('create.student');
    Route::post('store-students/', [AdminController::class, 'storeStudent'])->name('store.student');
    Route::post('update-students/', [AdminController::class, 'updateStudent'])->name('update.student');

    Route::get('restore/{id}', [AdminController::class, 'restoreUser'])->name('restore');
    Route::get('trashed', [AdminController::class, 'trashedUsers'])->name('trashed');
    Route::get('delete-trashed/{id}', [AdminController::class, 'forceDelete'])->name('delete.trashed');


    Route::get('view-students/{id}', [AdminController::class, 'viewStudent'])->name('view.student');
    Route::get('edit-students/{id}', [AdminController::class, 'editStudent'])->name('edit.student');
    Route::get('delete-students/{id}', [AdminController::class, 'deleteStudent'])->name('delete.student');







});




