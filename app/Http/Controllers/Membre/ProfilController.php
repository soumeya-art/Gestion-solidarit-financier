<?php
namespace App\Http\Controllers\Membre;
use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\DemandeAide;
use App\Models\Membre;
use App\Models\CompteMembre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller {

    public function index() {
        $user   = auth()->user();
        $membre = Membre::where('user_id', $user->id)->first();
        $compte = $membre ? CompteMembre::where('membre_id', $membre->id)->first() : null;
        $cotisations = $membre ? Cotisation::where('membre_id', $membre->id)
                                ->orderBy('created_at', 'desc')->get() : collect();
        $aides = $membre ? DemandeAide::where('membre_id', $membre->id)
                          ->orderBy('created_at', 'desc')->get() : collect();
        return view('membre.profil', compact('user', 'membre', 'compte', 'cotisations', 'aides'));
    }

    public function update(Request $request) {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        auth()->user()->update([
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'telephone' => $request->telephone,
        ]);

        return redirect()->back()->with('success', '✅ Profil mis à jour !');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error',
                '❌ Mot de passe actuel incorrect !');
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', '✅ Mot de passe changé !');
    }
}