<x-app-layout>
  <x-slot name="header">Demande de Remboursement</x-slot>

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">❌ {{ session('error') }}</div>
  @endif

  @if($compte)
  <div class="stat-grid stat-grid-3" style="margin-bottom:24px">
    <div class="stat-card">
      <div class="stat-icon-box green">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format($compte->total_cotise, 0, ',', ' ') }}</div>
        <div class="stat-label">Total cotisé (fdj)</div>
      </div>
    </div>
  </div>
  @endif

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">💸 Nouvelle demande de remboursement</h2>
    <form method="POST" action="/membre/remboursements">
      @csrf
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
        <div class="form-group">
          <label class="form-label">Montant demandé (fdj)</label>
          <input type="number" name="montant_demande" class="form-input"
                 required min="1"
                 placeholder="Ex: 25000"
                 max="{{ $compte?->total_cotise ?? 999999 }}">
        </div>
        <div class="form-group">
          <label class="form-label">Motif</label>
          <input type="text" name="motif" class="form-input"
                 required placeholder="Raison du remboursement">
        </div>
      </div>
      <button type="submit" class="btn btn-blue">💸 Envoyer la demande</button>
    </form>
  </div>

  <div class="card">
    <h2 class="section-title">📋 Mes demandes de remboursement</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Montant demandé</th>
            <th>Montant approuvé</th>
            <th>Motif</th>
            <th>Date</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($demandes as $demande)
          <tr>
            <td>{{ number_format($demande->montant_demande, 0, ',', ' ') }} fdj</td>
            <td>{{ $demande->montant_approuve ? number_format($demande->montant_approuve, 0, ',', ' ') . ' fdj' : '--' }}</td>
            <td>{{ $demande->motif }}</td>
            <td>{{ $demande->created_at->format('d/m/Y') }}</td>
            <td>
              @if($demande->statut == 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @elseif($demande->statut == 'approuve')
                <span class="badge badge-blue">✅ Approuvé (en cours de paiement)</span>
              @elseif($demande->statut == 'paye')
                <span class="badge badge-green">💵 Payé</span>
              @else
                <span class="badge badge-red">❌ Refusé</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune demande pour le moment.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>