<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileSystemController extends Controller
{

    public static function createExamFolder($examName)
    {
        try {
            // Имя папки

            $folderName = Str::slug($examName, '_');
            $folderPath = $folderName;
            
            // Создаем папку, если она не существует

            if (!Storage::disk('exames')->exists($folderPath)) {
                Storage::disk('exames')->makeDirectory($folderPath);
                return 'exames/' . $folderPath;
            }
            
            return 'exames/' . $folderPath;
        } catch (\Exception $e) {
            return null;
        }
    }

public static function deleteExamFolder($folderPath)
{
    try {

        $relativePath = $folderPath;
        
        // Удаляем все файлы и подпапки
        if (Storage::disk('exames')->exists($relativePath)) {
            Storage::disk('exames')->deleteDirectory($relativePath);
            return true;
        }
        return false;
    } catch (\Exception $e) {
        return false;
    }
}

    public static function normalizePath($path)
    {
        return str_replace('/', '\\', $path);
    }
}