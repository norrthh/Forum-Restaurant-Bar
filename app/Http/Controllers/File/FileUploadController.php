<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            return response()->json([
                'message' => 'Файл успешно загружен',
                'url' => 'uploads/' . $fileName
            ]);
        }

        return response()->json([
            'message' => 'Файл не найден'
        ]);
    }
}
