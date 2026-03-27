<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupeSolidarite;
use App\Models\RegleGroupe;
use App\Models\FondCommun;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        $groupes = GroupeSolidarite::all();
        return view('admin.groupes.index', compact('groupes'));
    }

    public function create()
    {
        return view('admin.groupes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'                  => 'required|string|max:255',
            'type'                 => 'required|in:tontine,mutuelle,cooperative',
            'cotisation_minimale'  => 'required|numeric|min:0',
            'frequence'            => 'required|in:mensuel,hebdomadaire,trimestriel',
            'plafond_pret'         => 'required|numeric|min:0',
            'taux_interet'         => 'required|numeric|min:0',
            'penalite_retard'      => 'required|numeric|min:0',
        ]);

        $groupe = GroupeSolidarite::create([
            'nom'            => $request->nom,
            'type'           => $request->type,
            'date_creation'  => now(),
            'nombre_membres' => 0,
            'statut'         => 'actif',
        ]);

        RegleGroupe::create([
            'groupe_id'           => $groupe->id,
            'cotisation_minimale' => $request->cotisation_minimale,
            'frequence'           => $request->frequence,
            'plafond_pret'        => $request->plafond_pret,
            'taux_interet'        => $request->taux_interet,
            'penalite_retard'     => $request->penalite_retard,
        ]);

        FondCommun::create([
            'groupe_id'        => $groupe->id,
            'solde_total'      => 0,
            'solde_disponible' => 0,
            'solde_reserve'    => 0,
        ]);

        return redirect('/admin/groupes')->with('success', 'Groupe créé avec succès !');
    }

    public function destroy($id)
    {
        $groupe = GroupeSolidarite::findOrFail($id);
        $groupe->delete();

        return redirect('/admin/groupes')->with('success', 'Groupe supprimé avec succès !');
    }
}