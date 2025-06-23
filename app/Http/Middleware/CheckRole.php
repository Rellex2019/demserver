<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Проверяем, авторизован ли пользователь
        if (!session('user')) {
            return redirect('/login');
        }

        // Проверяем роль
        if (session('user')->role !== $role) {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }
}