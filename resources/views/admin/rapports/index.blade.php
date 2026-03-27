<x-app-layout>
  <x-slot name="header">Rapports Financiers</x-slot>

  <!-- Boutons export -->
  <div style="display:flex; gap:12px; justify-content:flex-end; margin-bottom:20px">
    <a href="/admin/rapports/pdf" class="btn btn-red">📄 Exporter PDF</a>
    <a href="/admin/rapports/excel" class="btn btn-green">📊 Exporter Excel</a>
  </div>

  <!-- Filtre par période -->
  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">📅 Rapport par période</h2>
    <form method="POST" action="/admin/rapports/periode">
      @csrf
      <div style="display:flex; gap:16px; align-items:flex-end; flex-wrap:wrap">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Date début</label>
          <input type="date" name="date_debut" class="form-input"
                 value="{{ $date_debut ?? date('Y-m-01') }}" required>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Date fin</label>
          <input type="date" name="date_fin" class="form-input"
                 value="{{ $date_fin ?? date('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-indigo">
          🔍 Générer rapport
        </button>
        <a href="/admin/rapports" class="btn btn-gray">
          🔄 Réinitialiser
        </a>
      </div>
    </form>
  </div>

  <!-- Stats -->
  <div class="stat-grid stat-grid-4" style="margin-bottom:28px">
    <div class="stat-card">
      <div class="stat-icon-box green">👥</div>
      <div class="stat-info">
        <div class="stat-value">{{ $stats['total_membres'] ?? \App\Models\User::where('role','membre')->count() }}</div>
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
        <div class="stat-value">{{ number_format($stats['fonds_disponible'] ?? \App\Models\FondCommun::first()?->solde_disponible ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Fonds Disponible (FDJ)</div>
      </div>
    </div>
  </div>

  <!-- Tableaux -->
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px">

    <div class="card">
      <h2 class="section-title">💰 Cotisations</h2>
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
            @forelse($dernieres_cotisations ?? $cotisations ?? [] as $cotisation)
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
      <h2 class="section-title">🆘 Demandes d'aide</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Membre</th>
              <th>Montant</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            @forelse($dernieres_aides ?? $aides ?? [] as $aide)
            <tr>
              <td>{{ $aide->membre->user->prenom }} {{ $aide->membre->user->nom }}</td>
              <td>{{ number_format($aide->montant_demande, 0, ',', ' ') }} FDJ</td>
              <td>
                @if($aide->statut == 'en_attente')
                  <span class="badge badge-yellow">⏳ En attente</span>
                @elseif($aide->statut == 'approuve')
                  <span class="badge badge-green">✅ Approuvée</span>
                @elseif($aide->statut == 'paye')
                  <span class="badge badge-blue">💵 Payée</span>
                @else
                  <span class="badge badge-red">❌ Refusée</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">Aucune demande.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Membres en retard -->
  <div class="card">
    <h2 class="section-title">⚠️ Membres en retard ce mois</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($membresEnRetard as $membre)
          <tr>
            <td><strong>{{ $membre->user->prenom }} {{ $membre->user->nom }}</strong></td>
            <td>{{ $membre->user->email }}</td>
            <td>{{ $membre->user->telephone }}</td>
            <td><span class="badge badge-red">⚠️ Pas cotisé ce mois</span></td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="text-align:center; color:var(--text-muted); padding:20px">
              ✅ Tous les membres ont cotisé ce mois !
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px">
  <h2 class="section-title" style="margin-bottom:0">⚠️ Membres en retard ce mois</h2>
  <a href="/admin/membres/alerter-retard"
     onclick="return confirm('Envoyer alerte à tous les membres en retard ?')"
     class="btn btn-orange btn-sm">
    🔔 Alerter les retardataires
  </a>
</div>
  </div>
  <div class="card" style="margin-top:24px">
  <h2 class="section-title">🏆 Top membres — Plus gros cotisants</h2>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Rang</th>
          <th>Membre</th>
          <th>Nombre cotisations</th>
          <th>Total cotisé</th>
        </tr>
      </thead>
      <tbody>
        @forelse($top_membres as $i => $membre)
        <tr>
          <td>
            @if($i == 0) 🥇
            @elseif($i == 1) 🥈
            @elseif($i == 2) 🥉
            @else {{ $i + 1 }}
            @endif
          </td>
          <td><strong>{{ $membre['nom'] }}</strong></td>
          <td>{{ $membre['nombre'] }} fois</td>
          <td><strong style="color:#059669">{{ number_format($membre['total'], 0, ',', ' ') }} FDJ</strong></td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center; color:var(--text-muted); padding:20px">Aucun membre.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

</x-app-layout>