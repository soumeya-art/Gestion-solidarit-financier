<x-app-layout>
  <x-slot name="header">Mes Demandes d'Aide</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card" style="margin-bottom:24px; background:#fefce8; border:1px solid #fde68a">
    <div style="display:flex; gap:12px; align-items:center">
      <div style="font-size:2rem">📋</div>
      <div>
        <div style="font-weight:700; color:#92400e">Règles pour demander une aide</div>
        <div style="font-size:0.82rem; color:#b45309; margin-top:6px; line-height:2">
          ✅ Avoir cotisé au moins 1 fois<br>
          ✅ Être membre depuis 3 mois minimum<br>
          ✅ Cotisations 3 derniers mois à jour<br>
         
          ✅ Preuve obligatoire (photo/PDF)
        </div>
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">📝 Nouvelle demande d'aide</h2>
    <form method="POST" action="/membre/aides" enctype="multipart/form-data">
      @csrf
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">

        <div class="form-group">
          <label class="form-label">Type d'aide</label>
          <select name="type" class="form-select" required>
            <option value="">-- Choisir --</option>
            <option value="medicale">🏥 Médicale</option>
            <option value="deces">⚰️ Décès</option>
            <option value="scolaire">🎓 Scolaire</option>
            <option value="logement">🏠 Logement</option>
            <option value="catastrophe">🔥 Catastrophe</option>
            <option value="naissance">👶 Naissance</option>
            <option value="autre">💼 Autre urgence</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Niveau d'urgence</label>
          <select name="urgence" class="form-select" required>
            <option value="">-- Choisir --</option>
            <option value="haute">🔴 Urgent — Décès, Maladie grave</option>
            <option value="normale">🟡 Normal — Scolaire, Logement</option>
            <option value="basse">🟢 Pas urgent — Autre</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Montant demandé (FDJ)</label>
         <input type="number" name="montant_demande"
       class="form-input" required min="1"
       placeholder="Entrez le montant souhaité">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
           
          </small>
        </div>

        <div class="form-group">
          <label class="form-label">Preuve obligatoire 📎</label>
          <input type="file" name="preuve" class="form-input"
                 required accept=".jpg,.jpeg,.png,.pdf">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
            Formats : JPG, PNG, PDF — Max 2MB
          </small>
        </div>

        <div class="form-group" style="grid-column:span 2">
          <label class="form-label">Motif détaillé</label>
          <textarea name="motif" class="form-input" rows="3"
                    required style="resize:vertical"
                    placeholder="Expliquez votre situation en détail..."></textarea>
        </div>

      </div>

      <button type="submit" class="btn btn-red">
        🆘 Envoyer la demande
      </button>

    </form>
  </div>

  <div class="card">
    <h2 class="section-title">📋 Mes demandes</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Type</th>
            <th>Urgence</th>
            <th>Montant demandé</th>
            <th>Montant approuvé</th>
            <th>Motif</th>
            <th>Date</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($demandes as $demande)
          <tr>
            <td>{{ ucfirst($demande->type) }}</td>
            <td>
              @if($demande->score_priorite == 3)
                <span class="badge badge-red">🔴 Urgent</span>
              @elseif($demande->score_priorite == 2)
                <span class="badge badge-yellow">🟡 Normal</span>
              @else
                <span class="badge badge-green">🟢 Bas</span>
              @endif
            </td>
            <td>{{ number_format($demande->montant_demande, 0, ',', ' ') }} FDJ</td>
            <td>{{ $demande->montant_approuve ? number_format($demande->montant_approuve, 0, ',', ' ') . ' FDJ' : '--' }}</td>
            <td>{{ $demande->motif }}</td>
            <td>{{ $demande->created_at->format('d/m/Y') }}</td>
            <td>
              @if($demande->statut == 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @elseif($demande->statut == 'approuve')
                <span class="badge badge-blue">✅ Approuvée</span>
              @elseif($demande->statut == 'paye')
                <span class="badge badge-green">💵 Payée</span>
              @else
                <span class="badge badge-red">❌ Refusée</span>
                @if($demande->motif_refus)
                  <br><small style="color:#ef4444; font-size:0.75rem">
                    Raison : {{ $demande->motif_refus }}
                  </small>
                @endif
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune demande pour le moment.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>