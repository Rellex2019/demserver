@extends('layouts.app')

@section('title', 'Редактирование студента')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="m-0">Редактирование данных студента</h3>
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

        <form method="POST" action="{{ route('admin.students.update', $student->user_id) }}">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" 
                           value="{{ old('login', $student->login) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Новый пароль</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="text-muted">Оставьте пустым, если не нужно менять</small>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="FIO" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="FIO" name="FIO" 
                       value="{{ old('FIO', $student->FIO) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="group_id" class="form-label">Группа</label>
                <select class="form-select" id="group_id" name="group_id">
                    <option value="">— Не выбрана —</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" 
                            {{ old('group_id', $student->group_id) == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.students') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад к списку
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection