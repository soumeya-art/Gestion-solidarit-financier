<x-app-layout>
  <x-slot name="header">Mes Cotisations</x-slot>

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">❌ {{ session('error') }}</div>
  @endif

  {{-- Règles du groupe --}}
  @php $regle = \App\Models\RegleGroupe::first(); @endphp
  @if($regle)
  <div class="card" style="margin-bottom:24px; background:linear-gradient(135deg,#e0e7ff,#f5f3ff); border:1px solid #c7d2fe">
    <h2 style="font-size:0.95rem; font-weight:700; color:#4338ca; margin-bottom:16px">📋 Règles du groupe</h2>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px">
      <div style="text-align:center">
        <div style="font-size:1.3rem; font-weight:800; color:#6366f1">{{ number_format($regle->cotisation_minimale, 0, ',', ' ') }} FDJ</div>
        <div style="font-size:0.75rem; color:#6366f1">Cotisation fixe</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.3rem; font-weight:800; color:#6366f1">{{ ucfirst($regle->frequence) }}</div>
        <div style="font-size:0.75rem; color:#6366f1">Fréquence</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.3rem; font-weight:800; color:#6366f1">{{ $regle->penalite_retard }}%</div>
        <div style="font-size:0.75rem; color:#6366f1">Pénalité retard</div>
      </div>
    </div>
  </div>
  @endif

  {{-- Formulaire paiement --}}
  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">💳 Payer une cotisation</h2>
    <form method="POST" action="/membre/cotisations">
      @csrf
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
        <div class="form-group">
          <label class="form-label">Montant (FDJ)</label>
          <input type="number" name="montant" class="form-input"
                 required placeholder="Saisissez {{ number_format($regle?->cotisation_minimale ?? 5000, 0, ',', ' ') }} FDJ">
          <small style="color:#94a3b8; font-size:0.75rem; margin-top:4px; display:block">
            ⚠️ Le montant doit être exactement <strong>{{ number_format($regle?->cotisation_minimale ?? 5000, 0, ',', ' ') }} FDJ</strong>
            @if(now()->day > 30)
              &nbsp;|&nbsp; <span style="color:#ef4444">⚠️ Pénalité retard : {{ $regle?->penalite_retard ?? 5 }}%</span>
            @endif
          </small>
        </div>
      </div>
      <button type="submit" class="btn btn-green">💰 Payer</button>
    </form>
  </div>

  {{-- Historique --}}
  <div class="card">
    <h2 class="section-title">📋 Historique des cotisations</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Montant</th>
            <th>Pénalité</th>
            <th>Total payé</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Reçu</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cotisations as $cotisation)
          <tr>
            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FDJ</td>
            <td>
              @if($cotisation->en_retard ?? false)
                <span class="badge badge-red">+{{ number_format($cotisation->penalite ?? 0, 0, ',', ' ') }} FDJ</span>
              @else
                <span class="badge badge-green">Aucune</span>
              @endif
            </td>
            <td>
              <strong>{{ number_format($cotisation->montant_total ?? $cotisation->montant, 0, ',', ' ') }} FDJ</strong>
            </td>
            <td>{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}</td>
            <td><span class="badge badge-green">✅ Payée</span></td>
            <td>
              <a href="/membre/cotisations/{{ $cotisation->id }}/recu"
                 class="btn btn-blue btn-sm">🧾 Reçu</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune cotisation pour le moment.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>
