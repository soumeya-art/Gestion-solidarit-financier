<x-app-layout>
    <x-slot name="header">Gestion des prêts</x-slot>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="card">
        <h2 class="section-title">💳 Demandes de prêt</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Groupe</th>
                        <th>Montant</th>
                        <th>Durée</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prets as $pret)
                    <tr>
                        <td><strong>{{ $pret->membre->user->nom }} {{ $pret->membre->user->prenom }}</strong></td>
                        <td>{{ $pret->groupe->nom }}</td>
                        <td>{{ number_format($pret->montant_pret, 0, ',', ' ') }} fdj</td>
                        <td>{{ $pret->duree_en_mois }} mois</td>
                        <td>{{ $pret->motif }}</td>
                        <td>
                            @if($pret->statut == 'en_attente')
                                <span class="badge badge-warning">⏳ En attente</span>
                            @elseif($pret->statut == 'approuve')
                                <span class="badge badge-success">✅ Approuvé</span>
                            @elseif($pret->statut == 'refuse')
                                <span class="badge badge-danger">❌ Refusé</span>
                            @elseif($pret->statut == 'rembourse')
                                <span class="badge badge-info">💰 Remboursé</span>
                            @endif
                        </td>
                        <td style="display:flex; gap:8px">
                            @if($pret->statut == 'en_attente')
                            <a href="/admin/prets/{{ $pret->id }}/approuver"
                               onclick="return confirm('Approuver ce prêt ?')"
                            class="btn btn-red btn-sm">❌</a>
                            <a href="/admin/prets/{{ $pret->id }}/refuser"
                               onclick="return confirm('Refuser ce prêt ?')"
                               class="btn btn-danger" style="padding:6px 14px; font-size:0.8rem">❌</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="color:var(--muted); text-align:center; padding:32px">Aucune demande de prêt.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>