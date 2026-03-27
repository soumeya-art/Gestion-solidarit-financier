<x-app-layout>
    <x-slot name="header">Ajouter un membre</x-slot>

    <div class="card" style="max-width:600px; margin:0 auto">
        <h2 class="section-title">➕ Nouveau membre</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>❌ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/admin/membres/ajouter">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-input" value="{{ old('nom') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-input" value="{{ old('prenom') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-input" value="{{ old('telephone') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-input" value="{{ old('adresse') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px">
                <a href="/admin/membres" class="btn btn-gray">← Retour</a>
                <button type="submit" class="btn btn-primary">✅ Ajouter le membre</button>
            </div>
        </form>
    </div>
</x-app-layout>