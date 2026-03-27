<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\RegleGroupe;
use Illuminate\Http\Request;

class RegleController extends Controller {

    public function index() {
        $regle = RegleGroupe::first();
        return view('admin.regles.index', compact('regle'));
    }

    public function update(Request $request) {
        $request->validate([
            'cotisation_minimale' => 'required|numeric|min:1000',
            'frequence'           => 'required|in:mensuel,hebdomadaire,trimestriel',
            'penalite_retard'     => 'required|numeric|min:0|max:100',
            'plafond_aide'        => 'required|numeric|min:1000',
            'description'         => 'nullable|string',
        ]);

        RegleGroupe::updateOrCreate(['id' => 1], [
            'cotisation_minimale' => $request->cotisation_minimale,
            'frequence'           => $request->frequence,
            'penalite_retard'     => $request->penalite_retard,
            'plafond_aide'        => $request->plafond_aide,
            'description'         => $request->description,
        ]);

        return redirect()->back()->with('success',
            '✅ Règles du groupe mises à jour !');
    }
}