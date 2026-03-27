<?php
namespace App\Http\Controllers\Membre;
use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\Transaction;
use App\Models\CompteMembre;
use App\Models\FondCommun;
use App\Models\Membre;
use App\Models\RegleGroupe;
use Illuminate\Http\Request;

class CotisationController extends Controller {

    public function index() {
        $membre = Membre::where('user_id', auth()->id())->first();
        $cotisations = $membre ? Cotisation::where('membre_id', $membre->id)
                                ->orderBy('created_at','desc')->get() : collect();
        return view('membre.cotisations.index', compact('cotisations', 'membre'));
    }

    public function store(Request $request) {
        $request->validate(['montant' => 'required|numeric|min:1']);

        $membre = Membre::where('user_id', auth()->id())->first();
        if (!$membre) return redirect()->back()->with('error', 'Profil membre introuvable.');

        $regle = RegleGroupe::first();
        $montantFixe = $regle?->cotisation_minimale ?? 5000;

        if ($request->montant != $montantFixe) {
            return redirect()->back()->with('error',
                '❌ Le montant de cotisation doit être exactement ' .
                number_format($montantFixe, 0, ',', ' ') . ' FDJ ! Ni plus, ni moins.');
        }

        $penalite = 0;
        $enRetard = false;
        $montantTotal = $montantFixe;

        $jourActuel = now()->day;
        if ($jourActuel > 30) {
            $enRetard = true;
            $penalite = $montantFixe * ($regle?->penalite_retard ?? 5) / 100;
            $montantTotal = $montantFixe + $penalite;
        }

        $transaction = Transaction::create([
            'type'        => 'cotisation',
            'montant'     => $montantFixe,
            'statut'      => 'complete',
            'description' => 'Cotisation de ' . auth()->user()->prenom,
        ]);

        Cotisation::create([
            'membre_id'      => $membre->id,
            'transaction_id' => $transaction->id,
            'montant'        => $montantFixe,
            'statut'         => 'payee',
            'date_paiement'  => now(),
            'penalite'       => $penalite,
            'montant_total'  => $montantTotal,
            'en_retard'      => $enRetard,
        ]);

        $compte = CompteMembre::where('membre_id', $membre->id)->first();
        if ($compte) {
            $compte->total_cotise += $montantFixe;
            $compte->save();
        }

        $fond = FondCommun::first();
        if ($fond) {
            $fond->solde_total      += $montantFixe;
            $fond->solde_disponible += $montantFixe;
            $fond->save();
        }

        return redirect()->back()->with('success',
            '✅ Cotisation de ' .
            number_format($montantFixe, 0, ',', ' ') . ' FDJ payée !');
    }
    public function recu($id) {
        $membre = Membre::where('user_id', auth()->id())->first();
        if (!$membre) abort(404);

        $cotisation = Cotisation::where('id', $id)
            ->where('membre_id', $membre->id)
            ->firstOrFail();

        return view('membre.cotisations.recu', compact('cotisation'));
    }
}