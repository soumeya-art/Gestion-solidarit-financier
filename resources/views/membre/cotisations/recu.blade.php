<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Reçu de cotisation</title>
  <style>
    * { font-family: Arial, sans-serif; margin:0; padding:0; box-sizing:border-box; }
    body { padding:40px; color:#1e293b; background:#f8fafc; }
    .container { max-width:500px; margin:0 auto; background:white; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.1); }
    .header { background:linear-gradient(135deg,#6366f1,#8b5cf6); padding:32px; text-align:center; color:white; }
    .header h1 { font-size:1.5rem; font-weight:800; margin-bottom:4px; }
    .header p { opacity:0.8; font-size:0.85rem; }
    .badge { display:inline-block; background:rgba(255,255,255,0.2); padding:6px 16px; border-radius:20px; font-size:0.8rem; font-weight:700; margin-top:12px; }
    .amount { background:#f0fdf4; padding:24px; text-align:center; border-bottom:2px dashed #e2e8f0; }
    .amount-value { font-size:2.5rem; font-weight:800; color:#059669; }
    .amount-label { color:#64748b; font-size:0.85rem; margin-top:4px; }
    .info { padding:24px; }
    .info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f1f5f9; }
    .info-row:last-child { border-bottom:none; }
    .info-label { color:#64748b; font-size:0.875rem; }
    .info-value { font-weight:700; color:#1e293b; font-size:0.875rem; }
    .footer { padding:20px 24px; background:#f8fafc; text-align:center; }
    .print-btn { background:#6366f1; color:white; border:none; padding:12px 24px; border-radius:8px; font-size:0.875rem; cursor:pointer; margin-right:8px; }
    .back-btn { background:#f1f5f9; color:#1e293b; border:none; padding:12px 24px; border-radius:8px; font-size:0.875rem; cursor:pointer; text-decoration:none; display:inline-block; }
    @media print { .footer { display:none; } body { background:white; } .container { box-shadow:none; } }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>💰 Reçu de Cotisation</h1>
      <p>Gestion Solidarité Financière</p>
      <div class="badge">✅ Paiement confirmé</div>
    </div>
    <div class="amount">
      <div class="amount-value">{{ number_format($cotisation->montant, 0, ',', ' ') }} FDJ</div>
      <div class="amount-label">Montant cotisé</div>
    </div>
    <div class="info">
      <div class="info-row">
        <span class="info-label">📋 Numéro reçu</span>
        <span class="info-value">#{{ str_pad($cotisation->id, 6, '0', STR_PAD_LEFT) }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">👤 Membre</span>
        <span class="info-value">{{ $cotisation->membre->user->prenom }} {{ $cotisation->membre->user->nom }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">📞 Téléphone</span>
        <span class="info-value">{{ $cotisation->membre->user->telephone }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">📅 Date paiement</span>
        <span class="info-value">{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y à H:i') }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">✅ Statut</span>
        <span class="info-value" style="color:#059669">Payée</span>
      </div>
      @if($cotisation->en_retard)
<div class="info-row">
    <span class="info-label">⚠️ Pénalité retard</span>
    <span class="info-value" style="color:#ef4444">+{{ number_format($cotisation->penalite, 0, ',', ' ') }} FDJ</span>
</div>
<div class="info-row">
    <span class="info-label">💰 Total payé</span>
    <span class="info-value" style="color:#059669; font-size:1.1rem">{{ number_format($cotisation->montant_total, 0, ',', ' ') }} FDJ</span>
</div>
@endif
    </div>
    <div class="footer">
      <button class="print-btn" onclick="window.print()">🖨️ Imprimer</button>
      <a href="/membre/cotisations" class="back-btn">← Retour</a>
    </div>
  </div>
</body>
</html>