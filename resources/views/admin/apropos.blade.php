<x-app-layout>
  <x-slot name="header">À propos du groupe</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @php $regle = \App\Models\RegleGroupe::first(); @endphp

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px">

    <div class="card">
      <h2 class="section-title">📋 Informations du groupe</h2>
      <div style="display:flex; flex-direction:column; gap:16px">
        <div style="background:#f8fafc; border-radius:12px; padding:16px">
          <div style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700; margin-bottom:6px">Nom du groupe</div>
          <div style="font-size:1rem; font-weight:700; color:var(--text-dark)">Gestion Solidarité Financière</div>
        </div>
        <div style="background:#f8fafc; border-radius:12px; padding:16px">
          <div style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700; margin-bottom:6px">Cotisation mensuelle</div>
          <div style="font-size:1rem; font-weight:700; color:#6366f1">{{ number_format($regle?->cotisation_minimale ?? 5000, 0, ',', ' ') }} FDJ</div>
        </div>
        <div style="background:#f8fafc; border-radius:12px; padding:16px">
          <div style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700; margin-bottom:6px">Pénalité retard</div>
          <div style="font-size:1rem; font-weight:700; color:#ef4444">{{ $regle?->penalite_retard ?? 5 }}%</div>
        </div>
        <div style="background:#f8fafc; border-radius:12px; padding:16px">
          <div style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700; margin-bottom:6px">Description</div>
          <div style="font-size:0.875rem; color:var(--text-dark); line-height:1.6">{{ $regle?->description ?? 'Groupe de solidarité financière communautaire' }}</div>
        </div>
      </div>
    </div>

    <div class="card">
      <h2 class="section-title">📊 Statistiques globales</h2>
      <div style="display:flex; flex-direction:column; gap:12px">
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Total membres</span>
          <strong>{{ \App\Models\User::where('role','membre')->count() }}</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Total cotisations</span>
          <strong style="color:#059669">{{ number_format(\App\Models\Cotisation::sum('montant'), 0, ',', ' ') }} FDJ</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Total aides versées</span>
          <strong style="color:#ef4444">{{ number_format(\App\Models\DemandeAide::where('statut','approuve')->sum('montant_approuve'), 0, ',', ' ') }} FDJ</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Fonds disponible</span>
          <strong style="color:#6366f1">{{ number_format(\App\Models\FondCommun::first()?->solde_disponible ?? 0, 0, ',', ' ') }} FDJ</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Membres actifs</span>
          <strong>{{ \App\Models\User::where('role','membre')->where('statut','actif')->count() }}</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px">
          <span style="color:var(--text-muted)">Membres suspendus</span>
          <strong style="color:#ef4444">{{ \App\Models\User::where('role','membre')->where('statut','suspendu')->count() }}</strong>
        </div>
      </div>
    </div>

  </div>
</x-app-layout>