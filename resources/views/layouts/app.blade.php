<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome для иконок -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .custom-navbar {
            height: 70px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 600;
            margin-left: 15px;
            cursor: pointer;
        }

        .logout-btn {
            padding: 8px 16px;
            font-size: 16px;
            margin-right: 15px;
            border-radius: 4px;
        }

        .container-fluid {
            padding: 0 160px;
        }
    </style>
    @yield('styles')
</head>

<body>
    @if(!request()->is('login'))
    <header class="navbar navbar-dark bg-primary custom-navbar">
        <div class="container-fluid">
            <a href="{{ 
                session('user')->role === 'admin' ? route('admin.dashboard') : 
                (session('user')->role === 'examiner' ? route('examiner.dashboard') : route('student.dashboard')) 
            }}" class="navbar-brand">AcademSave</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger logout-btn">
                    <i class="bi bi-box-arrow-left" style="margin-right: 5px;"></i>Выйти
                </button>
            </form>
        </div>
    </header>
    @endif

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>