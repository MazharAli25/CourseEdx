<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SliderImageController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\SuperAdmin\CategoriesController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\PrivacyPolicyController;
use App\Http\Controllers\SuperAdmin\SubCategoryController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\CurriculumController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\FAQController;
use App\Http\Controllers\Teacher\LectureMaterialController;
use App\Http\Controllers\Teacher\PricingController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\User\UserController;
use App\Models\SubCategory;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
// email verification
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('testing', 'testing');

Route::get('/', [HomeController::class, 'index'])
    ->middleware('sessionTimeout')
    ->name('home');
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('terms-conditions', [HomeController::class, 'termsConditions'])->name('termsConditions');
Route::get('courses', [UserController::class, 'viewCourses'])->name('user.courses');
Route::get('courses/{course:slug}', [UserController::class, 'courseShow'])->name('user.courseShow');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');
Route::post('contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

Route::view('profile', 'profile')->name('profile')->middleware('auth');

// Route::get('/ask-role', [AuthenticationController::class, 'askRole'])->name('auth.role');
// Route::post('/student-registration', [AuthenticationController::class, 'storeStudent'])->name('register.student');
Route::get('/register', [AuthenticationController::class, 'create'])->name('register');
Route::post('/register', [AuthenticationController::class, 'store'])->name('register.store');
Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/login', [AuthenticationController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification email sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('courses/enroll/{course}', [EnrollmentController::class, 'store'])
        ->name('enroll.store');
});

Route::prefix('super-admin')->middleware(['auth', 'sessionTimeout', 'role:super-admin', 'verified'])->group(function () {
    // SuperAdmin Controller Routes
    Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])->name('super.dashboard');
    Route::get('courses-requests', [SuperAdminDashboardController::class, 'coursesRequests'])->name('super.course-requests');
    Route::post('courses/{course}/approve', [SuperAdminDashboardController::class, 'approveCourse'])->name('super.courses.approve');
    Route::get('courses/{course}/preview', [SuperAdminDashboardController::class, 'previewCourse'])->name('super.preview');
    Route::post('courses/{course}/reject', [SuperAdminDashboardController::class, 'rejectCourse'])->name('super.courses.reject');
    Route::get('registered-users', [SuperAdminDashboardController::class, 'registeredUsers'])->name('super.registeredUsers');
    Route::delete('registered-users/{id}', [SuperAdminDashboardController::class, 'deleteUser'])->name('super.deleteUser');
    Route::post('registered-users/update-status/{id}', [SuperAdminDashboardController::class, 'updateUserStatus'])->name('super.updateUserStatus');
    Route::delete('registered-users/delete/{id}', [SuperAdminDashboardController::class, 'deleteUser'])->name('super.deleteUser');
    Route::post('registered-users/update-role/{id}', [SuperAdminDashboardController::class, 'updateUserRole'])->name('super.updateUserRole');
    // slider images routes
    Route::resource('slider-images', SliderImageController::class);
    Route::post('slider-images/update-status/{id}', [SliderImageController::class, 'updateStatus'])->name('slider-images.updateStatus');
    // social links routes
    Route::resource('social-links', SocialLinkController::class);
    Route::post('social-links/update-status/{id}', [SocialLinkController::class, 'updateStatus'])->name('social-links.updateStatus');
    // system settings routes
    Route::get('system-settings', [SystemSettingController::class, 'homeCustomization'])->name('super.homeCustomization');
    Route::post('system-settings', [SystemSettingController::class, 'homeCustomizationUpdate'])->name('super.homeCustomizationUpdate');
    // privacy policy routes
    Route::resource('privacy-policy', PrivacyPolicyController::class);
    Route::post('privacy-policy/update-status/{id}', [PrivacyPolicyController::class, 'updateStatus'])->name('privacy.updateStatus');
    // categories routes
    Route::resource('category', CategoriesController::class);
    // subcategories routes
    Route::resource('sub-category', SubCategoryController::class);
});

