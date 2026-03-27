<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DemandeRemboursement;
use App\Models\FondCommun;
use App\Models\Notification;
use Illuminate\Http\Request;

class RemboursementController extends Controller {

    public function index() {
        $demandes = DemandeRemboursement::with(['membre.user'])
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.remboursements.index', compact('demandes'));
    }

    public function approuver(Request $request, $id) {
        $request->validate([
            'montant_approuve' => 'required|numeric|min:1',
        ]);

        $demande = DemandeRemboursement::findOrFail($id);
        $demande->statut = 'approuve';
        $demande->montant_approuve = $request->montant_approuve;
        $demande->save();

        Notification::create([
            'user_id' => $demande->membre->user->id,
            'type'    => 'remboursement',
            'canal'   => 'web',
            'message' => '✅ Votre demande de remboursement de ' .
                number_format($request->montant_approuve, 0, ',', ' ') .
                ' FDJ a été approuvée ! Le caissier va vous remettre l\'argent.',
            'statut'  => 'non_lu',
        ]);

        return redirect()->back()->with('success', 'Remboursement approuvé ! Le caissier peut maintenant payer le membre.');
    }

    public function refuser($id) {
        $demande = DemandeRemboursement::findOrFail($id);
        $demande->statut = 'refuse';
        $demande->save();

        Notification::create([
            'user_id' => $demande->membre->user->id,
            'type'    => 'remboursement',
            'canal'   => 'web',
            'message' => 'Votre demande de remboursement a été refusée.',
            'statut'  => 'non_lu',
        ]);

        return redirect()->back()->with('success', 'Remboursement refusé.');
    }
}