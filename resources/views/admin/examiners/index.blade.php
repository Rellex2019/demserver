@extends('layouts.app')

@section('title', 'Управление экзаменаторами')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Список экзаменаторов</h3>
            <a href="{{ route('admin.examiners.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Добавить
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
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examiners as $examiner)
                        <tr>
                            <td>{{ $examiner->user_id }}</td>
                            <td>{{ $examiner->FIO }}</td>
                            <td>{{ $examiner->login }}</td>
                            <td class="d-flex">
                                <a href="{{ route('admin.examiners.edit', $examiner->user_id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('admin.examiners.groups', $examiner->user_id) }}" class="btn btn-sm btn-info me-2">
                                    <i class="bi bi-people"></i>
                                </a>
                                <form action="{{ route('admin.examiners.destroy', $examiner->user_id) }}" method="POST">
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
</div>
@endsection