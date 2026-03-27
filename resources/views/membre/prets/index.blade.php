<x-app-layout>
    <x-slot name="header">Mes Prêts</x-slot>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    <div class="card" style="margin-bottom:24px">
        <h2 class="section-title">💳 Demander un prêt</h2>
        @if($adhesions->count() > 0)
        <form method="POST" action="/membre/prets">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
                <div class="form-group">
                    <label class="form-label">Groupe</label>
                    <select name="groupe_id" class="form-select" required>
                        <option value="">-- Choisir un groupe --</option>
                        @foreach($adhesions as $adhesion)
                            <option value="{{ $adhesion->groupe_id }}">{{ $adhesion->groupe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Montant (fdj)</label>
                    <input type="number" name="montant" class="form-input" required min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Durée (mois)</label>
                    <input type="number" name="duree" class="form-input" required min="1" max="36">
                </div>
                <div class="form-group">
                    <label class="form-label">Motif</label>
                    <input type="text" name="motif" class="form-input" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">🏦 Envoyer la demande</button>
        </form>
        @else
            <p style="color:var(--muted)">Vous n'êtes membre d'aucun groupe.</p>
        @endif
    </div>

    <div class="card">
        <h2 class="section-title">📋 Mes prêts</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Groupe</th>
                        <th>Montant</th>
                        <th>Durée</th>
                        <th>Capital restant</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prets as $pret)
                    <tr>
                        <td>{{ $pret->groupe->nom }}</td>
                        <td>{{ number_format($pret->montant_pret, 0, ',', ' ') }} fdj</td>
                        <td>{{ $pret->duree_en_mois }} mois</td>
                        <td>{{ number_format($pret->capital_restant, 0, ',', ' ') }} fdj</td>
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
                    </tr>
                    @empty
                    <tr><td colspan="5" style="color:var(--muted); text-align:center; padding:32px">Aucun prêt.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>