Route::prefix('teacher')->middleware(['auth', 'sessionTimeout', 'role:teacher', 'verified'])->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('courses/enrollments', [TeacherDashboardController::class, 'enrollmentsList'])->name('courses.enrollments');
    Route::resource('course', CourseController::class);
    Route::get('/get-subcategories/{category}', function ($category) {
        return SubCategory::where('categoryId', $category)
            ->select('id', 'name')
            ->get();
    });
    Route::post('/lectures/{lecture}/remove-video', [CurriculumController::class, 'removeVideo'])
        ->name('lectures.remove-video');
    Route::post('/course/{section}/remove-section', [CurriculumController::class, 'removeSection'])
        ->name('lectures.remove-section');
    Route::post('lectures/{lecture}/remove-lecture', [CurriculumController::class, 'removeLecture'])->name('lectures.remove-lecture');

    Route::prefix('/courses/{course}')->group(function () {
        Route::get('basic-info', [CourseController::class, 'basicInfo'])->name('courses.basic');
        Route::get('curriculum', [CurriculumController::class, 'curriculum'])->name('courses.curriculum');
        Route::post('curriculumStore', [CurriculumController::class, 'curriculumStore'])->name('store.curriculum');
        Route::get('requirements', [CourseController::class, 'requirements'])->name('courses.requirements');
        Route::get('preview', [CourseController::class, 'preview'])->name('course.preview');
        Route::post('pendingStatus', [CourseController::class, 'pendingStatus'])->name('course.pending');
        Route::resource('faq', FAQController::class);
        Route::resource('pricing', PricingController::class);

        Route::get('publish', [CourseController::class, 'publish'])->name('courses.publish');
    });

    Route::name('teacher.')->group(function () {
        Route::resource('profile', TeacherProfileController::class);
    });

    // lecture materials page (shows all lectures materials)
    Route::get('courses/{course}/materials', [LectureMaterialController::class, 'index'])
        ->name('courses.materials');

    // Bulk upload for lecture materials page
    Route::post('lectures/{course}/materials', [LectureMaterialController::class, 'store'])
        ->name('courses.materials.store');

    // Material operations
    Route::prefix('materials/{material}')->group(function () {
        Route::delete('/', [LectureMaterialController::class, 'destroy'])
            ->name('materials.destroy');

        Route::put('/', [LectureMaterialController::class, 'update'])
            ->name('materials.update');

        Route::get('download', [LectureMaterialController::class, 'download'])
            ->name('materials.download');
    });
});

Route::prefix('student')->middleware(['auth', 'sessionTimeout', 'role:student', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    // Learning / Video Player
    Route::get('/learning/{course:slug}', [StudentDashboardController::class, 'learning'])->name('student.learning');

    // ============ NEW ROUTES FOR PROGRESS TRACKING ============
    // Mark a lecture as complete (AJAX)
    Route::post('/lecture/{lecture}/complete', [StudentDashboardController::class, 'markLectureComplete'])
        ->name('student.lecture.complete');

    // Track video watch progress (AJAX - optional)
    Route::post('/lecture/{lecture}/progress', [StudentDashboardController::class, 'trackProgress'])
        ->name('student.lecture.progress');
    // ==========================================================

    // Student Profile (keep as is)
    Route::name('student.')
        ->group(function () {
            Route::resource('profile', StudentProfileController::class);
        });
});

// ########### EMAIL #################

// Notice page (after login, before verification)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Verification link (from email)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    $user = $request->user();
    if ($user->role === 'super-admin') {
        return redirect()->route('super.dashboard')->with('success', 'Your email has been verified!');
    } elseif ($user->role === 'teacher') {
        return redirect()->route('teacher.dashboard')->with('success', 'Your email has been verified!');
    } else {
        return redirect()->route('student.dashboard')->with('success', 'Your email has been verified!');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

// $2y$12$MGUKRihIe1HCL1CKvl6da.QsRA7Hd/J9W540JOHYl8SEN5nUUqzh.
