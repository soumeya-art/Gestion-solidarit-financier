<?php
namespace App\Http\Controllers\Caissier;
use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\DemandeAide;
use App\Models\DemandeRemboursement;
use App\Models\FondCommun;
use App\Models\Membre;
use App\Models\CompteMembre;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class CaissierController extends Controller {

    public function dashboard() {
        $stats = [
            'total_membres'     => User::where('role', 'membre')->count(),
            'total_cotisations' => Cotisation::sum('montant'),
            'aides_approuvees'  => DemandeAide::where('statut', 'approuve')->count(),
            'fonds_disponible'  => FondCommun::first()?->solde_disponible ?? 0,
        ];
        $dernieres_cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();
        return view('dashboard.caissier', compact('stats', 'dernieres_cotisations'));
    }

    public function cotisations() {
        $membres = User::where('role', 'membre')->with('membre')->get();
        $cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')->get();
        return view('caissier.cotisations', compact('membres', 'cotisations'));
    }

    public function enregistrerCotisation(Request $request) {
        $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'montant'   => 'required|numeric|min:1',
        ]);

        $transaction = Transaction::create([
            'type'        => 'cotisation',
            'montant'     => $request->montant,
            'statut'      => 'complete',
            'description' => 'Cotisation enregistrée par caissier',
        ]);

        Cotisation::create([
            'membre_id'      => $request->membre_id,
            'transaction_id' => $transaction->id,
            'montant'        => $request->montant,
            'statut'         => 'payee',
            'date_paiement'  => now(),
        ]);

        $compte = CompteMembre::where('membre_id', $request->membre_id)->first();
        if ($compte) {
            $compte->total_cotise += $request->montant;
            $compte->save();
        }

        $fond = FondCommun::first();
        if ($fond) {
            $fond->solde_total      += $request->montant;
            $fond->solde_disponible += $request->montant;
            $fond->save();
        }

        return redirect()->back()->with('success',
            '✅ Cotisation de ' . number_format($request->montant, 0, ',', ' ') . ' fdj enregistrée !');
    }

    public function aides() {
    $aides_approuvees = DemandeAide::with('membre.user')
        ->whereHas('membre.user')
        ->where('statut', 'approuve')
        ->orderBy('updated_at', 'desc')->get();
    $aides_payees = DemandeAide::with('membre.user')
        ->whereHas('membre.user')
        ->where('statut', 'paye')
        ->orderBy('updated_at', 'desc')->get();
    $aides_attente = DemandeAide::with('membre.user')
        ->whereHas('membre.user')
        ->where('statut', 'en_attente')
        ->orderBy('created_at', 'desc')->get();
    return view('caissier.aides', compact(
        'aides_approuvees', 'aides_payees', 'aides_attente'
    ));
}

    public function fonds() {
    $fond = FondCommun::first();
    $entrees = \App\Models\Cotisation::with('membre.user')
        ->whereHas('membre.user')
        ->orderBy('created_at', 'desc')
        ->take(20)->get();
    $sorties = \App\Models\DemandeAide::with('membre.user')
        ->whereHas('membre.user')
        ->whereIn('statut', ['approuve', 'paye'])
        ->orderBy('updated_at', 'desc')
        ->take(20)->get();
    return view('caissier.fonds', compact('fond', 'entrees', 'sorties'));
}
    public function remboursements() {
        $remb_approuves = DemandeRemboursement::with('membre.user')
            ->whereHas('membre.user')
            ->where('statut', 'approuve')
            ->orderBy('updated_at', 'desc')->get();
        $remb_payes = DemandeRemboursement::with('membre.user')
            ->whereHas('membre.user')
            ->where('statut', 'paye')
            ->orderBy('updated_at', 'desc')->get();
        return view('caissier.remboursements', compact('remb_approuves', 'remb_payes'));
    }

    public function payerRemboursement(Request $request, $id) {
        $request->validate([
            'mode_paiement' => 'required|in:especes,waafi,dmoney',
        ]);

        $demande = DemandeRemboursement::findOrFail($id);
        if ($demande->statut !== 'approuve') {
            return redirect()->back()->with('error', 'Ce remboursement n\'est pas approuvé.');
        }

        $demande->statut = 'paye';
        $demande->save();

        $fond = FondCommun::first();
        if ($fond) {
            $fond->solde_disponible -= $demande->montant_approuve;
            $fond->solde_total      -= $demande->montant_approuve;
            $fond->save();
        }

        $compte = CompteMembre::where('membre_id', $demande->membre_id)->first();
        if ($compte) {
            $compte->total_cotise -= $demande->montant_approuve;
            if ($compte->total_cotise < 0) $compte->total_cotise = 0;
            $compte->save();
        }

        Notification::create([
            'user_id' => $demande->membre->user->id,
            'type'    => 'remboursement',
            'canal'   => 'web',
            'message' => '💵 Votre remboursement de ' .
                number_format($demande->montant_approuve, 0, ',', ' ') .
                ' FDJ a été payé via ' . strtoupper($request->mode_paiement) .
                '. Merci !',
            'statut'  => 'non_lu',
        ]);

        return redirect()->back()->with('success',
            '✅ Remboursement de ' .
            number_format($demande->montant_approuve, 0, ',', ' ') .
            ' FDJ payé à ' . $demande->membre->user->prenom . ' ' . $demande->membre->user->nom);
    }

    public function rapports() {
        $stats = [
            'total_membres'       => User::where('role', 'membre')->count(),
            'total_cotisations'   => Cotisation::sum('montant'),
            'total_aides'         => DemandeAide::whereIn('statut', ['approuve', 'paye'])->sum('montant_approuve'),
            'total_remboursements'=> DemandeRemboursement::where('statut', 'paye')->sum('montant_approuve'),
            'nb_remboursements'   => DemandeRemboursement::where('statut', 'paye')->count(),
            'aides_en_attente'    => DemandeAide::where('statut', 'en_attente')->count(),
            'aides_approuvees'    => DemandeAide::where('statut', 'approuve')->count(),
            'fonds_disponible'    => FondCommun::first()?->solde_disponible ?? 0,
            'fonds_total'         => FondCommun::first()?->solde_total ?? 0,
        ];
        $cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->take(10)->get();
        $remboursements = DemandeRemboursement::with('membre.user')
            ->whereHas('membre.user')
            ->where('statut', 'paye')
            ->orderBy('updated_at', 'desc')
            ->take(10)->get();
        return view('caissier.rapports', compact('stats', 'cotisations', 'remboursements'));
    }
    public function confirmerPaiement(Request $request, $id) {
    $request->validate([
        'mode_paiement'      => 'required|in:especes,waafi,dmoney',
        'reference_paiement' => 'nullable|string',
    ]);

    $demande = \App\Models\DemandeAide::findOrFail($id);
    $demande->statut             = 'paye';
    $demande->mode_paiement      = $request->mode_paiement;
    $demande->reference_paiement = $request->reference_paiement;
    $demande->save();

    $fond = FondCommun::first();
    if ($fond) {
        $fond->solde_disponible -= $demande->montant_approuve;
        $fond->solde_total      -= $demande->montant_approuve;
        $fond->save();
    }

    \App\Models\Notification::create([
        'user_id' => $demande->membre->user->id,
        'type'    => 'aide',
        'canal'   => 'web',
        'message' => '💵 Votre aide de ' .
            number_format($demande->montant_approuve, 0, ',', ' ') .
            ' FDJ a été payée via ' . strtoupper($request->mode_paiement) .
            ' ! Merci.',
        'statut'  => 'non_lu',
    ]);

    return redirect()->route('caissier.aides.recu', $id);
}

public function recu($id) {
    $demande = \App\Models\DemandeAide::with('membre.user')->findOrFail($id);
    $caissier = auth()->user();
    return view('caissier.recu', compact('demande', 'caissier'));
}
}