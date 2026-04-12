<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PageController;


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

Route::get('/',[StudentController::class, 'home'])->name('home');
Route::get('/about',[StudentController::class, 'about'])->name('about');

Route::resource('students', StudentController::class);
Route::resource('degrees', DegreeController::class);

Route::get('/user_profile', [PageController::class, 'userProfile'])->name('user.profile');
Route::get('/user_posts', [PageController::class, 'userPosts']);
Route::get('/student__courses', [PageController::class, 'studentCourse']);
Route::get('/enrolled-students', [PageController::class, 'enrolledStudents']);
Route::get('/setup-test-data', [PageController::class, 'setupTestData']);
