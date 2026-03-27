<?php
namespace App\Exports\Sheets;
use App\Models\Cotisation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CotisationsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles {

    public function title(): string { return 'Cotisations'; }

    public function headings(): array {
        return ['Nom', 'Prénom', 'Email', 'Montant (FDJ)', 'Date', 'Statut'];
    }

    public function collection() {
        return Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($c) {
                return [
                    $c->membre->user->nom,
                    $c->membre->user->prenom,
                    $c->membre->user->email,
                    $c->montant,
                    $c->created_at->format('d/m/Y'),
                    'Payée',
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