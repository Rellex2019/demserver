@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="m-0">Панель админестратора</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            Вы вошли как: <strong>{{ session('user')->login }}</strong> ({{ session('user')->role }})
        </div>
        <div class="container-fluid py-4">
    <div class="row">
        <!-- Карточка экзаменаторов -->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">Экзаменаторы</h3>
                    <p class="card-text">Управление учетными записями экзаменаторов</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.examiners') }}" class="btn btn-light">
                            <i class="bi bi-people"></i> Перейти к управлению
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Карточка студентов -->
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">Студенты</h3>
                    <p class="card-text">Управление учетными записями студентов</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.students') }}" class="btn btn-light">
                            <i class="bi bi-person-lines-fill"></i> Перейти к управлению
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Карточка экзаменов -->
            <div class="col-md-4 mb-4">
                <div class="card bg-info text-white h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Экзамены</h3>
                        <p class="card-text">Управление экзаменами и расписанием</p>
                        <div class="mt-auto">
                            <a href="{{ route('admin.exams') }}" class="btn btn-light">
                                <i class="bi bi-journal-text"></i> Перейти к управлению
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Карточка групп -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">Группы</h3>
                    <p class="card-text">Управление учебными группами</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.groups') }}" class="btn btn-light">
                            <i class="bi bi-collection"></i> Перейти к управлению
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection