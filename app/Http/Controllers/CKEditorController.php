<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Store the file in the public disk under ckeditor directory
            $path = $file->storeAs('ckeditor', $fileName, 'public');

            return response()->json([
                'url' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => ['message' => 'No file uploaded']], 400);
    }
}
