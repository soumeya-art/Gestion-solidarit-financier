<x-app-layout>
  <x-slot name="header">Gestion des Cotisations</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">💰 Enregistrer une cotisation</h2>
    <form method="POST" action="/caissier/cotisations">
      @csrf
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
        <div class="form-group">
          <label class="form-label">Membre</label>
          <select name="membre_id" class="form-select" required>
            <option value="">-- Choisir un membre --</option>
            @foreach($membres as $user)
              @if($user->membre)
              <option value="{{ $user->membre->id }}">
                {{ $user->prenom }} {{ $user->nom }}
              </option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Montant (fdj)</label>
          <input type="number" name="montant" class="form-input"
                 required min="1" placeholder="Ex: 5000">
        </div>
      </div>
      <button type="submit" class="btn btn-green">💰 Enregistrer</button>
    </form>
  </div>

  <div class="card">
    <h2 class="section-title">📋 Historique des cotisations</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cotisations as $cotisation)
          <tr>
            <td><strong>{{ $cotisation->membre->user->prenom }} {{ $cotisation->membre->user->nom }}</strong></td>
            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} fdj</td>
            <td>{{ $cotisation->created_at->format('d/m/Y') }}</td>
            <td><span class="badge badge-green">✅ Payée</span></td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune cotisation.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>