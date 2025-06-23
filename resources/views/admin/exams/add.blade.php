@extends('layouts.app')

@section('title', 'Добавление экзамена')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="m-0">Добавление нового экзамена</h3>
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

            <form method="POST" action="{{ route('admin.exams.add') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Название экзамена</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="exam_date" class="form-label">Дата и время проведения</label>
                    <input type="datetime-local" class="form-control @error('exam_date') is-invalid @enderror" 
                           id="exam_date" name="exam_date"
                           value="{{ old('exam_date') }}" 
                           required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.exams') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Добавить экзамен
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection