<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DemandeAide;
use App\Models\FondCommun;
use App\Models\Notification;
use Illuminate\Http\Request;

class AideController extends Controller {

   public function index() {
    $demandes = DemandeAide::with(['membre.user'])
        ->whereHas('membre.user')
        ->orderBy('score_priorite', 'desc')
        ->orderBy('created_at', 'asc')
        ->get();
    return view('admin.aides.index', compact('demandes'));
}

public function approuver(Request $request, $id) {
    $request->validate([
        'montant_approuve' => 'required|numeric|min:1',
    ]);

    $demande = DemandeAide::findOrFail($id);

    // Vérifier si le fonds a assez d'argent
    $fond = FondCommun::first();
    if (!$fond || $fond->solde_disponible < $request->montant_approuve) {
        return redirect()->back()->with('error',
            '❌ Fonds insuffisant ! Disponible : ' .
            number_format($fond?->solde_disponible ?? 0, 0, ',', ' ') .
            ' FDJ — Vous ne pouvez pas approuver ' .
            number_format($request->montant_approuve, 0, ',', ' ') . ' FDJ !');
    }

    // Débiter le fonds commun
    $fond->solde_disponible -= $request->montant_approuve;
    $fond->solde_total      -= $request->montant_approuve;
    $fond->save();

    $demande->statut = 'approuve';
    $demande->montant_approuve = $request->montant_approuve;
    $demande->save();

    // Notification membre
    Notification::create([
        'user_id' => $demande->membre->user->id,
        'type'    => 'aide',
        'canal'   => 'web',
        'message' => '✅ Votre demande d\'aide de ' .
            number_format($request->montant_approuve, 0, ',', ' ') .
            ' FDJ a été approuvée ! Le caissier va vous contacter.',
        'statut'  => 'non_lu',
    ]);

    return redirect()->back()->with('success', '✅ Demande approuvée !');
}

    public function refuser(Request $request, $id) {
        $request->validate([
            'motif_refus' => 'required|string|min:5',
        ]);

        $demande = DemandeAide::findOrFail($id);
        $demande->statut = 'refuse';
        $demande->motif_refus = $request->motif_refus;
        $demande->save();

        // Notification membre — refusé
        Notification::create([
            'user_id' => $demande->membre->user->id,
            'type'    => 'aide',
            'canal'   => 'web',
            'message' => '❌ Votre demande d\'aide a été refusée. Raison : ' .
                $request->motif_refus,
            'statut'  => 'non_lu',
        ]);

        return redirect()->back()->with('success', '❌ Demande refusée.');
    }
}