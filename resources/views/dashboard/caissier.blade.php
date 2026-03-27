<x-app-layout>
  <x-slot name="header">Tableau de bord Caissier</x-slot>

  <div class="stat-grid stat-grid-4">
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
        <div class="stat-label">Total Cotisations (fdj)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🆘</div>
      <div class="stat-info">
        <div class="stat-value">{{ $stats['aides_approuvees'] }}</div>
        <div class="stat-label">Aides Approuvées</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box indigo">🏦</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($stats['fonds_disponible'], 0, ',', ' ') }}</div>
        <div class="stat-label">Fonds Disponible (fdj)</div>
      </div>
    </div>
  </div>

  <div class="action-grid action-grid-3" style="margin-bottom:28px">
    <div class="action-card">
      <div class="action-icon" style="background:#d1fae5">💰</div>
      <div class="action-title">Cotisations</div>
      <div class="action-desc">Enregistrer et consulter les cotisations des membres.</div>
      <a href="/caissier/cotisations" class="btn btn-green">Gérer cotisations →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#fee2e2">🆘</div>
      <div class="action-title">Aides</div>
      <div class="action-desc">Voir les aides approuvées à remettre aux membres.</div>
      <a href="/caissier/aides" class="btn btn-red">Voir aides →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#dbeafe">🏦</div>
      <div class="action-title">Fonds Commun</div>
      <div class="action-desc">Consulter l'état du fonds commun en temps réel.</div>
      <a href="/caissier/fonds" class="btn btn-blue">Voir fonds →</a>
    </div>
  </div>

  @if(isset($dernieres_cotisations) && $dernieres_cotisations->count() > 0)
  <div class="card">
    <h2 class="section-title">💰 Dernières cotisations</h2>
    <div class="table-wrap">
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
          @foreach($dernieres_cotisations as $cotisation)
          <tr>
            <td><strong>{{ $cotisation->membre->user->prenom }} {{ $cotisation->membre->user->nom }}</strong></td>
            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} fdj</td>
            <td>{{ $cotisation->created_at->format('d/m/Y') }}</td>
            <td><span class="badge badge-green">✅ Payée</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
</x-app-layout>