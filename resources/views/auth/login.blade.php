<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — Gestion Solidarité Financière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: flex; background: #0f2535; }
        .left-panel {
            width: 55%;
            background: linear-gradient(135deg, #1a3a4a 0%, #0f2535 50%, #0a1a25 100%);
            display: flex; flex-direction: column; justify-content: center;
            align-items: center; padding: 60px; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; width: 400px; height: 400px;
            border-radius: 50%; border: 80px solid rgba(232,160,32,0.08);
            top: -100px; right: -100px;
        }
        .left-panel::after {
            content: ''; position: absolute; width: 300px; height: 300px;
            border-radius: 50%; border: 60px solid rgba(45,158,107,0.08);
            bottom: -80px; left: -80px;
        }
        .brand { text-align: center; z-index: 1; }
        .brand-icon { font-size: 4rem; margin-bottom: 20px; }
        .brand h1 { font-family: 'Playfair Display', serif; color: #e8a020; font-size: 2.2rem; margin-bottom: 12px; }
        .brand p { color: rgba(255,255,255,0.5); font-size: 0.95rem; line-height: 1.6; max-width: 300px; }
        .features { margin-top: 48px; z-index: 1; width: 100%; max-width: 320px; }
        .feature {
            display: flex; align-items: center; gap: 14px; padding: 14px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7); font-size: 0.875rem;
        }
        .feature-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(232,160,32,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .right-panel {
            width: 45%; background: #f4f7f5;
            display: flex; align-items: center; justify-content: center; padding: 60px 50px;
        }
        .login-box { width: 100%; max-width: 380px; }
        .login-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #1a3a4a; margin-bottom: 8px; }
        .login-subtitle { color: #6b8080; font-size: 0.9rem; margin-bottom: 36px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #6b8080; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
        .form-input { width: 100%; padding: 13px 16px; border: 1.5px solid #e2e8e6; border-radius: 12px; font-size: 0.9rem; color: #1a2e2a; background: white; outline: none; transition: all 0.2s; }
        .form-input:focus { border-color: #e8a020; box-shadow: 0 0 0 3px rgba(232,160,32,0.1); }
        .btn-login { width: 100%; padding: 14px; background: #1a3a4a; color: white; border: none; border-radius: 12px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: all 0.2s; margin-top: 8px; }
        .btn-login:hover { background: #0f2535; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,58,74,0.3); }
        .error-msg { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .remember-row label { font-size: 0.875rem; color: #6b8080; cursor: pointer; }
        .bottom-links { text-align: center; margin-top: 20px; }
        .bottom-links a { color: #e8a020; font-weight: 600; text-decoration: none; }
        .bottom-links span { color: #6b8080; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">💰</div>
            <h1>Gestion Solidarité Financière</h1>
            <p>Plateforme de gestion financière communautaire — tontines, mutuelles et coopératives.</p>
        </div>
        <div class="features">
            <div class="feature"><div class="feature-icon">👥</div><span>Gestion des membres et groupes</span></div>
            <div class="feature"><div class="feature-icon">💳</div><span>Cotisations et prêts en ligne</span></div>
            <div class="feature"><div class="feature-icon">📊</div><span>Rapports financiers détaillés</span></div>
            <div class="feature"><div class="feature-icon">🆘</div><span>Système d'aide d'urgence</span></div>
        </div>
    </div>

    <div class="right-panel">
        <div class="login-box">
            <h2 class="login-title">Bienvenue 👋</h2>
            <p class="login-subtitle">Connectez-vous à votre espace personnel</p>

            @if($errors->any())
            <div class="error-msg">❌ Email ou mot de passe incorrect.</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="votre@email.com" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>
                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn-login">Se connecter →</button>

                <div class="bottom-links" style="margin-top:20px">
                    <span>Pas encore de compte ? </span>
                    <a href="/register">S'inscrire</a>
                </div>
                <div class="bottom-links" style="margin-top:10px">
                    <a href="/" style="color:#94a3b8; font-size:0.8rem">← Retour à l'accueil</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>