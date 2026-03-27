<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adhesion;
use App\Models\Membre;
use App\Models\GroupeSolidarite;
use App\Models\User;
use Illuminate\Http\Request;

class AdhesionController extends Controller
{
   public function index($groupe_id)
{
    $groupe = GroupeSolidarite::findOrFail($groupe_id);
    $adhesions = Adhesion::where('groupe_id', $groupe_id)->with('membre.user')->get();
    
    // Seulement les membres qui ont un user valide
    $membres = Membre::with('user')
                ->whereHas('user')
                ->get();

    return view('admin.adhesions.index', compact('groupe', 'adhesions', 'membres'));
}
    public function store(Request $request, $groupe_id)
    {
        $request->validate([
            'membre_id' => 'required|exists:membres,id',
        ]);

        $existe = Adhesion::where('membre_id', $request->membre_id)
                          ->where('groupe_id', $groupe_id)
                          ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ce membre est déjà dans ce groupe !');
        }

        Adhesion::create([
            'membre_id'        => $request->membre_id,
            'groupe_id'        => $groupe_id,
            'date_adhesion'    => now(),
            'role'             => 'membre',
            'statut'           => 'actif',
            'cotisations_payees' => 0,
        ]);

        // Mettre à jour le nombre de membres
        $groupe = GroupeSolidarite::findOrFail($groupe_id);
        $groupe->nombre_membres += 1;
        $groupe->save();

        return redirect()->back()->with('success', 'Membre ajouté au groupe avec succès !');
    }

    public function destroy($groupe_id, $adhesion_id)
    {
        $adhesion = Adhesion::findOrFail($adhesion_id);
        $adhesion->delete();

        $groupe = GroupeSolidarite::findOrFail($groupe_id);
        $groupe->nombre_membres -= 1;
        $groupe->save();

        return redirect()->back()->with('success', 'Membre retiré du groupe !');
    }
}