<?php
namespace App\Exports\Sheets;
use App\Models\DemandeAide;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AidesSheet implements FromCollection, WithTitle, WithHeadings, WithStyles {

    public function title(): string { return 'Aides'; }

    public function headings(): array {
        return ['Nom', 'Prénom', 'Type', 'Montant demandé', 'Montant approuvé', 'Date', 'Statut'];
    }

    public function collection() {
        return DemandeAide::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($a) {
                return [
                    $a->membre->user->nom,
                    $a->membre->user->prenom,
                    ucfirst($a->type),
                    $a->montant_demande,
                    $a->montant_approuve ?? 0,
                    $a->created_at->format('d/m/Y'),
                    ucfirst($a->statut),
                ];
            });
    }

    public function styles(Worksheet $sheet) {
        return [
            1 => ['font' => ['bold' => true],
                  'fill' => ['fillType' => 'solid',
                             'startColor' => ['rgb' => '6366f1']],
                  'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }
}