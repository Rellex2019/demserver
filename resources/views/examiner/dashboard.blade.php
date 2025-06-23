@extends('layouts.app')

@section('title', 'Панель экзаменатора')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h3 class="m-0">Панель экзаменатора</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Вы вошли как: <strong>{{ session('user')->login }}</strong> ({{ session('user')->role }})
            </div>

            <h4 class="mb-3">Ваши группы и студенты</h4>

            @if(count($groupsWithStudents) > 0)
            <div class="accordion" id="groupsAccordion">
                @foreach($groupsWithStudents as $groupData)
                <div class="card mb-2">
                    <div class="card-header" id="heading{{ $groupData['group']->id }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                data-target="#collapse{{ $groupData['group']->id }}"
                                aria-expanded="false"
                                aria-controls="collapse{{ $groupData['group']->id }}">
                                Группа: {{ $groupData['group']->name }}
                                <span class="badge badge-primary ml-2">
                                    {{ count($groupData['students']) }} студентов
                                </span>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $groupData['group']->id }}"
                        class="collapse"
                        aria-labelledby="heading{{ $groupData['group']->id }}"
                        data-parent="#groupsAccordion">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Логин</th>
                                            <th>ФИО</th>
                                            <th>Файл</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupData['students'] as $student)
                                        <tr>
                                            <td>{{ $student->user_id }}</td>
                                            <td>{{ $student->login }}</td>
                                            <td>{{ $student->FIO }}</td>
                                            <td>
                                                @if($student->folder_path)
                                                <a href="{{ route('examiner.download', ['userId' => $student->user_id, 'filename' => basename($student->folder_path)]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fas fa-download"></i> Скачать работу
                                                </a>
                                                @else
                                                <span class="text-muted">Работа не загружена</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-warning">
                Вам не назначено ни одной группы для курирования.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card-header h5 button {
        color: #333;
        text-decoration: none;
        width: 100%;
        text-align: left;
    }

    .card-header h5 button:hover {
        color: #007bff;
    }

    .badge {
        font-size: 0.8rem;
    }
</style>
@endsection