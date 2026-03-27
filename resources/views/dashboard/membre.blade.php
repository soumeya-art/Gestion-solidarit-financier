<x-app-layout>
  <x-slot name="header">Mon Tableau de bord</x-slot>

  @php
    $membre = \App\Models\Membre::where('user_id', auth()->id())->first();
    $compte = $membre ? \App\Models\CompteMembre::where('membre_id', $membre->id)->first() : null;
    $nb_cotisations = $membre ? \App\Models\Cotisation::where('membre_id', $membre->id)->count() : 0;
    $nb_aides = $membre ? \App\Models\DemandeAide::where('membre_id', $membre->id)->count() : 0;
    $adhesion = $membre ? \App\Models\Adhesion::where('membre_id', $membre->id)->first() : null;
    $regle = \App\Models\RegleGroupe::first();
    $notifications_non_lues = \App\Models\Notification::where('user_id', auth()->id())->where('statut', 'non_lu')->count();
  @endphp

  <!-- Stat cards -->
  <div class="stat-grid stat-grid-4">
    <div class="stat-card">
      <div class="stat-icon-box blue">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($compte?->total_cotise ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Total cotisé (FDJ)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box green">📊</div>
      <div class="stat-info">
        <div class="stat-value">{{ $nb_cotisations }}</div>
        <div class="stat-label">Cotisations effectuées</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🆘</div>
      <div class="stat-info">
        <div class="stat-value">{{ $nb_aides }}</div>
        <div class="stat-label">Demandes d'aide</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box purple">🔔</div>
      <div class="stat-info">
        <div class="stat-value">{{ $notifications_non_lues }}</div>
        <div class="stat-label">Notifications non lues</div>
      </div>
    </div>
  </div>

  <!-- Statut membre -->
  @if($adhesion)
  <div class="card" style="margin-bottom:24px; background:linear-gradient(135deg,#e0e7ff,#f5f3ff); border:1px solid #c7d2fe">
    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap">
      <div style="font-size:2.5rem">👤</div>
      <div style="flex:1">
        <div style="font-weight:700; color:#4338ca; font-size:1rem">
          {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
        </div>
        <div style="font-size:0.82rem; color:#6366f1; margin-top:4px">
          Membre depuis le {{ \Carbon\Carbon::parse($adhesion->date_adhesion)->format('d/m/Y') }}
          &nbsp;|&nbsp;
          Statut :
          @if($adhesion->statut == 'actif')
            <span style="color:#059669; font-weight:700">✅ Actif</span>
          @else
            <span style="color:#dc2626; font-weight:700">⛔ Suspendu</span>
          @endif
        </div>
      </div>
      @if($regle)
      <div style="background:rgba(99,102,241,0.1); border-radius:12px; padding:12px 20px; text-align:center">
        <div style="font-size:1.2rem; font-weight:800; color:#6366f1">{{ number_format($regle->cotisation_minimale, 0, ',', ' ') }} FDJ</div>
        <div style="font-size:0.72rem; color:#6366f1">Cotisation {{ $regle->frequence }}</div>
      </div>
      @endif
    </div>
  </div>
  @endif

  <!-- Actions -->
  <div class="action-grid action-grid-2">
    <div class="action-card">
      <div class="action-icon" style="background:#d1fae5">💵</div>
      <div class="action-title">Payer une cotisation</div>
      <div class="action-desc">Effectuez votre cotisation mensuelle de {{ number_format($regle?->cotisation_minimale ?? 5000, 0, ',', ' ') }} FDJ minimum.</div>
      <a href="/membre/cotisations" class="btn btn-green">Payer maintenant →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#fee2e2">🆘</div>
      <div class="action-title">Demander une aide</div>
      <div class="action-desc">En cas d'urgence, demandez une aide financière au groupe.</div>
      <a href="/membre/aides" class="btn btn-red">Demander une aide →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#dbeafe">💸</div>
      <div class="action-title">Remboursement</div>
      <div class="action-desc">Demandez un remboursement si vous quittez le groupe.</div>
      <a href="/membre/remboursements" class="btn btn-blue">Demander →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#ede9fe">👤</div>
      <div class="action-title">Mon Profil</div>
      <div class="action-desc">Modifier vos informations personnelles et mot de passe.</div>
      <a href="/membre/profil" class="btn btn-indigo">Voir profil →</a>
    </div>
  </div>

</x-app-layout>