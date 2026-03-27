<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller {

    public function create(): View {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'email'     => 'required|email|unique:inscriptions,email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'password'  => 'required|min:6|confirmed',
        ]);

        Inscription::create([
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'password'  => bcrypt($request->password),
            'statut'    => 'en_attente',
        ]);

        return redirect('/login')->with('success', 
            'Inscription soumise ! Attendez la validation de l\'administrateur.');
    }
}