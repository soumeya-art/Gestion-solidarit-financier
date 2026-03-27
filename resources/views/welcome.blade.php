<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion Solidarité Financière</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; margin:0; padding:0; box-sizing:border-box; }
    body { background:#0f172a; color:white; min-height:100vh; }

    /* NAVBAR */
    .navbar {
      padding: 20px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .navbar-brand { display:flex; align-items:center; gap:12px; }
    .navbar-logo { width:42px; height:42px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
    .navbar-name { font-size:1rem; font-weight:800; color:white; }
    .navbar-links { display:flex; gap:12px; }
    .btn-login { padding:10px 24px; border:1.5px solid rgba(255,255,255,0.2); border-radius:10px; color:white; text-decoration:none; font-weight:600; font-size:0.875rem; transition:all 0.2s; }
    .btn-login:hover { background:rgba(255,255,255,0.08); }
    .btn-register { padding:10px 24px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:10px; color:white; text-decoration:none; font-weight:600; font-size:0.875rem; box-shadow:0 4px 12px rgba(99,102,241,0.4); transition:all 0.2s; }
    .btn-register:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(99,102,241,0.5); }

    /* HERO */
    .hero {
      padding: 80px 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content:'';
      position:absolute;
      width:600px; height:600px;
      border-radius:50%;
      background:radial-gradient(circle,rgba(99,102,241,0.15),transparent);
      top:-200px; right:-100px;
    }
    .hero::after {
      content:'';
      position:absolute;
      width:400px; height:400px;
      border-radius:50%;
      background:radial-gradient(circle,rgba(139,92,246,0.1),transparent);
      bottom:-100px; left:-100px;
    }
    .hero-badge {
      display:inline-block;
      background:rgba(99,102,241,0.2);
      border:1px solid rgba(99,102,241,0.4);
      color:#a5b4fc;
      padding:6px 16px;
      border-radius:20px;
      font-size:0.8rem;
      font-weight:600;
      margin-bottom:24px;
    }
    .hero h1 {
      font-size:3.5rem;
      font-weight:800;
      line-height:1.1;
      margin-bottom:20px;
      background:linear-gradient(135deg,#fff,#a5b4fc);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
    }
    .hero p {
      color:rgba(255,255,255,0.6);
      font-size:1.1rem;
      max-width:600px;
      margin:0 auto 40px;
      line-height:1.7;
    }
    .hero-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; margin-bottom:60px; }
    .hero-btn-primary {
      padding:16px 40px;
      background:linear-gradient(135deg,#6366f1,#8b5cf6);
      border-radius:14px;
      color:white;
      text-decoration:none;
      font-weight:700;
      font-size:1rem;
      box-shadow:0 8px 24px rgba(99,102,241,0.4);
      transition:all 0.2s;
    }
    .hero-btn-primary:hover { transform:translateY(-2px); }
    .hero-btn-secondary {
      padding:16px 40px;
      background:rgba(255,255,255,0.06);
      border:1.5px solid rgba(255,255,255,0.15);
      border-radius:14px;
      color:white;
      text-decoration:none;
      font-weight:700;
      font-size:1rem;
      transition:all 0.2s;
    }
    .hero-btn-secondary:hover { background:rgba(255,255,255,0.1); }

    /* STATS */
    .stats {
      display:flex;
      justify-content:center;
      gap:48px;
      flex-wrap:wrap;
      padding:32px 60px;
      background:rgba(255,255,255,0.03);
      border-top:1px solid rgba(255,255,255,0.06);
      border-bottom:1px solid rgba(255,255,255,0.06);
      margin-bottom:80px;
    }
    .stat-item { text-align:center; }
    .stat-number { font-size:2rem; font-weight:800; color:white; }
    .stat-label { font-size:0.8rem; color:rgba(255,255,255,0.5); margin-top:4px; }

    /* FEATURES */
    .features { padding:0 60px 80px; }
    .features-title { text-align:center; font-size:2rem; font-weight:800; margin-bottom:12px; }
    .features-sub { text-align:center; color:rgba(255,255,255,0.5); margin-bottom:48px; font-size:0.95rem; }
    .features-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
    .feature-card {
      background:rgba(255,255,255,0.04);
      border:1px solid rgba(255,255,255,0.08);
      border-radius:16px;
      padding:28px;
      transition:all 0.2s;
    }
    .feature-card:hover { background:rgba(255,255,255,0.07); border-color:rgba(99,102,241,0.3); transform:translateY(-4px); }
    .feature-icon { font-size:2rem; margin-bottom:16px; }
    .feature-title { font-size:1rem; font-weight:700; margin-bottom:8px; }
    .feature-desc { font-size:0.85rem; color:rgba(255,255,255,0.5); line-height:1.6; }

    /* ROLES */
    .roles { padding:0 60px 80px; }
    .roles-title { text-align:center; font-size:2rem; font-weight:800; margin-bottom:12px; }
    .roles-sub { text-align:center; color:rgba(255,255,255,0.5); margin-bottom:48px; }
    .roles-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
    .role-card { border-radius:16px; padding:28px; text-align:center; }
    .role-card.admin { background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(139,92,246,0.15)); border:1px solid rgba(99,102,241,0.3); }
    .role-card.caissier { background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(5,150,105,0.15)); border:1px solid rgba(16,185,129,0.3); }
    .role-card.membre { background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(217,119,6,0.15)); border:1px solid rgba(245,158,11,0.3); }
    .role-icon { font-size:2.5rem; margin-bottom:12px; }
    .role-name { font-size:1.1rem; font-weight:700; margin-bottom:8px; }
    .role-desc { font-size:0.82rem; color:rgba(255,255,255,0.6); line-height:1.6; }
    .role-features { margin-top:16px; text-align:left; }
    .role-feature { font-size:0.8rem; color:rgba(255,255,255,0.7); padding:4px 0; }

    /* HOW IT WORKS */
    .how { padding:0 60px 80px; }
    .how-title { text-align:center; font-size:2rem; font-weight:800; margin-bottom:12px; }
    .how-sub { text-align:center; color:rgba(255,255,255,0.5); margin-bottom:48px; }
    .steps { display:flex; justify-content:center; gap:0; flex-wrap:wrap; }
    .step { display:flex; flex-direction:column; align-items:center; text-align:center; width:180px; }
    .step-num { width:52px; height:52px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.2rem; font-weight:800; margin-bottom:12px; }
    .step-title { font-size:0.9rem; font-weight:700; margin-bottom:6px; }
    .step-desc { font-size:0.78rem; color:rgba(255,255,255,0.5); line-height:1.5; }
    .step-arrow { font-size:1.5rem; color:rgba(255,255,255,0.2); margin:0 8px; align-self:center; margin-bottom:40px; }

    /* CTA */
    .cta {
      margin:0 60px 60px;
      background:linear-gradient(135deg,#6366f1,#8b5cf6);
      border-radius:24px;
      padding:60px;
      text-align:center;
    }
    .cta h2 { font-size:2rem; font-weight:800; margin-bottom:12px; }
    .cta p { color:rgba(255,255,255,0.8); margin-bottom:32px; font-size:1rem; }
    .cta-btns { display:flex; gap:16px; justify-content:center; }
    .cta-btn-white { padding:14px 36px; background:white; color:#6366f1; border-radius:12px; font-weight:700; text-decoration:none; font-size:0.95rem; transition:all 0.2s; }
    .cta-btn-white:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }
    .cta-btn-outline { padding:14px 36px; border:2px solid rgba(255,255,255,0.4); color:white; border-radius:12px; font-weight:700; text-decoration:none; font-size:0.95rem; transition:all 0.2s; }
    .cta-btn-outline:hover { background:rgba(255,255,255,0.1); }

    /* FOOTER */
    .footer { padding:32px 60px; border-top:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
    .footer-brand { display:flex; align-items:center; gap:10px; }
    .footer-logo { width:32px; height:32px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .footer-name { font-size:0.875rem; font-weight:700; color:white; }
    .footer-copy { font-size:0.8rem; color:rgba(255,255,255,0.3); }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="navbar-brand">
      <div class="navbar-logo">💰</div>
      <div class="navbar-name">Gestion Solidarité Financière</div>
    </div>
    <div class="navbar-links">
      <a href="/login" class="btn-login">🔐 Se connecter</a>
      <a href="/register" class="btn-register">✨ S'inscrire</a>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-badge">💰 Plateforme de solidarité financière</div>
    <h1>Gérez votre tontine<br>en ligne simplement</h1>
    <p>Plateforme complète pour gérer les cotisations, les aides financières et les remboursements de votre groupe communautaire.</p>
    <div class="hero-btns">
      <a href="/register" class="hero-btn-primary">✨ Rejoindre le groupe</a>
      <a href="/login" class="hero-btn-secondary">🔐 Se connecter</a>
    </div>
  </section>

  <!-- STATS -->
  <div class="stats">
    <div class="stat-item">
      <div class="stat-number">3</div>
      <div class="stat-label">Rôles distincts</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">100%</div>
      <div class="stat-label">Sécurisé</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">24/7</div>
      <div class="stat-label">Disponible</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">FDJ</div>
      <div class="stat-label">Franc Djibouti</div>
    </div>
  </div>

  <!-- FEATURES -->
  <section class="features">
    <h2 class="features-title">Tout ce dont vous avez besoin</h2>
    <p class="features-sub">Une solution complète pour gérer votre groupe de solidarité</p>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">👥</div>
        <div class="feature-title">Gestion des membres</div>
        <div class="feature-desc">Inscription en ligne, validation par l'admin, suspension et réactivation des membres.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💰</div>
        <div class="feature-title">Cotisations</div>
        <div class="feature-desc">Paiement en ligne via Espèces, Waafi Pay ou D-Money. Historique complet.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🆘</div>
        <div class="feature-title">Demandes d'aide</div>
        <div class="feature-desc">Système complet avec règles, preuves obligatoires et suivi en temps réel.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <div class="feature-title">Rapports financiers</div>
        <div class="feature-desc">Export PDF et Excel, graphiques statistiques, rapport par période.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔔</div>
        <div class="feature-title">Notifications</div>
        <div class="feature-desc">Alertes automatiques à chaque étape : inscription, aide, paiement.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">⚙️</div>
        <div class="feature-title">Règles configurables</div>
        <div class="feature-desc">Montant minimum, pénalité de retard, plafond d'aide modifiables par l'admin.</div>
      </div>
    </div>
  </section>

  <!-- ROLES -->
  <section class="roles">
    <h2 class="roles-title">3 rôles distincts</h2>
    <p class="roles-sub">Chaque acteur a son espace dédié</p>
    <div class="roles-grid">
      <div class="role-card admin">
        <div class="role-icon">👑</div>
        <div class="role-name">Administrateur</div>
        <div class="role-desc">Gère tout le groupe et prend les décisions</div>
        <div class="role-features">
          <div class="role-feature">✅ Valider les inscriptions</div>
          <div class="role-feature">✅ Approuver les aides</div>
          <div class="role-feature">✅ Gérer les règles</div>
          <div class="role-feature">✅ Générer les rapports</div>
          <div class="role-feature">✅ Suspendre les membres</div>
        </div>
      </div>
      <div class="role-card caissier">
        <div class="role-icon">💼</div>
        <div class="role-name">Caissier</div>
        <div class="role-desc">Gère l'argent et les paiements physiques</div>
        <div class="role-features">
          <div class="role-feature">✅ Enregistrer cotisations</div>
          <div class="role-feature">✅ Remettre les aides</div>
          <div class="role-feature">✅ Générer reçus PDF</div>
          <div class="role-feature">✅ Gérer le fonds commun</div>
          <div class="role-feature">✅ Consulter les rapports</div>
        </div>
      </div>
      <div class="role-card membre">
        <div class="role-icon">👤</div>
        <div class="role-name">Membre</div>
        <div class="role-desc">Participe au groupe et bénéficie des aides</div>
        <div class="role-features">
          <div class="role-feature">✅ Payer les cotisations</div>
          <div class="role-feature">✅ Demander une aide</div>
          <div class="role-feature">✅ Demander remboursement</div>
          <div class="role-feature">✅ Voir son historique</div>
          <div class="role-feature">✅ Recevoir notifications</div>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="how">
    <h2 class="how-title">Comment ça marche ?</h2>
    <p class="how-sub">Simple et rapide en 5 étapes</p>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <div class="step-title">S'inscrire</div>
        <div class="step-desc">Remplir le formulaire en ligne</div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num">2</div>
        <div class="step-title">Validation</div>
        <div class="step-desc">Admin accepte la demande</div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-title">Cotiser</div>
        <div class="step-desc">Payer chaque mois</div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num">4</div>
        <div class="step-title">Demander aide</div>
        <div class="step-desc">En cas d'urgence</div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num">5</div>
        <div class="step-title">Recevoir</div>
        <div class="step-desc">Caissier remet l'argent</div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <div class="cta">
    <h2>Prêt à rejoindre le groupe ?</h2>
    <p>Inscrivez-vous maintenant et commencez à cotiser dès aujourd'hui</p>
    <div class="cta-btns">
      <a href="/register" class="cta-btn-white">✨ S'inscrire maintenant</a>
      <a href="/login" class="cta-btn-outline">🔐 Se connecter</a>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-brand">
      <div class="footer-logo">💰</div>
      <div class="footer-name">Gestion Solidarité Financière</div>
    </div>
    <div class="footer-copy">© {{ date('Y') }} — Tous droits réservés</div>
  </footer>

</body>
</html>