<?php

namespace App\Http\Controllers;

use App\Jobs\ImportExcelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ]);

        $file = $request->file('file');
        $path = $file->store('imports');

        ImportExcelJob::dispatch($path);

        return back()->with('success', 'File has been uploaded and is being processed. You will be notified once the import is complete.');
    }
}