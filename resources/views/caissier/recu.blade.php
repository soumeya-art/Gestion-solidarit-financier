<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Reçu de paiement</title>
  <style>
    * { font-family: Arial, sans-serif; margin:0; padding:0; box-sizing:border-box; }
    body { padding:40px; color:#1e293b; }
    .header { text-align:center; margin-bottom:30px; padding-bottom:20px; border-bottom:3px solid #6366f1; }
    .header h1 { font-size:24px; color:#6366f1; margin-bottom:6px; }
    .header p { color:#64748b; font-size:13px; }
    .badge { display:inline-block; background:#d1fae5; color:#065f46; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:700; margin:16px 0; }
    .info-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:24px; margin-bottom:24px; }
    .info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f1f5f9; }
    .info-row:last-child { border-bottom:none; }
    .info-label { color:#64748b; font-size:13px; }
    .info-value { font-weight:700; color:#1e293b; font-size:13px; }
    .montant-box { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; padding:20px; border-radius:12px; text-align:center; margin:20px 0; }
    .montant-value { font-size:28px; font-weight:800; }
    .montant-label { font-size:12px; opacity:0.8; margin-top:4px; }
    .signatures { display:flex; justify-content:space-between; margin-top:40px; }
    .signature-box { text-align:center; width:45%; }
    .signature-line { border-top:2px solid #1e293b; margin-top:40px; padding-top:8px; font-size:12px; color:#64748b; }
    .footer { text-align:center; margin-top:30px; padding-top:20px; border-top:1px solid #e2e8f0; color:#94a3b8; font-size:11px; }
    .print-btn { background:#6366f1; color:white; border:none; padding:12px 24px; border-radius:8px; font-size:14px; cursor:pointer; margin-bottom:20px; }
    @media print { .print-btn { display:none; } }
  </style>
</head>
<body>

  <button class="print-btn" onclick="window.print()">🖨️ Imprimer le reçu</button>

  <div class="header">
    <h1>💰 Gestion Solidarité Financière</h1>
    <p>REÇU DE PAIEMENT D'AIDE</p>
    <div class="badge">✅ Paiement confirmé</div>
  </div>

  <div class="montant-box">
    <div class="montant-value">
      {{ number_format($demande->montant_approuve, 0, ',', ' ') }} FDJ
    </div>
    <div class="montant-label">Montant payé</div>
  </div>

  <div class="info-box">
    <div class="info-row">
      <span class="info-label">📋 Numéro reçu</span>
      <span class="info-value">#{{ str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">👤 Bénéficiaire</span>
      <span class="info-value">{{ $demande->membre->user->prenom }} {{ $demande->membre->user->nom }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">📞 Téléphone</span>
      <span class="info-value">{{ $demande->membre->user->telephone }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">🆘 Type d'aide</span>
      <span class="info-value">{{ ucfirst($demande->type) }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">📝 Motif</span>
      <span class="info-value">{{ $demande->motif }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">💳 Mode paiement</span>
      <span class="info-value">
        @if($demande->mode_paiement == 'especes') 💵 Espèces
        @elseif($demande->mode_paiement == 'waafi') 📱 Waafi Pay
        @elseif($demande->mode_paiement == 'dmoney') 📱 D-Money
        @endif
      </span>
    </div>
    @if($demande->reference_paiement)
    <div class="info-row">
      <span class="info-label">🔢 Référence</span>
      <span class="info-value">{{ $demande->reference_paiement }}</span>
    </div>
    @endif
    <div class="info-row">
      <span class="info-label">📅 Date paiement</span>
      <span class="info-value">{{ $demande->updated_at->format('d/m/Y à H:i') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">💼 Caissier</span>
      <span class="info-value">{{ $caissier->prenom }} {{ $caissier->nom }}</span>
    </div>
  </div>

  <div class="signatures">
    <div class="signature-box">
      <div class="signature-line">Signature du Caissier</div>
    </div>
    <div class="signature-box">
      <div class="signature-line">Signature du Bénéficiaire</div>
    </div>
  </div>

  <div class="footer">
    <p>Gestion Solidarité Financière — Document officiel</p>
    <p>Généré le {{ date('d/m/Y à H:i') }}</p>
  </div>

</body>
</html>