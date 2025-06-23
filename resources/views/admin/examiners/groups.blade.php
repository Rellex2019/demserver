@extends('layouts.app')

@section('title', 'Группы экзаменатора')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="m-0">Группы экзаменатора: {{ $examiner->FIO }}</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.examiners.groups', $examiner->user_id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Выберите группы:</label>
                    <div class="row">
                        @foreach($allGroups as $group)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="groups[]" 
                                       value="{{ $group->id }}"
                                       @if(in_array($group->id, $examinerGroups)) checked @endif>
                                <label class="form-check-label">{{ $group->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.examiners') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection