@extends('layouts.app')

@section('title', 'Добавление экзаменатора')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Добавление экзаменатора</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.examiners.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="fio" class="form-label">ФИО</label>
                    <input type="text" class="form-control" id="fio" name="fio" required maxlength="300">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.examiners') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection