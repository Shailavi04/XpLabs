<?php

use App\Http\Controllers\Admin\AnnoucementController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\InstructorController as AdminInstructorController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\OfflineExamController;
use App\Http\Controllers\Admin\OnlineExamController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\Studymaterialcontroller;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserControlller;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController\AboutusController;
use App\Http\Controllers\WebsiteController\BannerController;
use App\Http\Controllers\WebsiteController\CertificateController;
use App\Http\Controllers\WebsiteController\CompaniesController;
use App\Http\Controllers\WebsiteController\ContactUsController;
use App\Http\Controllers\WebsiteController\FAQController;
use App\Http\Controllers\WebsiteController\InstructorController;
use App\Http\Controllers\WebsiteController\JoinCommunityController;
use App\Http\Controllers\WebsiteController\ProfessionalController;
use App\Http\Controllers\WebsiteController\TestimonialController;
use App\Http\Controllers\WebsiteController\VisionController;
use App\Http\Controllers\WebsiteController\WhyChooseUsController;
use App\Models\Transactions;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('admin.dashboard.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [UserControlller::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'admin'])->group(function () {



    Route::prefix('website_frontend')->name('web_pages.')->group(function () {
        Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
        Route::get('section/{key}', [FrontendController::class, 'showSection'])->name('frontend.section');

        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');       // List
            Route::get('create', [BannerController::class, 'create'])->name('create'); // Create form
            Route::post('store', [BannerController::class, 'store'])->name('store');   // Store
            Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit');  // Edit form
            Route::post('update/{id}', [BannerController::class, 'update'])->name('update'); // Update
            Route::post('destroy/{id}', [BannerController::class, 'destroy'])->name('destroy'); // Delete - use POST for delete
        });

        Route::prefix('vision')->name('vision.')->group(function () {
            Route::get('/', [VisionController::class, 'index'])->name('index');
            Route::get('create', [VisionController::class, 'create'])->name('create');
            Route::post('store', [VisionController::class, 'store'])->name('store');
            Route::get('edit/{id}', [VisionController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [VisionController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [VisionController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('about_us')->name('about_us.')->group(function () {
            Route::get('/', [AboutusController::class, 'index'])->name('index');
            Route::get('show/{id}', [AboutUsController::class, 'show'])->name('show');
            Route::get('edit/{id}', [AboutUsController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AboutUsController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [AboutUsController::class, 'destroy'])->name('destroy');
            Route::post('store', [AboutUsController::class, 'store'])->name('store');
        });

        Route::prefix('professional')->name('professional.')->group(function () {
            Route::get('/', [ProfessionalController::class, 'index'])->name('index');
            Route::get('create', [ProfessionalController::class, 'create'])->name('create');
            Route::post('store', [ProfessionalController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ProfessionalController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [ProfessionalController::class, 'update'])->name('update');
            Route::post('delete/{id}', [ProfessionalController::class, 'destroy'])->name('destroy');
        });


        Route::prefix('why_choose_us')->name('why_choose_us.')->group(function () {
            Route::get('/', [WhyChooseUsController::class, 'index'])->name('index');
            Route::post('store', [WhyChooseUsController::class, 'store'])->name('store');
            Route::get('edit/{id}', [WhyChooseUsController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [WhyChooseUsController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [WhyChooseUsController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('Instructor')->name('Instructor.')->group(function () {
            Route::get('/', [InstructorController::class, 'index'])->name('index');
            Route::post('store', [InstructorController::class, 'store'])->name('store');
            Route::get('edit/{id}', [InstructorController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [InstructorController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [InstructorController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', [CompaniesController::class, 'index'])->name('index');
            Route::post('store', [CompaniesController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CompaniesController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CompaniesController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [CompaniesController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('certificate')->name('certificate.')->group(function () {
            Route::get('/', [CertificateController::class, 'index'])->name('index');
            Route::post('store', [CertificateController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CertificateController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CertificateController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [CertificateController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('community')->name('community.')->group(function () {
            Route::get('/', [JoinCommunityController::class, 'index'])->name('index');
            Route::post('store', [JoinCommunityController::class, 'store'])->name('store');
            Route::get('edit/{id}', [JoinCommunityController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [JoinCommunityController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [JoinCommunityController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('testimonial')->name('testimonial.')->group(function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('index');
            Route::post('store', [TestimonialController::class, 'store'])->name('store');
            Route::get('edit/{id}', [TestimonialController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [TestimonialController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [TestimonialController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactUsController::class, 'index'])->name('index');
            Route::post('store', [ContactUsController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ContactUsController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [ContactUsController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [ContactUsController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/', [FAQController::class, 'index'])->name('index');
            Route::post('store', [FAQController::class, 'store'])->name('store');
            Route::get('edit/{id}', [FAQController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [FAQController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [FAQController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/categories/data', [CategoryController::class, 'data'])->name('data');
    });



    Route::prefix('student')->name('student.')->group(function () {
        Route::get('index', [StudentController::class, 'index'])->name('index');
        Route::get('create', [StudentController::class, 'create'])->name('create');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StudentController::class, 'update'])->name('update');
        Route::post('/profile_update/{id}', [StudentController::class, 'profile_update'])->name('profile_update');

        Route::post('/destroy/{id}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('view/{id}', [StudentController::class, 'view'])->name('view');

        Route::get('/students/data', [StudentController::class, 'getData'])->name('data');
        // Toggle student status (common)
        Route::get('/status/{id}', [StudentController::class, 'toggleStatus'])->name('status');
    });

    Route::prefix('course')->name('course.')->group(function () {
        Route::get('index', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/store', [CourseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CourseController::class, 'update'])->name('update');
        Route::post('/destroy/{id}', [CourseController::class, 'destroy'])->name('destroy');
        Route::post('/show/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/show/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/courses/data', [CourseController::class, 'data'])->name('data');
        Route::get('/courses/{id}/students-list', [CourseController::class, 'studentsList'])->name('students_list');
        Route::get('/courses/{id}/students-list/data', [CourseController::class, 'studentsListData'])->name('students_list.data');
    });

    Route::prefix('enrollment')->name('enrollment.')->group(function () {
        Route::get('index', [EnrollmentController::class, 'index'])->name('index');
        Route::get('create', [EnrollmentController::class, 'create'])->name('create');
        Route::post('store', [EnrollmentController::class, 'store'])->name('store');
        Route::post('data', [EnrollmentController::class, 'data'])->name('data');
        Route::get('edit/{id}', [EnrollmentController::class, 'edit'])->name('edit');
        Route::post('destroy/{id}', [EnrollmentController::class, 'destroy'])->name('destroy');
        Route::post('updates/{id}', [EnrollmentController::class, 'update'])->name('updates');

        Route::post('/update/{id}', [CourseController::class, 'update'])->name('update');
        Route::get('/enrollment/lifecycle', [EnrollmentController::class, 'lifecycle'])->name('lifecycle');
        Route::post('/enrollment/lifecycle/data', [EnrollmentController::class, 'lifecycleData'])->name('lifecycle.data');
        Route::post('/update-status', [EnrollmentController::class, 'updateStatus'])->name('update_status');
        Route::get('/enrollment/{id}', [EnrollmentController::class, 'show'])->name('show');
        Route::get('center-by-course', [EnrollmentController::class, 'getCoursesByCenter'])->name('center.by.course'); // <-- Added

    });

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('create', [TransactionController::class, 'create'])->name('create');
        Route::post('store', [TransactionController::class, 'store'])->name('store');
        Route::get('/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
    });
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('index', [PaymentController::class, 'index'])->name('index');
        Route::get('create', [PaymentController::class, 'create'])->name('create');
        Route::post('store', [PaymentController::class, 'store'])->name('store');
        Route::get('/{id}', [PaymentController::class, 'edit'])->name('transaction.edit');
        Route::post('destroy/{id}', [PaymentController::class, 'destroy'])->name('destroy');
        Route::get('/payment/data', [PaymentController::class, 'data'])->name('data');
        Route::post('payment/fetch-enrollment', [PaymentController::class, 'fetchEnrollment'])->name('fetchEnrollment');
    });


    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index');  // /quiz
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');  // /quiz/questions
        Route::get('/mapping', [QuizController::class, 'index'])->name('mapping.index');  // /quiz/mapping
        Route::post('/questions/generate-ai', [QuestionController::class, 'generateFromAI'])
            ->name('questions.generate.ai');
        Route::post('questions/store', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/edit/{id}', [QuestionController::class, 'update'])->name('questions.update');
        Route::get('/data', [QuestionController::class, 'data'])->name('questions.data');
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/create', [QuizController::class, 'create'])->name('create');
        Route::post('/store', [QuizController::class, 'store'])->name('store');
        Route::get('/quiz_data', [QuizController::class, 'quiz_data'])->name('quiz_data');
        Route::get('/edit/{id}', [QuizController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [QuizController::class, 'update'])->name('update');
        Route::post('/destroy/{id}', [QuizController::class, 'destroy'])->name('questions.destroy');
        Route::post('/quiz_destroy/{id}', [QuizController::class, 'destroy'])->name('quiz_destroy');
        Route::get('/play/{id}', [QuizController::class, 'play'])->name('play');
        Route::post('/submit', [QuizController::class, 'submitQuiz'])->name('submit');
        Route::get('/result/{id}', [QuizController::class, 'quizResult'])->name('result');
        Route::get('/certificate/{id}', [QuizController::class, 'downloadCertificate'])->name('download.certificate');
    });


    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassesController::class, 'index'])->name('index');
        Route::post('store', [ClassesController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ClassesController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ClassesController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ClassesController::class, 'destroy'])->name('destroy');
        Route::post('assign/{id}', [ClassesController::class, 'assignStaff'])->name('assign');
        Route::get('data', [ClassesController::class, 'data'])->name('data');
    });
    Route::prefix('student_instructors')->name('student_instructors.')->group(function () {
        Route::get('/', [AdminInstructorController::class, 'index'])->name('index');
        Route::post('store', [AdminInstructorController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AdminInstructorController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AdminInstructorController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [AdminInstructorController::class, 'destroy'])->name('destroy');
        Route::get('instructor_data', [AdminInstructorController::class, 'instructor_data'])->name('instructor_data');
    });
    Route::prefix('batch')->name('batch.')->group(function () {
        Route::get('/', [BatchController::class, 'index'])->name('index');
        Route::post('store', [BatchController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BatchController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [BatchController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [BatchController::class, 'destroy'])->name('destroy');
        Route::get('data', [BatchController::class, 'data'])->name('data');
    });
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('store', [AttendanceController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AttendanceController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [AttendanceController::class, 'destroy'])->name('destroy');
        Route::get('data', [AttendanceController::class, 'data'])->name('data');
    });

    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('index');
        Route::get('/create', [ModuleController::class, 'create'])->name('create');
        Route::post('store', [ModuleController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ModuleController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ModuleController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ModuleController::class, 'destroy'])->name('destroy');
        Route::get('data', [ModuleController::class, 'data'])->name('data');
    });
    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('store', [PermissionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PermissionController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [PermissionController::class, 'destroy'])->name('destroy');
        Route::get('data', [PermissionController::class, 'data'])->name('data');
    });


    Route::prefix('role')->name('role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('data', [RoleController::class, 'data'])->name('data');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserControlller::class, 'index'])->name('index');
        Route::get('/create', [UserControlller::class, 'create'])->name('create');
        Route::post('store', [UserControlller::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserControlller::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserControlller::class, 'update'])->name('update');
        Route::post('profile_update/{id}', [UserControlller::class, 'profile_update'])->name('profile_update');
        Route::post('destroy/{id}', [UserControlller::class, 'destroy'])->name('destroy');
        Route::get('profile/{id}', [UserControlller::class, 'profile'])->name('profile');
        Route::get('data', [UserControlller::class, 'data'])->name('data');
    });


    Route::prefix('assignment')->name('assignment.')->group(function () {
        // Assignment CRUD
        Route::get('/', [AssignmentController::class, 'index'])->name('index');
        Route::get('/create', [AssignmentController::class, 'create'])->name('create');
        Route::post('/store', [AssignmentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AssignmentController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AssignmentController::class, 'update'])->name('update');
        Route::post('/destroy/{id}', [AssignmentController::class, 'destroy'])->name('destroy');
        Route::get('/data', [AssignmentController::class, 'data'])->name('data');

        // Assignment submissions
        Route::get('/submit/{id}', [AssignmentSubmissionController::class, 'submitForm'])->name('submit');
        Route::post('/submit/{id}', [AssignmentSubmissionController::class, 'submit'])->name('submit.store');
        Route::get('/submissions/{id}', [AssignmentSubmissionController::class, 'index'])->name('submission.index'); // page
        Route::get('/submissions/{id}/data', [AssignmentSubmissionController::class, 'submissionData'])->name('submission.data'); // datatable ajax
    });

    Route::prefix('exam_online')->name('exam_online.')->group(function () {
        Route::get('/', [OnlineExamController::class, 'index'])->name('index');
        Route::get('/create', [OnlineExamController::class, 'create'])->name('create');
        Route::post('store', [OnlineExamController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OnlineExamController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [OnlineExamController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [OnlineExamController::class, 'destroy'])->name('destroy');
        Route::get('data', [OnlineExamController::class, 'data'])->name('data');
    });
    Route::prefix('exam_offline')->name('exam_offline.')->group(function () {
        Route::get('/', [OfflineExamController::class, 'index'])->name('index');
        Route::get('/create', [OfflineExamController::class, 'create'])->name('create');
        Route::post('store', [OfflineExamController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OfflineExamController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [OfflineExamController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [OfflineExamController::class, 'destroy'])->name('destroy');
        Route::get('data', [OfflineExamController::class, 'data'])->name('data');
    });
    Route::prefix('classroom')->name('classroom.')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('index');
        Route::get('/create', [ClassroomController::class, 'create'])->name('create');
        Route::post('store', [ClassroomController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ClassroomController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ClassroomController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ClassroomController::class, 'destroy'])->name('destroy');
        Route::get('data', [ClassroomController::class, 'data'])->name('data');
    });

    Route::prefix('bank_account')->name('bank_account.')->group(function () {
        Route::get('/', [BankController::class, 'index'])->name('index');
        Route::get('/create', [BankController::class, 'create'])->name('create');
        Route::post('store', [BankController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BankController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [BankController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [BankController::class, 'destroy'])->name('destroy');
        Route::get('data', [BankController::class, 'data'])->name('data');
    });


    Route::prefix('annoucement')->name('annoucement.')->group(function () {
        Route::get('/', [AnnoucementController::class, 'index'])->name('index');
        Route::get('/create', [AnnoucementController::class, 'create'])->name('create');
        Route::post('store', [AnnoucementController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AnnoucementController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AnnoucementController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [AnnoucementController::class, 'destroy'])->name('destroy');
        Route::get('data', [AnnoucementController::class, 'data'])->name('data');
    });
    Route::prefix('study_material')->name('study_material.')->group(function () {
        Route::get('/', [Studymaterialcontroller::class, 'index'])->name('index');
        Route::get('/create', [Studymaterialcontroller::class, 'create'])->name('create');
        Route::post('store', [Studymaterialcontroller::class, 'store'])->name('store');
        Route::get('edit/{id}', [Studymaterialcontroller::class, 'edit'])->name('edit');
        Route::post('update/{id}', [Studymaterialcontroller::class, 'update'])->name('update');
        Route::post('destroy/{id}', [Studymaterialcontroller::class, 'destroy'])->name('destroy');
        Route::get('data', [Studymaterialcontroller::class, 'data'])->name('data');
        Route::get('getBatchesRoute', [Studymaterialcontroller::class, 'getBatchesByCourse'])->name('getBatchesRoute');
    });

    //testing map
    Route::get('/classroom/map', [ClassroomController::class, 'map'])->name('classroom.map');





    // Vision section routes

});

require __DIR__ . '/auth.php';
