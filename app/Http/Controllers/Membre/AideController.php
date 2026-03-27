<?php
namespace App\Http\Controllers\Membre;
use App\Http\Controllers\Controller;
use App\Models\DemandeAide;
use App\Models\Membre;
use App\Models\CompteMembre;
use App\Models\FondCommun;
use App\Models\Adhesion;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AideController extends Controller {

    public function index() {
        $membre = Membre::where('user_id', auth()->id())->first();
        $compte = $membre ? CompteMembre::where('membre_id', $membre->id)->first() : null;
        $demandes = $membre ? DemandeAide::where('membre_id', $membre->id)
                              ->orderBy('score_priorite', 'desc')
                              ->orderBy('created_at', 'desc')->get() : collect();
        return view('membre.aides.index', compact('demandes', 'membre', 'compte'));
    }

    public function store(Request $request) {
        $request->validate([
            'type'            => 'required',
            'montant_demande' => 'required|numeric|min:1',
            'motif'           => 'required|string',
            'preuve'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'urgence'         => 'required|in:haute,normale,basse',
        ]);

        $membre = Membre::where('user_id', auth()->id())->first();
        if (!$membre) {
            return redirect()->back()->with('error', '❌ Profil membre introuvable.');
        }

        // Règle 1 — Membre suspendu
        if (auth()->user()->statut == 'suspendu') {
            return redirect()->back()->with('error',
                '❌ Votre compte est suspendu ! Contactez l\'administrateur.');
        }

        // Règle 2 — Doit avoir cotisé
        $compte = CompteMembre::where('membre_id', $membre->id)->first();
        if (!$compte || $compte->total_cotise == 0) {
            return redirect()->back()->with('error',
                '❌ Vous devez d\'abord cotiser avant de demander une aide !');
        }

        // Règle 3 — Cotisations 3 derniers mois
       
// Règle 3 — Cotisations selon ancienneté
$adhesion = Adhesion::where('membre_id', $membre->id)->first();
if ($adhesion) {
    $moisAnciennete = (int) Carbon::parse($adhesion->date_adhesion)
                        ->diffInMonths(now());
    $moisVerifier = min($moisAnciennete, 3);

    if ($moisVerifier > 0) {
        $cotisationsPeriode = Cotisation::where('membre_id', $membre->id)
            ->where('created_at', '>=', now()->subMonths($moisVerifier))
            ->count();

        if ($cotisationsPeriode < $moisVerifier) {
            return redirect()->back()->with('error',
                '❌ Vous devez être à jour dans vos cotisations ! ' .
                'Vous avez payé ' . $cotisationsPeriode .
                ' fois sur ' . $moisVerifier . ' mois.');
        }
    }
}




        // Règle 4 — Ancienneté 3 mois
      $adhesion = Adhesion::where('membre_id', $membre->id)->first();
if ($adhesion) {
    $mois = (int) Carbon::parse($adhesion->date_adhesion)->diffInMonths(now());
    if ($mois < 3) {
        return redirect()->back()->with('error',
            '❌ Vous devez être membre depuis 3 mois minimum ! ' .
            'Il vous reste ' . (3 - $mois) . ' mois.');
    }
}

        // Règle 5 — Pas de demande en attente
        $demandeEnCours = DemandeAide::where('membre_id', $membre->id)
            ->where('statut', 'en_attente')->first();
        if ($demandeEnCours) {
            return redirect()->back()->with('error',
                '❌ Vous avez déjà une demande en attente !');
        }

        
      
        // Règle 8 — Fonds suffisant
        $fond = FondCommun::first();
        if (!$fond || $fond->solde_disponible < $request->montant_demande) {
            return redirect()->back()->with('error',
                '❌ Le fonds commun n\'a pas assez d\'argent !');
        }

        // Score priorité
        $score = match($request->urgence) {
            'haute'   => 3,
            'normale' => 2,
            'basse'   => 1,
            default   => 1
        };

        // Upload preuve
        $preuvePath = $request->file('preuve')->store('preuves', 'public');

        // Créer la demande
        DemandeAide::create([
            'membre_id'       => $membre->id,
            'type'            => $request->type,
            'montant_demande' => $request->montant_demande,
            'motif'           => $request->motif,
            'preuve'          => $preuvePath,
            'statut'          => 'en_attente',
            'date_demande'    => now(),
            'score_priorite'  => $score,
        ]);

        return redirect()->back()->with('success',
            '✅ Demande d\'aide envoyée avec succès !');
    }
}