<x-app-layout>
  <x-slot name="header">Gestion des Aides</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card">
    <h2 class="section-title">🆘 Demandes d'aide</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            
            <th>Type</th>
            <th>Montant</th>
            <th>Motif</th>
            <th>Preuve</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
            <th>Priorité</th>
          </tr>
        </thead>
        <tbody>
          @forelse($demandes as $demande)
          <tr>
            <td><strong>{{ $demande->membre->user->prenom }} {{ $demande->membre->user->nom }}</strong></td>
            <td>
              @if($demande->score_priorite == 3)
                <span class="badge badge-red">🔴 Urgent</span>
              @elseif($demande->score_priorite == 2)
                <span class="badge badge-yellow">🟡 Normal</span>
              @else
                <span class="badge badge-green">🟢 Bas</span>
              @endif
            </td>
            <td>{{ ucfirst($demande->type) }}</td>
            <td>{{ number_format($demande->montant_demande, 0, ',', ' ') }} fdj</td>
            <td>{{ $demande->motif }}</td>
            <td>
              @if($demande->preuve)
                <a href="{{ asset('storage/' . $demande->preuve) }}"
                   target="_blank" class="btn btn-blue btn-sm">
                   📎 Voir
                </a>
              @else
                <span style="color:var(--text-muted)">--</span>
              @endif
            </td>
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
                  <br><small style="color:#94a3b8; font-size:0.72rem">
                    {{ $demande->motif_refus }}
                  </small>
                @endif
              @endif
            </td>
            <td>
              @if($demande->statut == 'en_attente')
              <form method="POST"
                    action="/admin/aides/{{ $demande->id }}/approuver"
                    style="margin-bottom:8px">
                @csrf
                <div style="display:flex; gap:6px; align-items:center">
                 <input type="number" name="montant_approuve"
  placeholder="Montant"
  class="form-input"
  style="width:110px; display:inline; padding:6px 10px; margin-right:4px"
  required min="1">
                   
                  <button type="submit" class="btn btn-green btn-sm"
                    onclick="return confirm('Approuver ?')">
                    ✅ Approuver
                  </button>
                </div>
              </form>
              <form method="POST"
                    action="/admin/aides/{{ $demande->id }}/refuser">
                @csrf
                <div style="display:flex; gap:6px; align-items:center">
                  <input type="text" name="motif_refus"
                    class="form-input"
                    style="width:150px; padding:6px 10px"
                    required placeholder="Raison du refus">
                  <button type="submit" class="btn btn-red btn-sm"
                    onclick="return confirm('Refuser ?')">
                    ❌ Refuser
                  </button>
                </div>
              </form>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" style="text-align:center;
              color:var(--text-muted); padding:32px">
              Aucune demande d'aide.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>