<x-app-layout>
    <x-slot name="header">Créer un groupe</x-slot>

    <div class="card" style="max-width:600px; margin:0 auto">
        <h2 class="section-title">🏦 Nouveau groupe de solidarité</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>❌ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/admin/groupes/creer">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Nom du groupe</label>
                    <input type="text" name="nom" class="form-input" value="{{ old('nom') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="tontine">Tontine</option>
                        <option value="mutuelle">Mutuelle</option>
                        <option value="cooperative">Coopérative</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Fréquence</label>
                    <select name="frequence" class="form-select" required>
                        <option value="mensuel">Mensuel</option>
                        <option value="hebdomadaire">Hebdomadaire</option>
                        <option value="trimestriel">Trimestriel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Cotisation minimale (fdj)</label>
                    <input type="number" name="cotisation_minimale" class="form-input" value="{{ old('cotisation_minimale') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Plafond prêt (fdj)</label>
                    <input type="number" name="plafond_pret" class="form-input" value="{{ old('plafond_pret') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Taux d'intérêt (%)</label>
                    <input type="number" name="taux_interet" step="0.01" class="form-input" value="{{ old('taux_interet') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pénalité retard (%)</label>
                    <input type="number" name="penalite_retard" step="0.01" class="form-input" value="{{ old('penalite_retard') }}" required>
                </div>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px">
                <a href="/admin/groupes" class="btn btn-gray">← Retour</a>
                <button type="submit" class="btn btn-primary">✅ Créer le groupe</button>
            </div>
        </form>
    </div>
</x-app-layout>