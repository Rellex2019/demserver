<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamFolderController;
use App\Http\Controllers\ExaminerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Auth\User;

Route::get('/', function () {
    return redirect('/login');
});


// Авторизация
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    
    // Студенты
    Route::get('/admin/students', [AdminController::class, 'showStudents'])->name('admin.students');
    Route::get('/admin/students/add', [AdminController::class, 'showAddStudentForm'])->name('admin.students.add');
    Route::post('/admin/students/add', [AdminController::class, 'addStudent']);
    Route::get('/admin/students/{user_id}/edit', [AdminController::class, 'showEditStudentForm'])->name('admin.students.edit');
    Route::put('/admin/students/{user_id}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/admin/students/{user_id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');

    // Экзаменаторы
    Route::get('/admin/examiners', [AdminController::class, 'examinersIndex'])->name('admin.examiners');
    Route::get('/admin/examiners/create', [AdminController::class, 'examinersCreate'])->name('admin.examiners.create');
    Route::post('/admin/examiners', [AdminController::class, 'examinersStore'])->name('admin.examiners.store');
    Route::get('/admin/examiners/{id}/edit', [AdminController::class, 'examinersEdit'])->name('admin.examiners.edit');
    Route::put('/admin/examiners/{id}', [AdminController::class, 'examinersUpdate'])->name('admin.examiners.update');
    Route::delete('/admin/examiners/{id}', [AdminController::class, 'examinersDestroy'])->name('admin.examiners.destroy');
    Route::get('/admin/examiners/{id}/groups', [AdminController::class, 'showExaminerGroups'])->name('admin.examiners.groups');
    Route::post('/admin/examiners/{id}/groups', [AdminController::class, 'updateExaminerGroups']);

    // Управление экзаменами
    Route::get('/admin/exams', [AdminController::class, 'showExams'])->name('admin.exams');
    Route::get('/admin/exams/add', [AdminController::class, 'showAddExamForm'])->name('admin.exams.add');
    Route::post('/admin/exams/add', [AdminController::class, 'addExam'])->name('admin.exams.store');
    Route::get('/admin/exams/{id}/edit', [AdminController::class, 'showEditExamForm'])->name('admin.exams.edit');
    Route::put('/admin/exams/{id}', [AdminController::class, 'updateExam'])->name('admin.exams.update');
    Route::delete('/admin/exams/{id}', [AdminController::class, 'deleteExam'])->name('admin.exams.delete');

    // Группы студентов
    Route::get('/admin/groups', [AdminController::class, 'showGroups'])->name('admin.groups');
    Route::get('/admin/groups/add', [AdminController::class, 'showAddGroupForm'])->name('admin.groups.add');
    Route::post('/admin/groups/add', [AdminController::class, 'addGroup'])->name('admin.groups.store');
    Route::get('/admin/groups/{id}/edit', [AdminController::class, 'showEditGroupForm'])->name('admin.groups.edit');
    Route::put('/admin/groups/{id}', [AdminController::class, 'updateGroup'])->name('admin.groups.update');
    Route::delete('/admin/groups/{id}', [AdminController::class, 'deleteGroup'])->name('admin.groups.destroy');
    
    // Связи экзаменов с группами
    Route::get('/admin/exams/{id}/groups', [AdminController::class, 'showExamGroups'])->name('admin.exams.groups');
    Route::post('/admin/exams/{id}/groups', [AdminController::class, 'updateExamGroups']);
});

Route::middleware([CheckRole::class . ':examiner'])->group(function () {
    Route::get('/examiner/dashboard', [ExaminerController::class, 'show'])->name('examiner.dashboard');
    Route::get('/examiner/download/{userId}/{filename}', [ExaminerController::class, 'downloadStudentFile'])
    ->name('examiner.download');

});

Route::middleware([CheckRole::class . ':student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::post('/student/upload', [UserController::class, 'uploadFile'])->name('uploadFile');
    
});

