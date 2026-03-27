<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion Solidarité Financière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --sidebar-bg: #0f172a;
            --page-bg: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --indigo: #6366f1;
        }
        body { background: var(--page-bg); }
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar-bg); position: fixed; left: 0; top: 0; z-index: 100; display: flex; flex-direction: column; border-right: 1px solid rgba(255,255,255,0.05); overflow-y: auto; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .logo-box { display: flex; align-items: center; gap: 12px; }
        .logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 4px 12px rgba(99,102,241,0.4); }
        .logo-text h1 { font-size: 0.85rem; font-weight: 800; color: white; letter-spacing: -0.3px; line-height: 1.3; }
        .logo-text p { font-size: 0.65rem; color: rgba(255,255,255,0.4); margin-top: 1px; }
        .sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }
        .nav-section { margin-bottom: 20px; }
        .nav-label { font-size: 0.62rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.25); padding: 0 10px; margin-bottom: 6px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 10px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: all 0.15s; margin-bottom: 2px; }
        .nav-link:hover { background: rgba(255,255,255,0.07); color: white; }
        .nav-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
        .sidebar-user { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.7rem; color: rgba(255,255,255,0.5); margin-top: 1px; }
        .logout-btn { background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer; padding: 6px; border-radius: 8px; transition: all 0.15s; font-size: 1rem; }
        .logout-btn:hover { background: rgba(239,68,68,0.15); color: #fca5a5; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: white; padding: 0 32px; height: 64px; display: flex; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; }
        .page-title { font-size: 1.1rem; font-weight: 700; color: var(--text-dark); }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 16px; }
        .topbar-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem; }
        .topbar-name { font-size: 0.875rem; font-weight: 600; color: var(--text-dark); }
        .topbar-role { font-size: 0.72rem; color: var(--text-muted); }
        .page-content { padding: 28px 32px; }
        .card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); border: 1px solid var(--border); }
        .stat-grid { display: grid; gap: 20px; margin-bottom: 28px; }
        .stat-grid-4 { grid-template-columns: repeat(4, 1fr); }
        .stat-grid-3 { grid-template-columns: repeat(3, 1fr); }
        .stat-card { background: white; border-radius: 16px; padding: 22px 24px; border: 1px solid var(--border); display: flex; align-items: center; gap: 16px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .stat-icon-box { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .stat-icon-box.green { background: #d1fae5; }
        .stat-icon-box.blue { background: #dbeafe; }
        .stat-icon-box.orange { background: #fef3c7; }
        .stat-icon-box.red { background: #fee2e2; }
        .stat-icon-box.purple { background: #ede9fe; }
        .stat-icon-box.indigo { background: #e0e7ff; }
        .stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-dark); line-height: 1; }
        .stat-label { font-size: 0.78rem; color: var(--text-muted); font-weight: 500; margin-top: 4px; }
        .action-grid { display: grid; gap: 20px; }
        .action-grid-3 { grid-template-columns: repeat(3, 1fr); }
        .action-grid-2 { grid-template-columns: repeat(2, 1fr); }
        .action-card { background: white; border-radius: 16px; padding: 24px; border: 1px solid var(--border); transition: all 0.2s; }
        .action-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); border-color: #c7d2fe; }
        .action-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 16px; }
        .action-title { font-size: 0.95rem; font-weight: 700; color: var(--text-dark); margin-bottom: 6px; }
        .action-desc { font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 18px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.15s; border: none; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-indigo { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
        .btn-indigo:hover { transform: translateY(-1px); color: white; }
        .btn-green { background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .btn-green:hover { transform: translateY(-1px); color: white; }
        .btn-orange { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
        .btn-orange:hover { transform: translateY(-1px); color: white; }
        .btn-red { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
        .btn-red:hover { transform: translateY(-1px); color: white; }
        .btn-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
        .btn-blue:hover { transform: translateY(-1px); color: white; }
        .btn-gray { background: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border); }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 2px solid #f1f5f9; }
        th { text-align: left; padding: 10px 16px; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.07em; }
        td { padding: 14px 16px; font-size: 0.875rem; color: var(--text-dark); border-bottom: 1px solid #f8fafc; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafbff; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 0.73rem; font-weight: 600; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-purple { background: #ede9fe; color: #5b21b6; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 0.78rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 7px; }
        .form-input, .form-select { width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 0.875rem; color: var(--text-dark); background: white; outline: none; transition: all 0.15s; font-family: 'Plus Jakarta Sans', sans-serif; }
        .form-input:focus, .form-select:focus { border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .section-title { font-size: 1rem; font-weight: 700; color: var(--text-dark); margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid #f1f5f9; }
    </style>
</head>
<body>
<div style="display:flex">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-box">
                <div class="logo-icon">💰</div>
                <div class="logo-text">
                    <h1>Gestion Solidarité Financière</h1>
                    <p>Gestion communautaire</p>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">

            @if(auth()->user()->isAdmin())
            <div class="nav-section">
                <div class="nav-label">Administration</div>
                <a href="/dashboard/admin" class="nav-link">
                    <div class="nav-icon">🏠</div> Tableau de bord
                </a>
                <a href="/admin/inscriptions" class="nav-link">
                    <div class="nav-icon">📝</div> Inscriptions
                </a>
                <a href="/admin/membres" class="nav-link">
                    <div class="nav-icon">👥</div> Membres
                </a>
                <a href="/admin/regles" class="nav-link">
                    <div class="nav-icon">⚙️</div> Règles du groupe
                </a>
                <a href="/admin/apropos" class="nav-link">
    <div class="nav-icon">ℹ️</div> À propos
</a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Finances</div>
                <a href="/admin/aides" class="nav-link">
                    <div class="nav-icon">🆘</div> Aides
                </a>
                <a href="/admin/remboursements" class="nav-link">
                    <div class="nav-icon">💸</div> Remboursements
                </a>
                <a href="/admin/rapports" class="nav-link">
                    <div class="nav-icon">📊</div> Rapports
                </a>
            </div>

            @elseif(auth()->user()->isCaissier())
            <div class="nav-section">
                <div class="nav-label">Caisse</div>
                <a href="/caissier/dashboard" class="nav-link">
                    <div class="nav-icon">🏠</div> Tableau de bord
                </a>
                <a href="/caissier/cotisations" class="nav-link">
                    <div class="nav-icon">💰</div> Cotisations
                </a>
                <a href="/caissier/aides" class="nav-link">
                    <div class="nav-icon">🆘</div> Aides
                </a>
                <a href="/caissier/remboursements" class="nav-link">
                    <div class="nav-icon">💸</div> Remboursements
                </a>
                <a href="/caissier/fonds" class="nav-link">
                    <div class="nav-icon">🏦</div> Fonds Commun
                </a>
                <a href="/caissier/rapports" class="nav-link">
                    <div class="nav-icon">📊</div> Rapports
                </a>
            </div>

            @else
            <div class="nav-section">
                <div class="nav-label">Mon espace</div>
                <a href="/dashboard/membre" class="nav-link">
                    <div class="nav-icon">🏠</div> Tableau de bord
                </a>
                <a href="/membre/cotisations" class="nav-link">
                    <div class="nav-icon">💰</div> Cotisations
                </a>
                <a href="/membre/aides" class="nav-link">
                    <div class="nav-icon">🆘</div> Aides
                </a>
                <a href="/membre/remboursements" class="nav-link">
                    <div class="nav-icon">💸</div> Remboursement
                </a>
                <a href="/membre/profil" class="nav-link">
                    <div class="nav-icon">👤</div> Mon Profil
                </a>
               @php
$nb_notifs = \App\Models\Notification::where('user_id', auth()->id())
    ->where('statut', 'non_lu')->count();
@endphp

<a href="/notifications" class="nav-link">
    <div class="nav-icon">🔔</div> 
    Notifications
    @if($nb_notifs > 0)
    <span style="background:#ef4444; color:white; border-radius:50%; width:20px; height:20px; display:flex; align-items:center; justify-content:center; font-size:0.7rem; font-weight:700; margin-left:auto">
        {{ $nb_notifs }}
    </span>
    @endif
</a>
            </div>
            @endif

        </nav>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Se déconnecter">🚪</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main-content" style="flex:1">
        <div class="topbar">
    <div class="page-title">{{ $header ?? 'Dashboard' }}</div>
    <div class="topbar-right">

        @php $nb_notifs_top = \App\Models\Notification::where('user_id', auth()->id())->where('statut', 'non_lu')->count(); @endphp
        @if($nb_notifs_top > 0)
        <a href="/notifications" style="position:relative; text-decoration:none">
            <span style="font-size:1.3rem">🔔</span>
            <span style="position:absolute; top:-6px; right:-6px; background:#ef4444; color:white; border-radius:50%; width:18px; height:18px; display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:700">
                {{ $nb_notifs_top }}
            </span>
        </a>
        @endif

        <div style="text-align:right">
            <div class="topbar-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
            <div class="topbar-role">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <div class="topbar-avatar">
            {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
        </div>

        <!-- Bouton déconnexion visible en haut -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                background:linear-gradient(135deg,#ef4444,#dc2626);
                color:white;
                border:none;
                padding:8px 16px;
                border-radius:10px;
                font-size:0.8rem;
                font-weight:600;
                cursor:pointer;
                display:flex;
                align-items:center;
                gap:6px;
                font-family:'Plus Jakarta Sans',sans-serif;
                transition:all 0.2s;
            ">
                🚪 Déconnexion
            </button>
        </form>

    </div>
</div>
        <div class="page-content">
            {{ $slot }}
        </div>
    </main>

</div>
</body>
</html>