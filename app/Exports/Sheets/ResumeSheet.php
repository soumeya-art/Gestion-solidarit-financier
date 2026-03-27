<?php
namespace App\Exports\Sheets;
use App\Models\Cotisation;
use App\Models\DemandeAide;
use App\Models\User;
use App\Models\FondCommun;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResumeSheet implements FromArray, WithTitle, WithStyles {

    public function title(): string { return 'Résumé'; }

    public function array(): array {
        return [
            ['GESTION SOLIDARITÉ FINANCIÈRE - BILAN'],
            ['Généré le : ' . date('d/m/Y à H:i')],
            [''],
            ['STATISTIQUES GÉNÉRALES'],
            ['Total Membres',     User::where('role', 'membre')->count()],
            ['Total Cotisations', number_format(Cotisation::sum('montant'), 0, ',', ' ') . ' FDJ'],
            ['Total Aides',       number_format(DemandeAide::where('statut','approuve')->sum('montant_approuve'), 0, ',', ' ') . ' FDJ'],
            ['Fonds Disponible',  number_format(FondCommun::first()?->solde_disponible ?? 0, 0, ',', ' ') . ' FDJ'],
            ['Fonds Total',       number_format(FondCommun::first()?->solde_total ?? 0, 0, ',', ' ') . ' FDJ'],
            [''],
            ['AIDES PAR STATUT'],
            ['En attente',  DemandeAide::where('statut', 'en_attente')->count()],
            ['Approuvées',  DemandeAide::where('statut', 'approuve')->count()],
            ['Payées',      DemandeAide::where('statut', 'paye')->count()],
            ['Refusées',    DemandeAide::where('statut', 'refuse')->count()],
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true]],
            11 => ['font' => ['bold' => true]],
        ];
    }
}