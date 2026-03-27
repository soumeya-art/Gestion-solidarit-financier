<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inscription — Gestion Solidarité Financière</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; margin:0; padding:0; box-sizing:border-box; }
    body { min-height:100vh; display:flex; background:#0f172a; }
    .left {
      width:50%; background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7);
      display:flex; flex-direction:column; justify-content:center;
      align-items:center; padding:60px; position:relative; overflow:hidden;
    }
    .left::before {
      content:''; position:absolute; width:500px; height:500px;
      border-radius:50%; border:80px solid rgba(255,255,255,0.08);
      top:-150px; right:-150px;
    }
    .left::after {
      content:''; position:absolute; width:350px; height:350px;
      border-radius:50%; border:60px solid rgba(255,255,255,0.06);
      bottom:-100px; left:-100px;
    }
    .brand { text-align:center; z-index:1; }
    .brand-icon { font-size:4rem; margin-bottom:20px; }
    .brand h1 { font-size:2.2rem; font-weight:800; color:white; margin-bottom:12px; }
    .brand p { color:rgba(255,255,255,0.7); font-size:0.95rem; line-height:1.6; max-width:300px; }
    .steps { margin-top:48px; z-index:1; width:100%; max-width:320px; }
    .step { display:flex; align-items:center; gap:14px; padding:14px 0; border-bottom:1px solid rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); font-size:0.875rem; }
    .step-num { width:32px; height:32px; border-radius:50%; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; flex-shrink:0; }
    .right { width:50%; background:#f8fafc; display:flex; align-items:center; justify-content:center; padding:60px 50px; overflow-y:auto; }
    .box { width:100%; max-width:420px; }
    .box-title { font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:6px; }
    .box-sub { color:#64748b; font-size:0.9rem; margin-bottom:32px; }
    .form-group { margin-bottom:16px; }
    .form-label { display:block; font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:6px; }
    .form-input { width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; color:#0f172a; background:white; outline:none; transition:all 0.2s; font-family:'Plus Jakarta Sans',sans-serif; }
    .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
    .btn-submit { width:100%; padding:14px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; border:none; border-radius:12px; font-size:0.95rem; font-weight:700; cursor:pointer; transition:all 0.2s; margin-top:8px; font-family:'Plus Jakarta Sans',sans-serif; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(99,102,241,0.4); }
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .alert-success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; padding:12px 16px; border-radius:10px; font-size:0.85rem; margin-bottom:20px; font-weight:500; }
    .alert-danger { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; padding:12px 16px; border-radius:10px; font-size:0.85rem; margin-bottom:20px; }
    .login-link { text-align:center; margin-top:20px; font-size:0.875rem; color:#64748b; }
    .login-link a { color:#6366f1; font-weight:600; text-decoration:none; }
  </style>
</head>
<body>
  <div class="left">
    <div class="brand">
      <div class="brand-icon">💰</div>
      <h1>Gestion Solidarité Financière</h1>
      <p>Rejoignez notre communauté de solidarité financière</p>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><span>Remplissez le formulaire d'inscription</span></div>
      <div class="step"><div class="step-num">2</div><span>Attendez la validation de l'administrateur</span></div>
      <div class="step"><div class="step-num">3</div><span>Connectez-vous et commencez à cotiser</span></div>
    </div>
  </div>
  <div class="right">
    <div class="box">
      <h2 class="box-title">Créer un compte ✨</h2>
      <p class="box-sub">Remplissez vos informations pour rejoindre le groupe</p>

      @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
      @endif

      @if($errors->any())
        <div class="alert-danger">
          @foreach($errors->all() as $error)
            <div>❌ {{ $error }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="/register">
        @csrf
        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-input" value="{{ old('nom') }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-input" value="{{ old('prenom') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone</label>
          <input type="text" name="telephone" class="form-input" value="{{ old('telephone') }}" required>
        </div>
        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Confirmer</label>
            <input type="password" name="password_confirmation" class="form-input" required>
          </div>
        </div>
        <button type="submit" class="btn-submit">S'inscrire →</button>
      </form>
      <div class="login-link">
        Déjà un compte ? <a href="/login">Se connecter</a>
      </div>
    </div>
  </div>
</body>
</html>