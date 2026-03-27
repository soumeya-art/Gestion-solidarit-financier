<x-app-layout>
  <x-slot name="header">Gestion des inscriptions</x-slot>

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif

  <div class="card">
    <h2 class="section-title">📝 Demandes d'inscription</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inscriptions as $inscription)
          <tr>
            <td><strong>{{ $inscription->nom }}</strong></td>
            <td>{{ $inscription->prenom }}</td>
            <td>{{ $inscription->email }}</td>
            <td>{{ $inscription->telephone }}</td>
            <td>{{ $inscription->created_at->format('d/m/Y') }}</td>
            <td>
              @if($inscription->statut == 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @elseif($inscription->statut == 'accepte')
                <span class="badge badge-green">✅ Accepté</span>
              @else
                <span class="badge badge-red">❌ Refusé</span>
              @endif
            </td>
            <td style="display:flex; gap:8px">
              @if($inscription->statut == 'en_attente')
              <a href="/admin/inscriptions/{{ $inscription->id }}/accepter"
                 onclick="return confirm('Accepter cette inscription ?')"
                 class="btn btn-green btn-sm">✅ Accepter</a>
              <a href="/admin/inscriptions/{{ $inscription->id }}/refuser"
                 onclick="return confirm('Refuser cette inscription ?')"
                 class="btn btn-red btn-sm">❌ Refuser</a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune inscription pour le moment.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>