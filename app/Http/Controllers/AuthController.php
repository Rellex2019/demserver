<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Форма входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Обработка входа
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')
            ->where('login', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Неверный логин или пароль']);
        }

        // Сохраняем пользователя в сессию
        session(['user' => $user]);

        // Перенаправляем по роли
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'examiner' => redirect()->route('examiner.dashboard'),
            'student' => redirect()->route('student.dashboard')
        };
    }


    // Выход
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}