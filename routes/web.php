<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\UserController as UserDashboardController;
use App\Http\Controllers\Client\AuthController as ClientAuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (auth('admin')->check() && auth('admin')->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'adminLogin']);
});

Route::prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->role === 'instructor') {
            return redirect()->route('instructor.dashboard');
        }
        return redirect()->route('login');
    });

    Route::get('/login', function () {
        return redirect()->route('login');
    })->name('login');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showUserLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'userLogin']);

Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::match(['get', 'post'], '/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::post('/password/send-otp', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendOtp'])->name('password.send-otp');
Route::post('/password/verify-otp', [\App\Http\Controllers\Auth\PasswordResetController::class, 'verifyOtp'])->name('password.verify-otp');
Route::post('/password/reset', [\App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.reset');

Route::prefix('api/regions')->name('api.regions.')->group(function () {
    Route::get('/provinces', [\App\Http\Controllers\RegionController::class, 'getProvinces'])->name('provinces');
    Route::get('/kabupaten-kota/{provinceId}', [\App\Http\Controllers\RegionController::class, 'getKabupatenKota'])->name('kabupaten-kota');
    Route::get('/kecamatan/{kabupatenId}', [\App\Http\Controllers\RegionController::class, 'getKecamatan'])->name('kecamatan');
    Route::get('/kelurahan/{kecamatanId}', [\App\Http\Controllers\RegionController::class, 'getKelurahan'])->name('kelurahan');
});

Route::prefix('admin')->name('admin.')->middleware([\App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('admins', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admins.index');
    Route::get('admins/create', [\App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admins.create');
    Route::post('admins', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admins.store');
    Route::get('admins/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('admins.edit');
    Route::put('admins/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'update'])->name('admins.update');
    Route::delete('admins/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admins.destroy');

    Route::resource('programs', \App\Http\Controllers\Admin\ProgramController::class);
    Route::get('training-bookings', [\App\Http\Controllers\Admin\TrainingBookingController::class, 'index'])->name('training-bookings.index');
    Route::post('training-bookings/{trainingBooking}/approve', [\App\Http\Controllers\Admin\TrainingBookingController::class, 'approve'])->name('training-bookings.approve');
    Route::post('training-bookings/{trainingBooking}/reject', [\App\Http\Controllers\Admin\TrainingBookingController::class, 'reject'])->name('training-bookings.reject');

    Route::prefix('programs/{program}/lms')->name('programs.lms.')->group(function () {
        Route::get('sections', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'index'])->name('sections.index');
        Route::post('sections', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'storeSection'])->name('sections.store');
        Route::put('sections/{section}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'updateSection'])->name('sections.update');
        Route::delete('sections/{section}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'destroySection'])->name('sections.destroy');
        Route::post('sections/reorder', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'reorderSections'])->name('sections.reorder');

        Route::post('sections/{section}/lessons', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'storeLesson'])->name('lessons.store');
        Route::put('sections/{section}/lessons/{lesson}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('sections/{section}/lessons/{lesson}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'destroyLesson'])->name('lessons.destroy');
        Route::post('sections/{section}/lessons/reorder', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'reorderLessons'])->name('lessons.reorder');

        Route::get('assignments', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'index'])->name('assignments.index');
        Route::post('assignments', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'store'])->name('assignments.store');
        Route::put('assignments/{assignment}', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('assignments/{assignment}', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'destroy'])->name('assignments.destroy');

        Route::get('submissions', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'show'])->name('submissions.show');
        Route::post('submissions/{submission}/grade', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'grade'])->name('submissions.grade');
    });

    Route::get('program-approvals', [\App\Http\Controllers\Admin\ProgramApprovalController::class, 'index'])->name('program-approvals.index');
    Route::get('program-approvals/{id}', [\App\Http\Controllers\Admin\ProgramApprovalController::class, 'show'])->name('program-approvals.show');
    Route::post('program-approvals/{id}/approve', [\App\Http\Controllers\Admin\ProgramApprovalController::class, 'approve'])->name('program-approvals.approve');
    Route::post('program-approvals/{id}/reject', [\App\Http\Controllers\Admin\ProgramApprovalController::class, 'reject'])->name('program-approvals.reject');
    Route::post('program-approvals/bulk-update', [\App\Http\Controllers\Admin\ProgramApprovalController::class, 'bulkUpdate'])->name('program-approvals.bulk-update');

    Route::get('instructor-applications', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'index'])->name('instructor-applications.index');
    Route::get('instructor-applications/{id}', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'show'])->name('instructor-applications.show');
    Route::post('instructor-applications/{id}/approve', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'approve'])->name('instructor-applications.approve');
    Route::post('instructor-applications/{id}/reject', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'reject'])->name('instructor-applications.reject');
    Route::delete('instructor-applications/{id}', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'destroy'])->name('instructor-applications.destroy');
    Route::get('instructor-applications/{id}/document/{type}', [\App\Http\Controllers\Admin\InstructorApplicationController::class, 'downloadDocument'])->name('instructor-applications.download');

    Route::get('instructors', [\App\Http\Controllers\Admin\InstructorController::class, 'index'])->name('instructors.index');
    Route::get('instructors/create', [\App\Http\Controllers\Admin\InstructorController::class, 'create'])->name('instructors.create');
    Route::post('instructors', [\App\Http\Controllers\Admin\InstructorController::class, 'store'])->name('instructors.store');
    Route::get('instructors/{id}', [\App\Http\Controllers\Admin\InstructorController::class, 'show'])->name('instructors.show');
    Route::get('instructors/{id}/edit', [\App\Http\Controllers\Admin\InstructorController::class, 'edit'])->name('instructors.edit');
    Route::put('instructors/{id}', [\App\Http\Controllers\Admin\InstructorController::class, 'update'])->name('instructors.update');

    Route::post('instructors/{id}/approve', [\App\Http\Controllers\Admin\InstructorController::class, 'approve'])->name('instructors.approve');
    Route::post('instructors/{id}/reject', [\App\Http\Controllers\Admin\InstructorController::class, 'reject'])->name('instructors.reject');
    Route::delete('instructors/{id}', [\App\Http\Controllers\Admin\InstructorController::class, 'destroy'])->name('instructors.destroy');
    Route::get('instructors/{id}/document/{type}', [\App\Http\Controllers\Admin\InstructorController::class, 'downloadDocument'])->name('instructors.download');

    Route::get('program-proofs', [\App\Http\Controllers\Admin\ProgramProofController::class, 'index'])->name('program-proofs.index');
    Route::get('program-proofs/{id}', [\App\Http\Controllers\Admin\ProgramProofController::class, 'show'])->name('program-proofs.show');
    Route::post('program-proofs/{id}/accept', [\App\Http\Controllers\Admin\ProgramProofController::class, 'accept'])->name('program-proofs.accept');
    Route::post('program-proofs/{id}/reject', [\App\Http\Controllers\Admin\ProgramProofController::class, 'reject'])->name('program-proofs.reject');
    Route::delete('program-proofs/{id}', [\App\Http\Controllers\Admin\ProgramProofController::class, 'destroy'])->name('program-proofs.destroy');

    Route::post('certificates/preview', [\App\Http\Controllers\Admin\CertificateController::class, 'previewCertificate'])->name('certificates.preview');
    Route::post('certificates/upload-template', [\App\Http\Controllers\Admin\CertificateController::class, 'uploadTemplate'])->name('certificates.upload-template');
    Route::post('certificates/delete-temp', [\App\Http\Controllers\Admin\CertificateController::class, 'deleteTempTemplate'])->name('certificates.delete-temp');
    Route::get('certificates/download-pdf', [\App\Http\Controllers\Admin\CertificateController::class, 'downloadPdf'])->name('certificates.download-pdf');
    Route::get('certificates/{id}/template-image', [\App\Http\Controllers\Admin\CertificateController::class, 'templateImage'])->name('certificates.template-image');
    Route::resource('certificates', \App\Http\Controllers\Admin\CertificateController::class);

    Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class);
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    Route::post('articles/upload-image', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])->name('articles.upload-image');
    Route::resource('broadcasts', \App\Http\Controllers\Admin\BroadcastController::class);
    Route::get('rekap-program', [\App\Http\Controllers\Admin\RekapProgramController::class, 'index'])->name('rekap-program.index');
    Route::get('rekap-program/{slug}', [\App\Http\Controllers\Admin\RekapProgramController::class, 'show'])->name('rekap-program.show');

    Route::get('quizzes', [\App\Http\Controllers\Admin\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('quizzes/create', [\App\Http\Controllers\Admin\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [\App\Http\Controllers\Admin\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{id}/edit', [\App\Http\Controllers\Admin\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('quizzes/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('quizzes/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'destroy'])->name('quizzes.destroy');
});

Route::name('client.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
    Route::post('/contact', [\App\Http\Controllers\Client\HomeController::class, 'sendContact'])->name('contact.send');

    Route::get('/tentang', [\App\Http\Controllers\Client\PageController::class, 'tentang'])->name('tentang');

    Route::prefix('program')->name('program')->group(function () {
        Route::get('/', [\App\Http\Controllers\Client\ProgramController::class, 'index']);

        Route::get('/semua-kelas', [\App\Http\Controllers\Client\ProgramController::class, 'index'])->name('.semua-kelas');

        Route::get('/kursus', [\App\Http\Controllers\Client\ProgramController::class, 'kursus'])->name('.kursus');

        Route::get('/pelatihan', [\App\Http\Controllers\Client\ProgramController::class, 'pelatihan'])->name('.pelatihan');

        Route::get('/go-to-school', [\App\Http\Controllers\Client\ProgramController::class, 'goToSchool'])->name('.go-to-school');

        Route::get('/holiday-program', [\App\Http\Controllers\Client\ProgramController::class, 'holidayProgram'])->name('.holiday-program');

        Route::get('/sertifikasi', [\App\Http\Controllers\Client\ProgramController::class, 'sertifikasi'])->name('.sertifikasi');

        Route::get('/outing-class', [\App\Http\Controllers\Client\ProgramController::class, 'outingClass'])->name('.outing-class');

        Route::get('/outboard', [\App\Http\Controllers\Client\ProgramController::class, 'outboard'])->name('.outboard');

        Route::get('/{slug}', [\App\Http\Controllers\Client\ProgramController::class, 'show'])->name('.detail');
    });


    Route::get('/artikel', [\App\Http\Controllers\Client\ArticleController::class, 'index'])->name('artikel');
    Route::get('/artikel/api', [\App\Http\Controllers\Client\ArticleController::class, 'getArticles'])->name('artikel.api');
    Route::get('/artikel/{slug}', [\App\Http\Controllers\Client\ArticleController::class, 'show'])->name('artikel.detail');

    Route::get('/instruktur', [\App\Http\Controllers\Client\InstructorController::class, 'index'])->name('instruktur');
    Route::get('/galeri', [\App\Http\Controllers\Client\GalleryController::class, 'index'])->name('galeri');

    Route::get('/register', function () {
        return view('client.login.register');
    })->name('register');

    Route::post('/auth/register', [ClientAuthController::class, 'register'])->name('auth.register');

    Route::get('/reset-password', function () {
        return view('client.login.reset');
    })->name('reset-password');

    Route::middleware([\App\Http\Middleware\EnsureUserIsRegularUser::class])->prefix('dashboard')->group(function () {
        Route::get('/', [UserDashboardController::class, 'profile'])->name('dashboard');
        Route::get('/program', [UserDashboardController::class, 'program'])->name('dashboard.program');
        Route::get('/sertifikat', [UserDashboardController::class, 'certificate'])->name('dashboard.certificate');
        Route::get('/sertifikat/{id}/download', [UserDashboardController::class, 'downloadCertificate'])->name('dashboard.certificate.download');
        Route::get('/transaksi', [UserDashboardController::class, 'transaction'])->name('dashboard.transaction');
        Route::get('/voucher', [UserDashboardController::class, 'voucher'])->name('dashboard.voucher');
        Route::get('/notifikasi', [\App\Http\Controllers\Client\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifikasi/{id}/dibaca', [\App\Http\Controllers\Client\NotificationController::class, 'read'])->name('notifications.read');
        Route::post('/notifikasi/dibaca-semua', [\App\Http\Controllers\Client\NotificationController::class, 'readAll'])->name('notifications.read-all');
        Route::delete('/notifikasi/{id}', [\App\Http\Controllers\Client\NotificationController::class, 'destroy'])->name('notifications.destroy');

        Route::put('/avatar', [UserDashboardController::class, 'updateAvatar'])->name('dashboard.update-avatar');
        Route::delete('/avatar', [UserDashboardController::class, 'deleteAvatar'])->name('dashboard.delete-avatar');
        Route::put('/', [UserDashboardController::class, 'updateProfile'])->name('dashboard.update');
        Route::get('/check-username', [UserDashboardController::class, 'checkUsername'])->name('check-username');
        Route::get('/program/{slug}/proof', [\App\Http\Controllers\Client\ProgramProofController::class, 'create'])->name('program.proof');
        Route::post('/program/{slug}/proof', [\App\Http\Controllers\Client\ProgramProofController::class, 'store'])->name('program.proof.store');
        Route::get('/program/{slug}/proof', [\App\Http\Controllers\Client\ProgramProofController::class, 'create'])->name('program.proof');
        Route::post('/program/{slug}/proof', [\App\Http\Controllers\Client\ProgramProofController::class, 'store'])->name('program.proof.store');
    });



    Route::middleware(['auth'])->group(function () {
        Route::get('/pembayaran/{programSlug}', [\App\Http\Controllers\Client\PaymentController::class, 'showPaymentPage'])
            ->name('pembayaran');
        Route::get('/pelatihan/{programSlug}/booking', [\App\Http\Controllers\Client\TrainingBookingController::class, 'create'])
            ->name('training-bookings.create');
        Route::post('/pelatihan/{programSlug}/booking', [\App\Http\Controllers\Client\TrainingBookingController::class, 'store'])
            ->name('training-bookings.store');
        Route::get('/program/{slug}/kelas', [\App\Http\Controllers\Client\ProgramController::class, 'classroom'])
            ->name('program.classroom');
        Route::get('/program/{slug}/kelas/posttest', [\App\Http\Controllers\Client\ProgramController::class, 'posttest'])
            ->name('program.posttest');
        Route::get('/program/{slug}/kelas/selesai', [\App\Http\Controllers\Client\ProgramController::class, 'courseCompleted'])
            ->name('program.course-complete');
        Route::post('/program/{slug}/syllabus/{index}/complete', [\App\Http\Controllers\Client\ProgramController::class, 'markMaterialComplete'])
            ->name('program.syllabus.complete');
        Route::post('/program/{slug}/assignments/{assignment}/submit', [\App\Http\Controllers\Client\CourseAssignmentController::class, 'store'])
            ->name('program.assignment.submit');
        Route::post('/payment/apply-voucher', [\App\Http\Controllers\Client\PaymentController::class, 'applyVoucher'])
            ->name('payment.apply-voucher');
        Route::post('/payment/create', [\App\Http\Controllers\Client\PaymentController::class, 'createTransaction'])
            ->name('payment.create');
        Route::post('/pelatihan/booking/{trainingBooking}/payment/create', [\App\Http\Controllers\Client\PaymentController::class, 'createTrainingTransaction'])
            ->name('training-bookings.payment.create');
        Route::get('/payment/finish', [\App\Http\Controllers\Client\PaymentController::class, 'finish'])
            ->name('payment.finish');

        Route::get('/become-instructor', [\App\Http\Controllers\Client\BecomeInstructorController::class, 'create'])->name('become-instructor');
        Route::post('/become-instructor', [\App\Http\Controllers\Client\BecomeInstructorController::class, 'store'])->name('become-instructor.store');
    });

    Route::post('/api/payment/resume/{transactionId}', [\App\Http\Controllers\Client\PaymentController::class, 'resumePayment'])
        ->middleware('auth')
        ->name('payment.resume');

    Route::post('/api/payment/cancel/{transactionId}', [\App\Http\Controllers\Client\PaymentController::class, 'cancelTransaction'])
        ->middleware('auth')
        ->name('payment.cancel');

    Route::post('/payment/callback', [\App\Http\Controllers\Client\PaymentController::class, 'callback'])
        ->name('payment.callback');

});

Route::prefix('instructor')->name('instructor.')->middleware([\App\Http\Middleware\EnsureUserIsInstructor::class])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Instructor\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\Instructor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Instructor\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('programs', \App\Http\Controllers\Instructor\ProgramController::class);

    Route::get('assignments', [\App\Http\Controllers\Instructor\AssignmentController::class, 'index'])
        ->name('assignments.index');
    Route::get('assignments/posttest-dashboard', [\App\Http\Controllers\Instructor\AssignmentController::class, 'dashboard'])
        ->name('assignments.dashboard');

    Route::prefix('programs/{program}/lms')->name('programs.lms.')->group(function () {
        Route::get('sections', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'index'])->name('sections.index');
        Route::post('sections', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'storeSection'])->name('sections.store');
        Route::put('sections/{section}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'updateSection'])->name('sections.update');
        Route::delete('sections/{section}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'destroySection'])->name('sections.destroy');
        Route::post('sections/reorder', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'reorderSections'])->name('sections.reorder');

        Route::post('sections/{section}/lessons', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'storeLesson'])->name('lessons.store');
        Route::put('sections/{section}/lessons/{lesson}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('sections/{section}/lessons/{lesson}', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'destroyLesson'])->name('lessons.destroy');
        Route::post('sections/{section}/lessons/reorder', [\App\Http\Controllers\Panel\LmsCurriculumController::class, 'reorderLessons'])->name('lessons.reorder');

        Route::get('assignments', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'index'])->name('assignments.index');
        Route::post('assignments', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'store'])->name('assignments.store');
        Route::put('assignments/{assignment}', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('assignments/{assignment}', [\App\Http\Controllers\Panel\LmsAssignmentController::class, 'destroy'])->name('assignments.destroy');

        Route::get('submissions', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'show'])->name('submissions.show');
        Route::post('submissions/{submission}/grade', [\App\Http\Controllers\Panel\LmsSubmissionController::class, 'grade'])->name('submissions.grade');
    });

    Route::get('quizzes', [\App\Http\Controllers\Instructor\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('quizzes/create', [\App\Http\Controllers\Instructor\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [\App\Http\Controllers\Instructor\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{id}', [\App\Http\Controllers\Instructor\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{id}/edit', [\App\Http\Controllers\Instructor\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('quizzes/{id}', [\App\Http\Controllers\Instructor\QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('quizzes/{id}', [\App\Http\Controllers\Instructor\QuizController::class, 'destroy'])->name('quizzes.destroy');
});
