<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ElectionService;

class DownloadElectionResultController extends Controller
{
    public function __invoke(Election $election)
    {
        $results = (new ElectionService)->getResults($election);

        $pdf = Pdf::loadView('pdf', [
            'organization_code' => $election->organization->code,
            'organization_name' => $election->organization->name,
            'year' => $election->created_at->format('Y'),
            'results' => $results
        ]);

        return $pdf->stream($election->id . '.pdf');
    }
}
