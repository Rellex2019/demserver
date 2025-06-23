<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function uploadFile(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|file|max:10240', // Максимум 10 MB
        ]);

        // Получаем данные студента
        $student = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('groups', 'students.group_id', '=', 'groups.id')
            ->where('students.user_id', $validated['user_id'])
            ->first();

        if (!$student) {
            return back()->with('error', 'Студент не найден');
        }

        // Получаем экзамен для группы студента
        $exam = DB::table('exam_groups')
            ->join('exams', 'exam_groups.exam_id', '=', 'exams.id')
            ->where('exam_groups.group_id', $student->group_id)
            ->first();

        if (!$exam) {
            return back()->with('error', 'Для группы студента не назначен экзамен');
        }

        // Формируем путь для сохранения
        $fullPath = storage_path('app/exames/'
            . Str::slug($exam->name) . '/'
            . Str::slug($student->name) . '/'
            . $student->login);

        // Создаем директории, если их нет
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        if (file_exists($fullPath)) {
            $files = glob($fullPath . '/*'); // Получаем все файлы в папке
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Удаляем каждый файл
                }
            }
        } else {
            mkdir($fullPath, 0755, true); // Создаем папку, если ее нет
        }

        // Сохраняем файл
        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();

            $file->move($fullPath, $filename);

            // Записываем информацию о файле в БД
            DB::table('students')->where('user_id',$validated['user_id'])->update([
                'folder_path' => 'exams/' 
                . Str::slug($exam->name) . '/' 
                . Str::slug($student->name) . '/' 
                . $student->login . '/'
                . $filename,
            ]);

            return back()->with('success', 'Файл успешно загружен');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке файла: ' . $e->getMessage());
        }
    }
}
