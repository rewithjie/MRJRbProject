<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;


// Home redirect behavior for authenticated/guest users
Route::get('/', function () {
    if (session()->has('student_id')) {
        return redirect()->route('student.home');
    }

    if (session()->has('teacher_id')) {
        return redirect()->route('teacher.home');
    }

    if (session()->has('admin_id')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('student.login.show');
})->name('home');

Route::get('/home', function () {
    if (session()->has('student_id')) {
        return redirect()->route('student.home');
    }

    if (session()->has('teacher_id')) {
        return redirect()->route('teacher.home');
    }

    if (session()->has('admin_id')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('student.login.show');
});

Route::get('/hi', function () {
    return "hi laravel development!";
})->name('hi');

//Route::get('/greet/{fname?}/message/{msg?}', function ($name="User", $msg="hello") {
//    return "welcome" .$name." to laravel Application Development
//})->name('greet');

//Route::get('/home', function () {
//return "home nga";
//})->name('homeRoute');

//Route::get('/redirect', function () {
// return redirect()->route("homeRoute");
//})->name('redirectRoute');

//Route::get('/search'/{id}, function ($id) {
//    return "ID: ".$id;
//})->name("searchRoute")->where("id"), "[0-9]+");

//Route::get('/admin/dashboard', function () {
// return "This is the dashboard page for admin!";
//});

//Route::get('/admin/profile', function () {
//    return "This is the profile page for admin!";
//});

//Route::get('/admin/configuration', function () {
//    return "This is the settings page for admin!";
//});


//Route::prefix('admin')->group(
//fucntion(){

//
//);


//Task 1: Creating Named Routes

/*Route::get('/home', function () {
return "I am Rosario, Mark Rejie J. Welcome to Home Page!";
})->name('home.page');

//Task 2: Using Named Routes

Route::get('/redirect-home', function () {
    return redirect()->route('home.page');
})->name('redirectHome');

Route::get('/redirect/redirect-home', function () {
 return redirect()->route("home.page");
})->name('redirectRoute');

// Task 3: Required Route Parameter
Route::get('/greet/{name}', function ($name) {
    return "Hello, " . $name;
})->name('greet');

//Task 4: Optional Route Parameter
Route::get('/student/{name?}', function ($name = 'student') {
    return "hello " . $name;
})->name('student');

// Task 5: Route Group with Prefix
Route::prefix('administrator')->group(function () {
    Route::get('/dashboard', function () {
        return "This is the dashboard page for administrator!";
    })->name('adminDashboard');

    Route::get('/profile', function () {
        return "This is the profile page for administrator!";
    })->name('adminProfile');

    Route::get('/settings', function () {
        return "This is the settings page for administrator!";
    })->name('adminSettings');
});

//Task 6: redirect on route group
Route::get('/redirect-admin-dashboard', function () {
    return redirect()->route('adminDashboard');
})->name('redirectAdminDashboard');*/

/*Route::get('/', function () {
    return "welcome to laravel development!";
});


Route::get('/add', [CalculateController::class, 'add'])->name("add"); 

Route::get('/subtract', [CalculateController::class, 'subtract'])->name("subtract");

Route::get('/multiply', [CalculateController::class, 'multiply'])->name("multiply");

Route::get('/divide', [CalculateController::class, 'divide'])->name("divide");

Route::get('/modulo', [CalculateController::class, 'modulo'])->name("modulo");


Route::resource('clients', ClientController::class);*/

Route::get('/psu/welcome', [PSUController::class, 'welcome'])->name('psu.welcome');
Route::get('/psu/mission', [PSUController::class, 'mission'])->name('psu.mission');
Route::get('/psu/vision', [PSUController::class, 'vision'])->name('psu.vision');
Route::get('/psu/eoms-policy', [PSUController::class, 'EOMSPolicy'])->name('psu.eoms.policy');

Route::get('/greetings',[ClientController::class, 'displayGreetings']);

Route::get('/about',[StudentController::class, 'about'])->name('about');

Route::resource('degrees', DegreeController::class);

Route::get('/user_profile', [PageController::class, 'userProfile'])->name('user.profile');
Route::get('/user_posts', [PageController::class, 'userPosts']);
Route::get('/student__courses', [PageController::class, 'studentCourse']);
Route::get('/enrolled-students', [PageController::class, 'enrolledStudents']);
Route::get('/setup-test-data', [PageController::class, 'setupTestData']);
Route::get('/logs', [PageController::class, 'logs'])->name('logs');

Route::middleware(['student.auth', 'no.cache'])->group(function () {
    Route::resource('students', StudentController::class);
});

// Route::middleware('group')->group(function(){
// Route::get('/about',[StudentController::class, 'about'])->name('about');
// Route::get('/user_profile', [PageController::class, 'userProfile'])->name('user.profile');
// Route::get('/user_posts', [PageController::class, 'userPosts']);
// });

Route::middleware('no.cache')->group(function () {
    Route::get('/student/login', [AuthController::class, 'showLogin'])->name('student.login.show');
    Route::post('/student/login', [AuthController::class, 'login'])->name('student.login');
});

Route::middleware(['student.auth', 'no.cache'])->group(function () {
    Route::get('/student/dashboard', [AuthController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/new-dashboard', [AuthController::class, 'dashboard'])->name('student.new.dashboard');
    Route::get('/student/home-dashboard', [AuthController::class, 'homeDashboard'])->name('student.home');
    Route::post('/student/change-password', [AuthController::class, 'changePassword'])->name('student.password.update');
    Route::post('/student/logout', [AuthController::class, 'logout'])->name('student.logout');
});

// ============== TEACHER ROUTES ==============
Route::middleware('no.cache')->group(function () {
    Route::get('/teacher/login', [TeacherController::class, 'showLogin'])->name('teacher.login.show');
    Route::post('/teacher/login', [TeacherController::class, 'login'])->name('teacher.login');
});

Route::middleware(['teacher.auth', 'no.cache'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/home', [TeacherController::class, 'homeDashboard'])->name('teacher.home');
    Route::post('/teacher/change-password', [TeacherController::class, 'changePassword'])->name('teacher.password.update');
    Route::post('/teacher/logout', [TeacherController::class, 'logout'])->name('teacher.logout');
});

// ============== ADMIN ROUTES ==============
Route::middleware('no.cache')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login.show');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
});

Route::middleware(['admin.auth', 'no.cache'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Student Management
    Route::get('/admin/students', [AdminController::class, 'manageStudents'])->name('admin.manage.students');
    Route::get('/admin/students/add', [AdminController::class, 'addStudentForm'])->name('admin.add.student');
    Route::post('/admin/students/store', [AdminController::class, 'storeStudent'])->name('admin.store.student');
    Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.delete.student');
    
    // Teacher Management
    Route::get('/admin/teachers', [AdminController::class, 'manageTeachers'])->name('admin.manage.teachers');
    Route::get('/admin/teachers/add', [AdminController::class, 'addTeacherForm'])->name('admin.add.teacher');
    Route::post('/admin/teachers/store', [AdminController::class, 'storeTeacher'])->name('admin.store.teacher');
    Route::delete('/admin/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('admin.delete.teacher');
    
    // Admin Account
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.password.update');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::any('/student/{any}', function () {
    if (session()->has('student_id')) {
        return redirect()->route('student.home');
    }

    return redirect()->route('student.login.show');
})->where('any', '.*');

Route::any('/teacher/{any}', function () {
    if (session()->has('teacher_id')) {
        return redirect()->route('teacher.home');
    }

    return redirect()->route('teacher.login.show');
})->where('any', '.*');

Route::any('/admin/{any}', function () {
    if (session()->has('admin_id')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('admin.login.show');
})->where('any', '.*');
