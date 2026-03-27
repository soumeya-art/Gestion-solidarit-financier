<x-app-layout>
  <x-slot name="header">Aides à Remettre</x-slot>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card" style="margin-bottom:24px">
    <h2 class="section-title">✅ Aides approuvées — À payer</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Priorité</th>
            <th>Membre</th>
            <th>Type</th>
            <th>Montant</th>
            <th>Motif</th>
            <th>Mode paiement</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($aides_approuvees as $aide)
          <tr>
            <td>
              @if($aide->score_priorite == 3)
                <span class="badge badge-red">🔴 Urgent</span>
              @elseif($aide->score_priorite == 2)
                <span class="badge badge-yellow">🟡 Normal</span>
              @else
                <span class="badge badge-green">🟢 Bas</span>
              @endif
            </td>
            <td>
              <strong>{{ $aide->membre->user->prenom }} {{ $aide->membre->user->nom }}</strong>
              <br><small style="color:#94a3b8">{{ $aide->membre->user->telephone }}</small>
            </td>
            <td>{{ ucfirst($aide->type) }}</td>
            <td><strong style="color:#10b981">{{ number_format($aide->montant_approuve, 0, ',', ' ') }} FDJ</strong></td>
            <td>{{ $aide->motif }}</td>
            <td>
              <form method="POST" action="/caissier/aides/{{ $aide->id }}/payer">
                @csrf
                <select name="mode_paiement" class="form-select"
                        style="width:120px; padding:6px; margin-bottom:6px" required>
                  <option value="">-- Mode --</option>
                  <option value="especes">💵 Espèces</option>
                  <option value="waafi">📱 Waafi Pay</option>
                  <option value="dmoney">📱 D-Money</option>
                </select>
                <input type="text" name="reference_paiement"
                       class="form-input"
                       style="width:120px; padding:6px; margin-bottom:6px"
                       placeholder="Référence (optionnel)">
                <button type="submit" class="btn btn-green btn-sm"
                  onclick="return confirm('Confirmer le paiement ?')">
                  💵 Confirmer
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:32px">
              Aucune aide à payer.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <h2 class="section-title">💵 Aides déjà payées</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Membre</th>
            <th>Montant</th>
            <th>Mode paiement</th>
            <th>Référence</th>
            <th>Date</th>
            <th>Reçu</th>
          </tr>
        </thead>
        <tbody>
          @forelse($aides_payees as $aide)
          <tr>
            <td>{{ $aide->membre->user->prenom }} {{ $aide->membre->user->nom }}</td>
            <td>{{ number_format($aide->montant_approuve, 0, ',', ' ') }} FDJ</td>
            <td>
              @if($aide->mode_paiement == 'especes') 💵 Espèces
              @elseif($aide->mode_paiement == 'waafi') 📱 Waafi Pay
              @elseif($aide->mode_paiement == 'dmoney') 📱 D-Money
              @endif
            </td>
            <td>{{ $aide->reference_paiement ?? '--' }}</td>
            <td>{{ $aide->updated_at->format('d/m/Y') }}</td>
            <td>
              <a href="/caissier/aides/{{ $aide->id }}/recu"
                 class="btn btn-blue btn-sm" target="_blank">
                🧾 Reçu
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:20px">
              Aucune aide payée.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>