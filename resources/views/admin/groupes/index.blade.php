<x-app-layout>
    <x-slot name="header">Gestion des groupes</x-slot>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px">
            <h2 class="section-title" style="margin:0; border:none">🏦 Liste des groupes</h2>
            <a href="/admin/groupes/creer" class="btn btn-primary">➕ Créer un groupe</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Membres</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupes as $groupe)
                    <tr>
                        <td><strong>{{ $groupe->nom }}</strong></td>
                        <td>{{ ucfirst($groupe->type) }}</td>
                        <td>{{ $groupe->nombre_membres }}</td>
                        <td>
                            @if($groupe->statut == 'actif')
                                <span class="badge badge-success">✅ Actif</span>
                            @else
                                <span class="badge badge-danger">🚫 Inactif</span>
                            @endif
                        </td>
                        <td style="display:flex; gap:8px">
                            <a href="/admin/groupes/{{ $groupe->id }}/membres" class="btn btn-primary" style="padding:6px 14px; font-size:0.8rem">
                                👥 Membres
                            </a>
                            <form method="POST" action="/admin/groupes/{{ $groupe->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce groupe ?')"
                                   class="btn btn-red btn-sm">
                                    🗑 Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="color:var(--muted); text-align:center; padding:32px">Aucun groupe pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>