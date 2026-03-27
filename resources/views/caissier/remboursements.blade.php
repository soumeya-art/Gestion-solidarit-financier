<x-app-layout>
  <x-slot name="header">Remboursements</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">💸 Remboursements à payer</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Téléphone</th>
            <th>Montant approuvé</th>
            <th>Motif</th>
            <th>Date approbation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($remb_approuves as $demande)
          <tr>
            <td><strong>{{ $demande->membre->user->prenom }} {{ $demande->membre->user->nom }}</strong></td>
            <td>{{ $demande->membre->user->telephone }}</td>
            <td style="font-weight:700; color:#059669">{{ number_format($demande->montant_approuve, 0, ',', ' ') }} FDJ</td>
            <td>{{ $demande->motif }}</td>
            <td>{{ $demande->updated_at->format('d/m/Y') }}</td>
            <td>
              <form method="POST" action="/caissier/remboursements/{{ $demande->id }}/payer" style="display:flex; gap:6px; align-items:center">
                @csrf
                <select name="mode_paiement" class="form-select" required style="width:130px; padding:6px 10px; font-size:0.8rem">
                  <option value="">Mode...</option>
                  <option value="especes">Espèces</option>
                  <option value="waafi">Waafi</option>
                  <option value="dmoney">D-Money</option>
                </select>
                <button type="submit" class="btn btn-green btn-sm"
                  onclick="return confirm('Confirmer le paiement de {{ number_format($demande->montant_approuve, 0, ',', ' ') }} FDJ à {{ $demande->membre->user->prenom }} ?')">
                  💵 Payer
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucun remboursement à payer.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <h2 class="section-title">✅ Remboursements payés</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Montant payé</th>
            <th>Motif</th>
            <th>Date paiement</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @forelse($remb_payes as $demande)
          <tr>
            <td>{{ $demande->membre->user->prenom }} {{ $demande->membre->user->nom }}</td>
            <td style="font-weight:700">{{ number_format($demande->montant_approuve, 0, ',', ' ') }} FDJ</td>
            <td>{{ $demande->motif }}</td>
            <td>{{ $demande->updated_at->format('d/m/Y') }}</td>
            <td><span class="badge badge-green">💵 Payé</span></td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucun remboursement payé.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>
