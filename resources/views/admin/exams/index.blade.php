@extends('layouts.app')

@section('title', 'Управление экзаменами')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="m-0">Список экзаменов</h3>
        <a href="{{ route('admin.exams.add') }}" class="btn btn-light">
            <i class="bi bi-plus-circle"></i> Добавить экзамен
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Дата</th>
                        <th>Путь к папке</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>{{ date('d.m.Y H:i', strtotime($exam->exam_date)) }}</td>
                        <td>{{ $exam->folder_path ?? 'Не указан' }}</td>
                        <td class="d-flex">
                            <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('admin.exams.groups', $exam->id) }}" class="btn btn-sm btn-info me-2">
                                <i class="bi bi-people"></i>
                            </a>
                            <form action="{{ route('admin.exams.delete', $exam->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection