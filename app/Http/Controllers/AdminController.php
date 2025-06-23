<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\FileSystemController;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    // Показать список всех студентов

    public function showStudents()
    {
        $students = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
            ->select(
                'students.user_id',
                'students.FIO',
                'students.group_id',
                'students.folder_path',
                'users.login',
                'users.password',
                'groups.name as group_name'
            )
            ->orderBy('students.FIO')
            ->get();

        return view('admin.students.index', compact('students'));
    }


    // Показать форму добавления студента

    public function showAddStudentForm()
    {
        $groups = DB::table('groups')->orderBy('name')->get();
        return view('admin.students.add', compact('groups'));
    }


    // Добавить нового студента

    public function addStudent(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|max:50|unique:users,login',
            'password' => 'required|min:6',
            'FIO' => 'required|max:255',
            'group_id' => 'nullable|exists:groups,id'
        ]);

        $group = DB::table('groups')->where('id', $validated['group_id'])->first();

        DB::transaction(function () use ($validated, $group) {
            $userId = DB::table('users')->insertGetId([
                'login' => $validated['login'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            DB::table('students')->insert([
                'user_id' => $userId,
                'FIO' => $validated['FIO'],
                'group_id' => $validated['group_id'],
            ]);

            if ($validated['group_id']) {
                $examGroups = DB::table('exam_groups')
                    ->join('exams', 'exam_groups.exam_id', '=', 'exams.id')
                    ->where('exam_groups.group_id', $validated['group_id'])
                    ->select('exams.*')
                    ->get();

                foreach ($examGroups as $exam) {
                    $studentPath = storage_path('app/exames/'
                        . Str::slug($exam->name) . '/'
                        . Str::slug($group->name) . '/'
                        . $validated['login']);
                    if (!File::exists($studentPath)) {
                        File::makeDirectory($studentPath, 0755, true);
                    }
                }
            }
        });

        return redirect()->route('admin.students')
            ->with('success', 'Студент успешно добавлен');
    }


    // Показать форму редактирования студента

    public function showEditStudentForm($user_id)
    {
        $student = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
            ->where('students.user_id', $user_id)
            ->select(
                'students.user_id',
                'students.FIO',
                'students.group_id',
                'users.login',
                'groups.name as group_name'
            )
            ->first();

        if (!$student) {
            return redirect()->route('admin.students')
                ->with('error', 'Студент не найден');
        }

        $groups = DB::table('groups')->orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'groups'));
    }


    // Обновить данные студента

    public function updateStudent(Request $request, $user_id)
    {
        $validated = $request->validate([
            'login' => 'required|string|max:50|unique:users,login,' . $user_id,
            'FIO' => 'required|string|max:255',
            'group_id' => 'nullable|exists:groups,id',
            'password' => 'nullable|string|min:6'
        ]);

        DB::transaction(function () use ($validated, $user_id) {

            // Обновление данных пользователя

            $userData = [
                'login' => $validated['login'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            DB::table('users')
                ->where('id', $user_id)
                ->update($userData);

            // Обновление данных студента

            DB::table('students')
                ->where('user_id', $user_id)
                ->update([
                    'FIO' => $validated['FIO'],
                    'group_id' => $validated['group_id'],
                ]);
        });

        return redirect()->route('admin.students')
            ->with('success', 'Данные студента обновлены');
    }

    // Удалить студента

    public function deleteStudent($user_id)
    {
        DB::transaction(function () use ($user_id) {
            DB::table('students')->where('user_id', $user_id)->delete();
            DB::table('users')->where('id', $user_id)->delete();
        });

        return redirect()->route('admin.students')
            ->with('success', 'Студент успешно удален');
    }

    // Показать список экзаменаторов

    public function examinersIndex()
    {
        $examiners = DB::table('examiners')
            ->join('users', 'examiners.user_id', '=', 'users.id')
            ->select('examiners.*', 'users.login')
            ->get();

        return view('admin.examiners.index', compact('examiners'));
    }

    // Форма добавления экзаменатора

    public function examinersCreate()
    {
        return view('admin.examiners.create');
    }

    // Сохранить нового экзаменатора

    public function examinersStore(Request $request)
    {
        $request->validate([
            'login' => 'required|unique:users,login',
            'password' => 'required|min:6',
            'fio' => 'required|max:300',
        ]);

        DB::transaction(function () use ($request) {
            $userId = DB::table('users')->insertGetId([
                'login' => $request->login,
                'password' => Hash::make($request->password),
                'role' => 'examiner',
            ]);

            DB::table('examiners')->insert([
                'user_id' => $userId,
                'FIO' => $request->fio,
            ]);
        });

        return redirect()->route('admin.examiners')->with('success', 'Экзаменатор успешно добавлен');
    }

    // Форма редактирования экзаменатора

    public function examinersEdit($id)
    {
        $examiner = DB::table('examiners')
            ->join('users', 'examiners.user_id', '=', 'users.id')
            ->where('examiners.user_id', $id)
            ->select('examiners.*', 'users.login')
            ->first();

        if (!$examiner) {
            abort(404);
        }

        return view('admin.examiners.edit', compact('examiner'));
    }

    // Обновить данные экзаменатора

    public function examinersUpdate(Request $request, $id)
    {
        $request->validate([
            'login' => 'required|unique:users,login,' . $id,
            'fio' => 'required|max:300',
            'password' => 'nullable|min:6',
        ]);

        DB::transaction(function () use ($request, $id) {

            $userUpdateData = [
                'login' => $request->login,
            ];

            if ($request->password) {
                $userUpdateData['password'] = Hash::make($request->password);
            }

            DB::table('users')
                ->where('id', $id)
                ->update($userUpdateData);

            DB::table('examiners')
                ->where('user_id', $id)
                ->update([
                    'FIO' => $request->fio,
                ]);
        });

        return redirect()->route('admin.examiners')->with('success', 'Данные экзаменатора обновлены');
    }

    // Показать группы экзаменатора
    public function showExaminerGroups($id)
    {
        $examiner = DB::table('examiners')
            ->join('users', 'examiners.user_id', '=', 'users.id')
            ->where('examiners.user_id', $id)
            ->select('examiners.*', 'users.login')
            ->first();

        if (!$examiner) {
            return redirect()->route('admin.examiners')->with('error', 'Экзаменатор не найден');
        }

        $allGroups = DB::table('groups')->get();
        $examinerGroups = DB::table('examiner_groups')
            ->where('examiner_id', $id)
            ->pluck('group_id')
            ->toArray();

        return view('admin.examiners.groups', compact('examiner', 'allGroups', 'examinerGroups'));
    }

    // Обновить группы экзаменатора
    public function updateExaminerGroups(Request $request, $id)
    {
        DB::table('examiner_groups')->where('examiner_id', $id)->delete();

        if ($request->has('groups')) {
            foreach ($request->groups as $group_id) {
                DB::table('examiner_groups')->insert([
                    'examiner_id' => $id,
                    'group_id' => $group_id
                ]);
            }
        }

        return back()->with('success', 'Группы для экзаменатора обновлены!');
    }

    // Удалить экзаменатора

    public function examinersDestroy($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('examiners')->where('user_id', $id)->delete();
            DB::table('users')->where('id', $id)->delete();
        });

        return back()->with('success', 'Экзаменатор удален');
    }

    // Показать список всех групп
    public function showGroups()
    {
        $groups = DB::table('groups')->orderBy('name')->get();
        return view('admin.groups.index', compact('groups'));
    }

    // Показать форму добавления группы
    public function showAddGroupForm()
    {
        return view('admin.groups.create');
    }

    // Добавить новую группу
    public function addGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:groups,name',
        ]);

        DB::table('groups')->insert([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.groups')
            ->with('success', 'Группа успешно добавлена');
    }

    // Показать форму редактирования группы
    public function showEditGroupForm($id)
    {
        $group = DB::table('groups')->where('id', $id)->first();

        if (!$group) {
            return redirect()->route('admin.groups')
                ->with('error', 'Группа не найдена');
        }

        return view('admin.groups.edit', compact('group'));
    }

    // Обновить данные группы
    public function updateGroup(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:groups,name,' . $id,
        ]);

        $affected = DB::table('groups')
            ->where('id', $id)
            ->update(['name' => $validated['name']]);

        if ($affected) {
            return redirect()->route('admin.groups')
                ->with('success', 'Данные группы обновлены');
        }

        return back()->with('error', 'Не удалось обновить группу');
    }

    // Удалить группу
    public function deleteGroup($id)
    {
        // Проверяем, есть ли студенты в этой группе
        $studentsCount = DB::table('students')->where('group_id', $id)->count();

        if ($studentsCount > 0) {
            return back()->with('error', 'Нельзя удалить группу, в которой есть студенты');
        }

        // Проверяем, связана ли группа с какими-либо экзаменами
        $examGroupsCount = DB::table('exam_groups')->where('group_id', $id)->count();

        if ($examGroupsCount > 0) {
            return back()->with('error', 'Нельзя удалить группу, так как она связана с экзаменами');
        }

        DB::table('groups')->where('id', $id)->delete();

        return redirect()->route('admin.groups')
            ->with('success', 'Группа успешно удалена');
    }

    public function showExams()
    {
        $exams = DB::table('exams')->orderBy('exam_date', 'desc')->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function showAddExamForm()
    {
        $groups = DB::table('groups')->get();
        return view('admin.exams.add', compact('groups'));
    }

    public function addExam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('today midnight')) {
                        $fail('Дата экзамена не может быть раньше текущей даты');
                    }
                }
            ],
        ]);

        // Создаем папку для экзамена

        $folderPath = FileSystemController::createExamFolder($request->name);
        $folderPath = FileSystemController::normalizePath($folderPath);

        if (!$folderPath) {
            return back()->with('error', 'Не удалось создать папку для экзамена')->withInput();
        }

        DB::table('exams')->insert([
            'name' => $request->name,
            'exam_date' => $request->exam_date,
            'folder_path' => $folderPath,
        ]);

        return redirect()->route('admin.exams')->with('success', 'Экзамен успешно добавлен');
    }

    public function deleteExam($id)
    {
        $exam = DB::table('exams')->where('id', $id)->first();

        if ($exam) {
            DB::beginTransaction();

            try {

                // Удаление папку экзамена

                if (!empty($exam->folder_path)) {
                    $folderPath = FileSystemController::normalizePath($exam->folder_path);

                    $folderName = str_replace('exames/', '', $folderPath);



                    if (Storage::disk('exames')->exists($folderName)) {

                        $files = Storage::disk('exames')->allFiles($folderName);
                        Storage::disk('exames')->delete($files);

                        Storage::disk('exames')->deleteDirectory($folderName);
                    }
                }

                DB::table('exam_groups')->where('exam_id', $id)->delete();

                DB::table('exams')->where('id', $id)->delete();

                DB::commit();

                return back()->with('success', 'Экзамен успешно удален!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Не удалось удалить экзамен');
            }
        }

        return back()->with('error', 'Экзамен не найден');
    }

    public function showExamGroups($id)
    {
        $exam = DB::table('exams')->where('id', $id)->first();
        $allGroups = DB::table('groups')->get();
        $examGroups = DB::table('exam_groups')
            ->where('exam_id', $id)
            ->pluck('group_id')
            ->toArray();

        return view('admin.exams.groups', compact('exam', 'allGroups', 'examGroups'));
    }

    public function updateExamGroups(Request $request, $id)
    {

        $exam = DB::table('exams')->where('id', $id)->first();

        DB::table('exam_groups')->where('exam_id', $id)->delete();

        $examBasePath = storage_path('app/exames/' . Str::slug($exam->name));
        if (!File::exists($examBasePath)) {
            File::makeDirectory($examBasePath, 0755, true);
        }

        if ($request->has('groups')) {
            foreach ($request->groups as $group_id) {
                DB::table('exam_groups')->insert([
                    'exam_id' => $id,
                    'group_id' => $group_id
                ]);
                $group = DB::table('groups')->where('id', $group_id)->first();

                if ($group) {
                    $groupPath = $examBasePath . '/' . Str::slug($group->name);
                    if (!File::exists($groupPath)) {
                        File::makeDirectory($groupPath, 0755, true);
                    }
                }
            }
        }

        return back()->with('success', 'Группы для экзамена обновлены!');
    }

    public function showEditExamForm($id)
    {
        $exam = DB::table('exams')->where('id', $id)->first();

        if (!$exam) {
            return redirect()->route('admin.exams')->with('error', 'Экзамен не найден');
        }

        return view('admin.exams.edit', compact('exam'));
    }

    public function updateExam(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'exam_date' => [
                    'required',
                    'date',
                    'after_or_equal:today'
                ],
            ],
            [
                'exam_date.after_or_equal' => 'Дата экзамена не может быть раньше текущей даты'
            ]
        );

        $exam = DB::table('exams')->where('id', $id)->first();

        if (!$exam) {
            return back()->with('error', 'Экзамен не найден');
        }

        $folderPath = $exam->folder_path;

        // Если изменилось имя экзамена, переименовываем папку

        if ($exam->name !== $request->name) {

            // Создаём новую папку с новым именем

            $newFolderName = Str::slug($request->name, '_');
            $newFolderPath = 'exames/' . $newFolderName;

            // Если удалось создать новую папку, удаляем старую

            if (Storage::disk('exames')->makeDirectory($newFolderName)) {
                $oldFolderPath = FileSystemController::normalizePath($exam->folder_path);

                if ($oldFolderPath && Storage::disk('exames')->exists($oldFolderPath)) {
                    Storage::disk('exames')->deleteDirectory($oldFolderPath);
                }

                // Обновляем путь в базе данных

                $folderPath = $newFolderPath;
            }
        }

        $affected = DB::table('exams')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'exam_date' => $request->exam_date,
                'folder_path' => $folderPath,
            ]);

        if ($affected) {
            return redirect()->route('admin.exams')->with('success', 'Экзамен успешно обновлен');
        }

        return back()->with('error', 'Не удалось обновить экзамен');
    }
}
