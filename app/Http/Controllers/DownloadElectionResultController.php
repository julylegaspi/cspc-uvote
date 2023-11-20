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

        $electionHasEnded = (new ElectionService)->electionHasEnded($election);

        if (!$electionHasEnded)
        {
            $text = 'UNOFFICIAL';
        } else {
            $text = 'OFFICIAL';
        }

        $pdf = Pdf::loadView('pdf', [
            'organization_code' => $election->organization->code,
            'organization_name' => $election->organization->name,
            'year' => $election->created_at->format('Y'),
            'results' => $results,
            'text' => $text,
        ]);

        return $pdf->stream($election->id . '.pdf');
    }
}
