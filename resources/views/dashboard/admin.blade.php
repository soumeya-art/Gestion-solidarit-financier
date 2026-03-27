<x-app-layout>
  <x-slot name="header">Tableau de bord</x-slot>

  <div class="stat-grid stat-grid-4">
    <div class="stat-card">
      <div class="stat-icon-box indigo">📝</div>
      <div class="stat-info">
        <div class="stat-value">{{ \App\Models\Inscription::where('statut','en_attente')->count() }}</div>
        <div class="stat-label">Inscriptions en attente</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box green">👥</div>
      <div class="stat-info">
        <div class="stat-value">{{ \App\Models\User::where('role','membre')->count() }}</div>
        <div class="stat-label">Total Membres</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box orange">🆘</div>
      <div class="stat-info">
        <div class="stat-value">{{ \App\Models\DemandeAide::where('statut','en_attente')->count() }}</div>
        <div class="stat-label">Aides en attente</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon-box blue">💰</div>
      <div class="stat-info">
        <div class="stat-value">{{ number_format(\App\Models\FondCommun::first()?->solde_disponible ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-label">Fonds disponible (FDJ)</div>
      </div>
    </div>
  </div>

  <!-- Graphiques -->
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:28px">

    <div class="card">
      <h2 class="section-title">📊 Cotisations par mois</h2>
      <canvas id="chartCotisations" height="200"></canvas>
    </div>

    <div class="card">
      <h2 class="section-title">🆘 Aides par type</h2>
      <canvas id="chartAides" height="200"></canvas>
    </div>

  </div>

  <div class="action-grid action-grid-3">
    <div class="action-card">
      <div class="action-icon" style="background:#e0e7ff">📝</div>
      <div class="action-title">Inscriptions</div>
      <div class="action-desc">Valider ou refuser les nouvelles demandes.</div>
      <a href="/admin/inscriptions" class="btn btn-indigo">Voir inscriptions →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#d1fae5">👥</div>
      <div class="action-title">Membres</div>
      <div class="action-desc">Consulter et gérer les membres actifs.</div>
      <a href="/admin/membres" class="btn btn-green">Voir membres →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#fee2e2">🆘</div>
      <div class="action-title">Demandes d'aide</div>
      <div class="action-desc">Approuver ou refuser les demandes.</div>
      <a href="/admin/aides" class="btn btn-red">Voir aides →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#fef3c7">⚙️</div>
      <div class="action-title">Règles du groupe</div>
      <div class="action-desc">Modifier les règles de cotisation et d'aide.</div>
      <a href="/admin/regles" class="btn btn-orange">Voir règles →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#ede9fe">📊</div>
      <div class="action-title">Rapports</div>
      <div class="action-desc">Consulter les statistiques financières.</div>
      <a href="/admin/rapports" class="btn btn-indigo">Voir rapports →</a>
    </div>
    <div class="action-card">
      <div class="action-icon" style="background:#dbeafe">💸</div>
      <div class="action-title">Remboursements</div>
      <div class="action-desc">Gérer les demandes de remboursement.</div>
      <a href="/admin/remboursements" class="btn btn-blue">Voir remboursements →</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données cotisations par mois
    const cotisationsData = [
        @for($i = 1; $i <= 12; $i++)
            {{ \App\Models\Cotisation::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('montant') }},
        @endfor
    ];

    // Données aides par type
    const aidesLabels = ['Médicale', 'Décès', 'Scolaire', 'Logement', 'Catastrophe', 'Naissance', 'Autre'];
    const aidesValues = [
        {{ \App\Models\DemandeAide::where('type','medicale')->count() }},
        {{ \App\Models\DemandeAide::where('type','deces')->count() }},
        {{ \App\Models\DemandeAide::where('type','scolaire')->count() }},
        {{ \App\Models\DemandeAide::where('type','logement')->count() }},
        {{ \App\Models\DemandeAide::where('type','catastrophe')->count() }},
        {{ \App\Models\DemandeAide::where('type','naissance')->count() }},
        {{ \App\Models\DemandeAide::where('type','autre')->count() }},
    ];

    // Graphique cotisations
    new Chart(document.getElementById('chartCotisations'), {
        type: 'bar',
        data: {
            labels: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
            datasets: [{
                label: 'Cotisations (FDJ)',
                data: cotisationsData,
                backgroundColor: 'rgba(99,102,241,0.7)',
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Graphique aides
    new Chart(document.getElementById('chartAides'), {
        type: 'doughnut',
        data: {
            labels: aidesLabels,
            datasets: [{
                data: aidesValues,
                backgroundColor: [
                    '#6366f1','#8b5cf6','#10b981',
                    '#f59e0b','#ef4444','#3b82f6','#94a3b8'
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
</x-app-layout>