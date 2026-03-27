<x-app-layout>
  <x-slot name="header">Rapports Financiers</x-slot>

  <div class="stat-grid stat-grid-4" style="margin-bottom:28px">
    <div class="stat-card">
      <div class="stat-icon-box green">👥</div>
      <div class="stat-info">
        <div class="stat-value">{{ $stats['total_membres'] }}</div>
        <div class="stat-label">Total Membres</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box blue">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }}</div>
        <div class="stat-label">Total Cotisations (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🆘</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['total_aides'], 0, ',', ' ') }}</div>
        <div class="stat-label">Total Aides (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box indigo">🏦</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['fonds_disponible'], 0, ',', ' ') }}</div>
        <div class="stat-label">Fonds Disponible (FDJ)</div>
      </div>
    </div>
  </div>

  <div class="stat-grid stat-grid-3" style="margin-bottom:28px">
    <div class="stat-card">
      <div class="stat-icon-box purple">💸</div>
      <div class="stat-info">
        <div class="stat-value">{{ $stats['nb_remboursements'] }}</div>
        <div class="stat-label">Membres remboursés</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box red">💸</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['total_remboursements'], 0, ',', ' ') }}</div>
        <div class="stat-label">Total Remboursé (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box blue">🏦</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['fonds_total'], 0, ',', ' ') }}</div>
        <div class="stat-label">Fonds Total (FDJ)</div>
      </div>
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px">
    <div class="card">
      <h2 class="section-title">💰 Dernières cotisations</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Membre</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($cotisations as $cotisation)
            <tr>
              <td>{{ $cotisation->membre->user->prenom }} {{ $cotisation->membre->user->nom }}</td>
              <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FDJ</td>
              <td>{{ $cotisation->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">Aucune cotisation.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <h2 class="section-title">💸 Remboursements payés</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Membre</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($remboursements as $remb)
            <tr>
              <td>{{ $remb->membre->user->prenom }} {{ $remb->membre->user->nom }}</td>
              <td style="color:#dc2626; font-weight:700">-{{ number_format($remb->montant_approuve, 0, ',', ' ') }} FDJ</td>
              <td>{{ $remb->updated_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">Aucun remboursement.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
