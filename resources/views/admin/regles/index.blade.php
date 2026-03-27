<x-app-layout>
  <x-slot name="header">Règles du Groupe</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <h2 class="section-title">⚙️ Modifier les règles du groupe</h2>
    <form method="POST" action="/admin/regles">
      @csrf

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
        <div class="form-group">
          <label class="form-label">Cotisation minimale (FDJ)</label>
          <input type="number" name="cotisation_minimale"
                 class="form-input" required min="1000"
                 value="{{ $regle?->cotisation_minimale ?? 5000 }}">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
            Montant minimum que chaque membre doit cotiser
          </small>
        </div>

        <div class="form-group">
          <label class="form-label">Fréquence</label>
          <select name="frequence" class="form-select" required>
            <option value="mensuel" {{ ($regle?->frequence == 'mensuel') ? 'selected' : '' }}>
              Mensuel
            </option>
            <option value="hebdomadaire" {{ ($regle?->frequence == 'hebdomadaire') ? 'selected' : '' }}>
              Hebdomadaire
            </option>
            <option value="trimestriel" {{ ($regle?->frequence == 'trimestriel') ? 'selected' : '' }}>
              Trimestriel
            </option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Pénalité retard (%)</label>
          <input type="number" name="penalite_retard"
                 class="form-input" required min="0" max="100"
                 step="0.5"
                 value="{{ $regle?->penalite_retard ?? 5 }}">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
            Pourcentage appliqué en cas de retard
          </small>
        </div>

        <div class="form-group">
          <label class="form-label">Plafond maximum aide (FDJ)</label>
          <input type="number" name="plafond_aide"
                 class="form-input" required min="1000"
                 value="{{ $regle?->plafond_aide ?? 50000 }}">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
            Montant maximum qu'un membre peut demander
          </small>
        </div>

        <div class="form-group" style="grid-column:span 2">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-input" rows="3"
                    style="resize:vertical"
                    placeholder="Description des règles...">{{ $regle?->description }}</textarea>
        </div>
      </div>

      <button type="submit" class="btn btn-indigo">
        💾 Sauvegarder les règles
      </button>
    </form>
  </div>

  @if($regle)
  <div class="card" style="margin-top:24px">
    <h2 class="section-title">📋 Règles actuelles</h2>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px">
      <div class="stat-card">
        <div class="stat-icon-box blue">💰</div>
        <div class="stat-info">
          <div class="stat-value">{{ number_format($regle->cotisation_minimale, 0, ',', ' ') }}</div>
          <div class="stat-label">Cotisation min (FDJ)</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-box green">🔄</div>
        <div class="stat-info">
          <div class="stat-value">{{ ucfirst($regle->frequence) }}</div>
          <div class="stat-label">Fréquence</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-box orange">⚠️</div>
        <div class="stat-info">
          <div class="stat-value">{{ $regle->penalite_retard }}%</div>
          <div class="stat-label">Pénalité retard</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-box red">🆘</div>
        <div class="stat-info">
          <div class="stat-value">{{ number_format($regle->plafond_aide, 0, ',', ' ') }}</div>
          <div class="stat-label">Plafond aide (FDJ)</div>
        </div>
      </div>
    </div>
  </div>
  @endif
</x-app-layout>