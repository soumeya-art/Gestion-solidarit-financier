<x-app-layout>
  <x-slot name="header">Fonds Commun</x-slot>

  <div class="stat-grid stat-grid-3" style="margin-bottom:28px">
    <div class="stat-card">
      <div class="stat-icon-box blue">🏦</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($fond?->solde_total ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Solde Total (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box green">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($fond?->solde_disponible ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Solde Disponible (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🔒</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($fond?->solde_reserve ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Solde Réservé (FDJ)</div>
      </div>
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px">

    <div class="card">
      <h2 class="section-title">📥 Entrées — Cotisations</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>Membre</th><th>Montant</th><th>Date</th></tr>
          </thead>
          <tbody>
            @forelse($entrees as $e)
            <tr>
              <td>{{ $e->membre->user->prenom }} {{ $e->membre->user->nom }}</td>
              <td style="color:#059669; font-weight:700">+{{ number_format($e->montant, 0, ',', ' ') }} FDJ</td>
              <td>{{ $e->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">Aucune entrée.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <h2 class="section-title">📤 Sorties — Aides versées</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>Membre</th><th>Montant</th><th>Date</th></tr>
          </thead>
          <tbody>
            @forelse($sorties as $s)
            <tr>
              <td>{{ $s->membre->user->prenom }} {{ $s->membre->user->nom }}</td>
              <td style="color:#dc2626; font-weight:700">-{{ number_format($s->montant_approuve, 0, ',', ' ') }} FDJ</td>
              <td>{{ $s->updated_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">Aucune sortie.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</x-app-layout>