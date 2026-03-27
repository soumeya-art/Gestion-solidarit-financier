<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pret;
use App\Models\FondCommun;
use App\Models\CompteMembre;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PretController extends Controller
{
public function index()
{
    $prets = Pret::with(['membre.user', 'groupe'])
        ->whereHas('membre.user')
        ->whereHas('groupe')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.prets.index', compact('prets'));
}

    public function approuver($id)
    {
        $pret = Pret::findOrFail($id);
        $pret->statut = 'approuve';
        $pret->date_approbation = now();
        $pret->save();

        // Mettre à jour le fond commun
        $fond = FondCommun::where('groupe_id', $pret->groupe_id)->first();
        if ($fond) {
            $fond->solde_disponible -= $pret->montant_pret;
            $fond->save();
        }

        // Mettre à jour le crédit disponible du membre
        $compte = CompteMembre::where('membre_id', $pret->membre_id)->first();
        if ($compte) {
            $compte->credit_disponible += $pret->montant_pret;
            $compte->save();
        }
        // Notification au membre
\App\Models\Notification::create([
    'user_id' => $pret->membre->user->id,
    'type' => 'pret',
    'canal' => 'web',
    'message' => 'Votre prêt de ' . number_format($pret->montant_pret, 0, ',', ' ') . ' fdj a été approuvé !',
    'statut' => 'non_lu'
]);

        return redirect()->back()->with('success', 'Prêt approuvé avec succès !');
    }

    public function refuser($id)
    {
        $pret = Pret::findOrFail($id);
        $pret->statut = 'refuse';
        $pret->save();
        \App\Models\Notification::create([
    'user_id' => $pret->membre->user->id,
    'type' => 'pret',
    'canal' => 'web',
    'message' => 'Votre prêt de ' . number_format($pret->montant_pret, 0, ',', ' ') . ' fdj a été refusé.',
    'statut' => 'non_lu'
]);

        return redirect()->back()->with('success', 'Prêt refusé !');
    }
}