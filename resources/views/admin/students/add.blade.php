@extends('layouts.app')

@section('title', 'Добавление студента')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="m-0">Добавление нового студента</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.students.add') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="fio" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="fio" name="FIO" required>
            </div>
            <div class="mb-3">
                <label for="group_id" class="form-label">Группа</label>
                <select class="form-select" id="group_id" name="group_id">
                    <option value="">— Не выбрана —</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.students') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад к списку
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Сохранить
                </button>
            </div>
        </form>
    </div>
</div>
@endsection