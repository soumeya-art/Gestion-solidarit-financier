<x-app-layout>
  <x-slot name="header">Gestion des Membres</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">📢 Envoyer notification à tous les membres</h2>
    <form method="POST" action="{{ route('admin.membres.notifier') }}">
      @csrf
      <div style="display:flex; gap:12px; align-items:flex-end">
        <div class="form-group" style="flex:1; margin-bottom:0">
          <label class="form-label">Message</label>
          <input type="text" name="message" class="form-input"
                 required placeholder="Ex: Réunion le 30/03 à 18h...">
        </div>
        <button type="submit" class="btn btn-indigo">📢 Envoyer à tous</button>
      </div>
    </form>
  </div>

  <div class="card">
    <h2 class="section-title">👥 Liste des membres</h2>

    <div style="margin-bottom:16px">
      <input type="text" id="search" class="form-input"
             style="max-width:300px"
             placeholder="🔍 Rechercher un membre..."
             onkeyup="searchMembre()">
    </div>

    <div class="table-wrap">
      <table id="table-membres">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Total cotisé</th>
            <th>Dernière cotisation</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($membres as $user)
          <tr>
            <td><strong>{{ $user->prenom }} {{ $user->nom }}</strong></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->telephone }}</td>
            <td>
              @php
                $total = $user->membre ? \App\Models\Cotisation::where('membre_id', $user->membre->id)->sum('montant') : 0;
              @endphp
              <strong style="color:#059669">{{ number_format($total, 0, ',', ' ') }} FDJ</strong>
            </td>
            <td>
              @php
                $derniere = $user->membre ? \App\Models\Cotisation::where('membre_id', $user->membre->id)->orderBy('created_at','desc')->first() : null;
              @endphp
              @if($derniere)
                {{ $derniere->created_at->format('d/m/Y') }}
              @else
                <span style="color:var(--text-muted)">Jamais</span>
              @endif
            </td>
            <td>
              @if($user->statut == 'actif')
                <span class="badge badge-green">✅ Actif</span>
              @else
                <span class="badge badge-red">⛔ Suspendu</span>
              @endif
            </td>
            <td style="display:flex; gap:6px; flex-wrap:wrap">
              @if($user->statut == 'actif')
                <a href="/admin/membres/{{ $user->id }}/suspendre"
                   onclick="return confirm('Suspendre ce membre ?')"
                   class="btn btn-orange btn-sm">⚠️ Suspendre</a>
              @else
                <a href="/admin/membres/{{ $user->id }}/reactiver"
                   onclick="return confirm('Réactiver ce membre ?')"
                   class="btn btn-green btn-sm">✅ Réactiver</a>
              @endif
              <a href="/admin/membres/exclure/{{ $user->id }}"
                 onclick="return confirm('Supprimer ce membre ?')"
                 class="btn btn-red btn-sm">❌ Supprimer</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucun membre.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>

<script>
function searchMembre() {
    const input = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#table-membres tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>