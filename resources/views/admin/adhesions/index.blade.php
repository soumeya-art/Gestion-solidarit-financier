<x-app-layout>
    <x-slot name="header">Membres du groupe — {{ $groupe->nom }}</x-slot>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    <div class="card" style="margin-bottom:24px">
        <h2 class="section-title">➕ Ajouter un membre au groupe</h2>
        <form method="POST" action="/admin/groupes/{{ $groupe->id }}/membres" style="display:flex; gap:12px; align-items:flex-end">
            @csrf
            <div class="form-group" style="flex:1; margin:0">
                <label class="form-label">Choisir un membre</label>
                <select name="membre_id" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($membres as $membre)
                        <option value="{{ $membre->id }}">{{ $membre->user->nom }} {{ $membre->user->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">➕ Ajouter</button>
        </form>
    </div>

    <div class="card">
        <h2 class="section-title">👥 Membres du groupe</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rôle</th>
                        <th>Date adhésion</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adhesions as $adhesion)
                    <tr>
                        <td>{{ $adhesion->membre->user->nom }}</td>
                        <td>{{ $adhesion->membre->user->prenom }}</td>
                        <td>{{ ucfirst($adhesion->role) }}</td>
                        <td>{{ $adhesion->date_adhesion }}</td>
                        <td>
                            @if($adhesion->statut == 'actif')
                                <span class="badge badge-success">✅ Actif</span>
                            @else
                                <span class="badge badge-danger">🚫 Suspendu</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="/admin/groupes/{{ $groupe->id }}/membres/{{ $adhesion->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Retirer ce membre ?')"
                                    class="btn btn-red btn-sm">
                                    🗑 Retirer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="color:var(--muted); text-align:center; padding:32px">Aucun membre dans ce groupe.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px">
            <a href="/admin/groupes" class="btn btn-gray">← Retour aux groupes</a>
        </div>
    </div>
</x-app-layout>