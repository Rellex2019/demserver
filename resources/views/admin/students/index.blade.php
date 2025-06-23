@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="m-0">Список студентов</h3>
            <a href="{{ route('admin.students.add') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Добавить
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Группа</th>
                            <th>Путь к папке</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->user_id }}</td>
                            <td>{{ $student->FIO }}</td>
                            <td>{{ $student->login }}</td>
                            <td>{{ $student->group_name ?? '—' }}</td>
                            <td>
                                <code>{{ $student->folder_path ?: 'не указан' }}</code>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.students.edit', $student->user_id) }}" 
                                       class="btn btn-sm btn-primary"
                                       title="Редактировать">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.students.delete', $student->user_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Вы уверены, что хотите удалить этого студента?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection