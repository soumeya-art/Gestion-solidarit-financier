<x-app-layout>
  <x-slot name="header">Mon Profil</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px">

    <!-- Infos personnelles -->
    <div class="card">
      <h2 class="section-title">👤 Mes informations</h2>
      <form method="POST" action="/membre/profil">
        @csrf
        <div class="form-group">
          <label class="form-label">Nom</label>
          <input type="text" name="nom" class="form-input"
                 value="{{ $user->nom }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Prénom</label>
          <input type="text" name="prenom" class="form-input"
                 value="{{ $user->prenom }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-input"
                 value="{{ $user->email }}" disabled
                 style="background:#f1f5f9; cursor:not-allowed">
          <small style="color:#94a3b8; font-size:0.75rem">
            L'email ne peut pas être modifié
          </small>
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone</label>
          <input type="text" name="telephone" class="form-input"
                 value="{{ $user->telephone }}" required>
        </div>
        <button type="submit" class="btn btn-indigo">
          💾 Sauvegarder
        </button>
      </form>
    </div>

    <!-- Changer mot de passe -->
    <div class="card">
      <h2 class="section-title">🔒 Changer mot de passe</h2>
      <form method="POST" action="/membre/profil/password">
        @csrf
        <div class="form-group">
          <label class="form-label">Mot de passe actuel</label>
          <input type="password" name="current_password"
                 class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nouveau mot de passe</label>
          <input type="password" name="password"
                 class="form-input" required minlength="6">
        </div>
        <div class="form-group">
          <label class="form-label">Confirmer</label>
          <input type="password" name="password_confirmation"
                 class="form-input" required>
        </div>
        <button type="submit" class="btn btn-orange">
          🔒 Changer
        </button>
      </form>
    </div>
  </div>

  <!-- Statistiques -->
  @if($compte)
  <div class="stat-grid stat-grid-3" style="margin-bottom:24px">
    <div class="stat-card">
      <div class="stat-icon-box blue">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($compte->total_cotise, 0, ',', ' ') }}</div>
        <div class="stat-label">Total cotisé (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box green">📊</div>
      <div class="stat-info">
        <div class="stat-value">{{ $cotisations->count() }}</div>
        <div class="stat-label">Nombre de cotisations</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🆘</div>
      <div class="stat-info">
        <div class="stat-value">{{ $aides->count() }}</div>
        <div class="stat-label">Demandes d'aide</div>
      </div>
    </div>
  </div>
  @endif

  <!-- Historique cotisations -->
  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">💰 Historique cotisations</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Montant</th>
            <th>Date</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cotisations as $cotisation)
          <tr>
            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FDJ</td>
            <td>{{ $cotisation->created_at->format('d/m/Y') }}</td>
            <td><span class="badge badge-green">✅ Payée</span></td>
          </tr>
          @empty
          <tr>
            <td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px">
              Aucune cotisation.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Historique aides -->
  <div class="card">
    <h2 class="section-title">🆘 Historique demandes d'aide</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
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
            <td>{{ ucfirst($aide->type) }}</td>
            <td>{{ number_format($aide->montant_demande, 0, ',', ' ') }} FDJ</td>
            <td>{{ $aide->montant_approuve ? number_format($aide->montant_approuve, 0, ',', ' ') . ' FDJ' : '--' }}</td>
            <td>{{ $aide->created_at->format('d/m/Y') }}</td>
            <td>
              @if($aide->statut == 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @elseif($aide->statut == 'approuve')
                <span class="badge badge-blue">✅ Approuvée</span>
              @elseif($aide->statut == 'paye')
                <span class="badge badge-green">💵 Payée</span>
              @else
                <span class="badge badge-red">❌ Refusée</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center; color:var(--text-muted); padding:20px">
              Aucune demande.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>