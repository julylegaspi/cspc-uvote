<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'import_file' => 'required|file'
        ]);
        
        Excel::import(new UsersImport, $request->file('import_file'));

        return back()->with('success', 'Imported');
    }
}
