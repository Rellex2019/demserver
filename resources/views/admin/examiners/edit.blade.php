@extends('layouts.app')

@section('title', 'Редактирование экзаменатора')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Редактирование экзаменатора</h3>
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

            <form method="POST" action="{{ route('admin.examiners.update', $examiner->user_id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Логин</label>
                    <input type="text" class="form-control" name="login" value="{{ $examiner->login }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Новый пароль (оставьте пустым, чтобы не менять)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="fio" class="form-label">ФИО</label>
                    <input type="text" class="form-control" id="fio" name="fio" 
                           value="{{ $examiner->FIO }}" required maxlength="300">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.examiners') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection