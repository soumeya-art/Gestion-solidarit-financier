<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport Financier</title>
    <style>
        * { font-family: Arial, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { padding: 30px; color: #1e293b; font-size: 13px; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #6366f1; }
        .header h1 { font-size: 22px; color: #6366f1; margin-bottom: 6px; }
        .header p { color: #64748b; font-size: 12px; }
        .stats { display: table; width: 100%; margin-bottom: 24px; }
        .stat-box { display: table-cell; width: 25%; padding: 14px; text-align: center; border: 1px solid #e2e8f0; }
        .stat-value { font-size: 18px; font-weight: 800; color: #6366f1; }
        .stat-label { font-size: 10px; color: #64748b; margin-top: 4px; }
        .section-title { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid #e2e8f0; margin-top: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background: #6366f1; color: white; padding: 8px 12px; text-align: left; font-size: 11px; }
        td { padding: 8px 12px; font-size: 11px; border-bottom: 1px solid #f1f5f9; }
        tr:nth-child(even) td { background: #f8fafc; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>💰 Gestion Solidarité Financière</h1>
        <p>Rapport financier généré le {{ date('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-value">{{ $stats['total_membres'] }}</div>
            <div class="stat-label">Total Membres</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }}</div>
            <div class="stat-label">Total Cotisations (FDJ)</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ number_format($stats['total_aides'], 0, ',', ' ') }}</div>
            <div class="stat-label">Total Aides (FDJ)</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ number_format($stats['fonds_disponible'], 0, ',', ' ') }}</div>
            <div class="stat-label">Fonds Disponible (FDJ)</div>
        </div>
    </div>

    <div class="section-title">💰 Historique des Cotisations</div>
    <table>
        <thead>
            <tr>
                <th>Membre</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cotisations as $cotisation)
            <tr>
                <td>{{ $cotisation->membre->user->prenom }} {{ $cotisation->membre->user->nom }}</td>
                <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FDJ</td>
                <td>{{ $cotisation->created_at->format('d/m/Y') }}</td>
                <td>Payée</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center">Aucune cotisation.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">🆘 Historique des Aides</div>
    <table>
        <thead>
            <tr>
                <th>Membre</th>
                <th>Type</th>
                <th>Montant demandé</th>
                <th>Montant approuvé</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aides as $aide)
            <tr>
                <td>{{ $aide->membre->user->prenom }} {{ $aide->membre->user->nom }}</td>
                <td>{{ ucfirst($aide->type) }}</td>
                <td>{{ number_format($aide->montant_demande, 0, ',', ' ') }} FDJ</td>
                <td>{{ $aide->montant_approuve ? number_format($aide->montant_approuve, 0, ',', ' ') . ' FDJ' : '--' }}</td>
                <td>{{ $aide->created_at->format('d/m/Y') }}</td>
                <td>{{ ucfirst($aide->statut) }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Gestion Solidarité Financière — Document confidentiel</p>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
    </div>

</body>
</html>