<?php
namespace App\Exports;
use App\Models\Cotisation;
use App\Models\DemandeAide;
use App\Models\User;
use App\Models\FondCommun;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RapportExport implements WithMultipleSheets {
    public function sheets(): array {
        return [
            'Résumé'       => new Sheets\ResumeSheet(),
            'Cotisations'  => new Sheets\CotisationsSheet(),
            'Aides'        => new Sheets\AidesSheet(),
        ];
    }
}