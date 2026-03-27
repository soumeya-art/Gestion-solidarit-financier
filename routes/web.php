<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\MembreController;
use App\Http\Controllers\Admin\AideController as AdminAideController;
use App\Http\Controllers\Admin\RapportController;
use App\Http\Controllers\Admin\RemboursementController as AdminRemboursementController;
use App\Http\Controllers\Admin\RegleController;
use App\Http\Controllers\Membre\CotisationController;
use App\Http\Controllers\Membre\AideController as MembreAideController;
use App\Http\Controllers\Membre\RemboursementController as MembreRemboursementController;
use App\Http\Controllers\Membre\ProfilController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Caissier\CaissierController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Accueil
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) return redirect('/dashboard/admin');
        if (auth()->user()->isCaissier()) return redirect('/dashboard/caissier');
        return redirect('/dashboard/membre');
    }
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Dashboards (role-protected)
    Route::get('/dashboard/membre', fn() => view('dashboard.membre'))
        ->middleware('role:membre')->name('membre.dashboard');
    Route::get('/dashboard/admin', fn() => view('dashboard.admin'))
        ->middleware('role:administrateur')->name('admin.dashboard');
    Route::get('/dashboard/caissier', [CaissierController::class, 'dashboard'])
        ->middleware('role:caissier')->name('caissier.dashboard');

    // Notifications (all roles)
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{id}/lu', [NotificationController::class, 'marquerLu']);

    // ADMIN (administrateur only)
    Route::prefix('admin')->middleware('role:administrateur')->group(function () {
        Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions');
        Route::get('/inscriptions/{id}/accepter', [InscriptionController::class, 'accepter']);
        Route::get('/inscriptions/{id}/refuser',  [InscriptionController::class, 'refuser']);

        Route::get('/membres', [MembreController::class, 'index'])->name('admin.membres');
        Route::get('/membres/{id}/suspendre', [MembreController::class, 'suspendre']);
        Route::get('/membres/{id}/reactiver', [MembreController::class, 'reactiver']);
        Route::get('/membres/exclure/{id}',   [MembreController::class, 'exclure']);

        Route::get('/aides',  [AdminAideController::class, 'index'])->name('admin.aides');
        Route::post('/aides/{id}/approuver', [AdminAideController::class, 'approuver'])->name('admin.aides.approuver');
        Route::post('/aides/{id}/refuser',   [AdminAideController::class, 'refuser'])->name('admin.aides.refuser');

        Route::get('/remboursements', [AdminRemboursementController::class, 'index'])->name('admin.remboursements');
        Route::post('/remboursements/{id}/approuver', [AdminRemboursementController::class, 'approuver']);
        Route::get('/remboursements/{id}/refuser',    [AdminRemboursementController::class, 'refuser']);

        Route::get('/regles',  [RegleController::class, 'index'])->name('admin.regles');
        Route::post('/regles', [RegleController::class, 'update'])->name('admin.regles.update');

        Route::get('/rapports',          [RapportController::class, 'index'])->name('admin.rapports');
        Route::get('/rapports/pdf',      [RapportController::class, 'exportPdf'])->name('admin.rapports.pdf');
        Route::get('/rapports/excel',    [RapportController::class, 'exportExcel'])->name('admin.rapports.excel');
        Route::post('/rapports/periode', [RapportController::class, 'rapportPeriode'])->name('admin.rapports.periode');

        Route::get('/apropos', function() {
            return view('admin.apropos');
        })->name('admin.apropos');

        Route::post('/membres/notifier', [MembreController::class, 'notifierTous'])->name('admin.membres.notifier');
        Route::get('/membres/alerter-retard', [MembreController::class, 'alerterEnRetard'])->name('admin.membres.alerter');
    });

    // MEMBRE (membre only)
    Route::prefix('membre')->middleware('role:membre')->group(function () {
        Route::get('/cotisations', [CotisationController::class, 'index'])->name('membre.cotisations');
        Route::post('/cotisations', [CotisationController::class, 'store'])->name('membre.cotisations.store');
        Route::get('/cotisations/{id}/recu', [CotisationController::class, 'recu'])->name('membre.cotisations.recu');
        Route::get('/aides', [MembreAideController::class, 'index'])->name('membre.aides');
        Route::post('/aides', [MembreAideController::class, 'store'])->name('membre.aides.store');
        Route::get('/remboursements', [MembreRemboursementController::class, 'index'])->name('membre.remboursements');
        Route::post('/remboursements', [MembreRemboursementController::class, 'store'])->name('membre.remboursements.store');
        Route::get('/profil', [ProfilController::class, 'index'])->name('membre.profil');
        Route::post('/profil', [ProfilController::class, 'update'])->name('membre.profil.update');
        Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('membre.profil.password');
    });

    // CAISSIER (caissier only)
    Route::prefix('caissier')->middleware('role:caissier')->group(function () {
        Route::get('/dashboard', [CaissierController::class, 'dashboard']);
        Route::get('/cotisations',       [CaissierController::class, 'cotisations'])->name('caissier.cotisations');
        Route::post('/cotisations',      [CaissierController::class, 'enregistrerCotisation']);
        Route::get('/aides',             [CaissierController::class, 'aides'])->name('caissier.aides');
        Route::post('/aides/{id}/payer', [CaissierController::class, 'confirmerPaiement'])->name('caissier.aides.payer');
        Route::get('/aides/{id}/recu',   [CaissierController::class, 'recu'])->name('caissier.aides.recu');
        Route::get('/remboursements',          [CaissierController::class, 'remboursements'])->name('caissier.remboursements');
        Route::post('/remboursements/{id}/payer', [CaissierController::class, 'payerRemboursement'])->name('caissier.remboursements.payer');
        Route::get('/fonds',             [CaissierController::class, 'fonds'])->name('caissier.fonds');
        Route::get('/rapports',          [CaissierController::class, 'rapports'])->name('caissier.rapports');
    });
});
