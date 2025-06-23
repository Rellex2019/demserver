<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExaminerController extends Controller
{
    public function show()
    {
        // Получаем группы, которые курирует текущий экзаменатор
        $groups = DB::table('examiner_groups')
            ->join('groups', 'examiner_groups.group_id', '=', 'groups.id')
            ->where('examiner_groups.examiner_id', session('user')->id)
            ->select('groups.id', 'groups.name') // Явно указываем нужные поля
            ->get();

        // Для каждой группы получаем студентов
        $groupsWithStudents = [];
        foreach ($groups as $group) {
            $students = DB::table('students')
                ->join('users', 'students.user_id', '=', 'users.id')
                ->where('students.group_id', $group->id)
                ->select(
                    'students.user_id',
                    'students.FIO',
                    'students.group_id',
                    'students.folder_path',
                    'users.login',
                    'users.role'
                )
                ->get();

            $groupsWithStudents[] = [
                'group' => $group,
                'students' => $students
            ];
        }
        return view('examiner.dashboard', [
            'groupsWithStudents' => $groupsWithStudents
        ]);
    }

    public function downloadStudentFile($userId, $filename)
    {
        // Получаем данные студента
        $student = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('students.user_id', $userId)
            ->first();

        $group = DB::table('groups')->where('id', $student->group_id)->first();

        // Получаем экзамен для группы студента
        $exam = DB::table('exam_groups')
            ->join('exams', 'exam_groups.exam_id', '=', 'exams.id')
            ->where('exam_groups.group_id', $student->group_id)
            ->first();


        // Формируем путь к файлу
        $path = 'exames/'
            . Str::slug($exam->name) . '/'
            . Str::slug($group->name) . '/'
            . $student->login . '/'
            . $filename;

        $fullPath = storage_path('app/' . $path);

        Log::debug($fullPath);

        // Скачиваем файл
        $headers = [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        return response()->download($fullPath, $filename, $headers);
    }
}
