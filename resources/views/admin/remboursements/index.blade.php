<x-app-layout>
  <x-slot name="header">Gestion des Remboursements</x-slot>

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif

  <div class="card">
    <h2 class="section-title">💸 Demandes de remboursement</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Montant demandé</th>
            <th>Motif</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($demandes as $demande)
          <tr>
            <td><strong>{{ $demande->membre->user->prenom }} {{ $demande->membre->user->nom }}</strong></td>
            <td>{{ number_format($demande->montant_demande, 0, ',', ' ') }} fdj</td>
            <td>{{ $demande->motif }}</td>
            <td>{{ $demande->created_at->format('d/m/Y') }}</td>
            <td>
              @if($demande->statut == 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @elseif($demande->statut == 'approuve')
                <span class="badge badge-green">✅ Approuvé</span>
              @else
                <span class="badge badge-red">❌ Refusé</span>
              @endif
            </td>
            <td>
              @if($demande->statut == 'en_attente')
              <form method="POST" action="/admin/remboursements/{{ $demande->id }}/approuver" style="display:inline">
                @csrf
                <input type="number" name="montant_approuve"
                  placeholder="Montant" class="form-input"
                  style="width:120px; display:inline; padding:6px 10px; margin-right:6px"
                  required min="1" value="{{ $demande->montant_demande }}">
                <button type="submit" class="btn btn-green btn-sm"
                  onclick="return confirm('Approuver ce remboursement ?')">✅ Approuver</button>
              </form>
              <a href="/admin/remboursements/{{ $demande->id }}/refuser"
                 onclick="return confirm('Refuser ce remboursement ?')"
                 class="btn btn-red btn-sm">❌ Refuser</a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune demande de remboursement.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>