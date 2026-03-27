<?php
namespace App\Http\Controllers\Membre;
use App\Http\Controllers\Controller;
use App\Models\DemandeRemboursement;
use App\Models\Membre;
use App\Models\CompteMembre;
use Illuminate\Http\Request;

class RemboursementController extends Controller {

    public function index() {
        $membre = Membre::where('user_id', auth()->id())->first();
        $compte = $membre ? CompteMembre::where('membre_id', $membre->id)->first() : null;
        $demandes = $membre ? DemandeRemboursement::where('membre_id', $membre->id)
                              ->orderBy('created_at', 'desc')->get() : collect();
        return view('membre.remboursements.index', compact('demandes', 'membre', 'compte'));
    }

    public function store(Request $request) {
        $request->validate([
            'montant_demande' => 'required|numeric|min:1',
            'motif'           => 'required|string',
        ]);

        $membre = Membre::where('user_id', auth()->id())->first();
        if (!$membre) return redirect()->back()->with('error', 'Profil membre introuvable.');

        // Vérifier si une demande est déjà en attente
        $existante = DemandeRemboursement::where('membre_id', $membre->id)
                        ->where('statut', 'en_attente')->first();
        if ($existante) {
            return redirect()->back()->with('error', 'Vous avez déjà une demande en attente !');
        }

        DemandeRemboursement::create([
            'membre_id'       => $membre->id,
            'montant_demande' => $request->montant_demande,
            'motif'           => $request->motif,
            'statut'          => 'en_attente',
        ]);

        return redirect()->back()->with('success', 'Demande de remboursement envoyée !');
    }
}