<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Services\ElectionService;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadElectionResultController extends Controller
{
    public function __invoke(Election $election)
    {
        $results = (new ElectionService)->getSummaryResults($election);

        // $data = [];

        // foreach ($results as $positionName => $candidates) {
        //     foreach ($candidates as $candidate) {
                
        //     }
        // }

        $pdf = Pdf::loadView('pdf', [
            'organization_code' => $election->organization->code,
            'organization_name' => $election->organization->name,
            'year' => $election->created_at->format('Y'),
            'results' => $results
        ]);

        return $pdf->stream($election->id . '.pdf');
    }
}
