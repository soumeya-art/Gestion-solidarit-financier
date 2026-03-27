<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Pret;
use App\Models\Membre;
use App\Models\Adhesion;
use App\Models\RegleGroupe;
use Illuminate\Http\Request;

class PretController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $membre = Membre::where('user_id', $user->id)->first();

        if (!$membre) {
            return redirect()->route('membre.dashboard')->with('error', 'Profil membre introuvable.');
        }

        $adhesions = Adhesion::where('membre_id', $membre->id)
                             ->with('groupe')
                             ->get();

        $prets = Pret::where('membre_id', $membre->id)
                     ->with('groupe')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('membre.prets.index', compact('adhesions', 'prets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'groupe_id'   => 'required|exists:groupes_solidarite,id',
            'montant'     => 'required|numeric|min:1',
            'duree'       => 'required|integer|min:1|max:36',
            'motif'       => 'required|string|max:500',
        ]);

        $user = auth()->user();
        $membre = Membre::where('user_id', $user->id)->first();

        // Vérifier que le membre est dans ce groupe
        $adhesion = Adhesion::where('membre_id', $membre->id)
                            ->where('groupe_id', $request->groupe_id)
                            ->where('statut', 'actif')
                            ->first();

        if (!$adhesion) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas membre de ce groupe !');
        }

        // Vérifier le plafond du prêt
        $regle = RegleGroupe::where('groupe_id', $request->groupe_id)->first();
        if ($regle && $request->montant > $regle->plafond_pret) {
            return redirect()->back()->with('error', 'Le montant dépasse le plafond autorisé de ' . number_format($regle->plafond_pret, 0, ',', ' ') . ' fdj !');
        }

        // Vérifier qu'il n'a pas déjà un prêt en cours
        $pretEnCours = Pret::where('membre_id', $membre->id)
                           ->where('groupe_id', $request->groupe_id)
                           ->whereIn('statut', ['en_attente', 'approuve'])
                           ->first();

        if ($pretEnCours) {
            return redirect()->back()->with('error', 'Vous avez déjà un prêt en cours dans ce groupe !');
        }

        $taux = $regle ? $regle->taux_interet : 0;

        Pret::create([
            'membre_id'       => $membre->id,
            'groupe_id'       => $request->groupe_id,
            'montant_pret'    => $request->montant,
            'taux_interet'    => $taux,
            'duree_en_mois'   => $request->duree,
            'motif'           => $request->motif,
            'statut'          => 'en_attente',
            'capital_restant' => $request->montant,
        ]);

        return redirect()->back()->with('success', 'Demande de prêt envoyée avec succès !');
    }
}