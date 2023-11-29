<?php

namespace App\Http\Controllers;

use App\Exports\UsersTemplate;

class DownloadUsersTemplateController extends Controller
{
    public function __invoke()
    {
        $data = ['Template', 'Course', 'Section', 'Partylist'];
        return (new UsersTemplate($data))->download('template.xlsx');
    }
}
