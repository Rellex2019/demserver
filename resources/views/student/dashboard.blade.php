@extends('layouts.app')

@section('title', 'Панель студента')

@section('content')
<div class="card shadow">
    <div class="card-header bg-info text-white">
        <h3 class="m-0">Панель студента</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            Вы вошли как: <strong>{{ session('user')->login }}</strong> ({{ session('user')->role }})
        </div>
        
        <!-- Форма для загрузки файла -->
        <div class="mt-4">
            <h5>Загрузка файла</h5>
            <form action="{{route('uploadFile')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="custom-file">
                        <input type="hidden" name="user_id" value="{{session('user')->id}}">
                        <input type="file" accept=".zip,.rar,.7zip" class="custom-file-input" id="fileUpload" name="file" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Загрузить</button>
            </form>
        </div>
    </div>
</div>

@endsection