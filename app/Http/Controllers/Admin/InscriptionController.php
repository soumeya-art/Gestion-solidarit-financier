<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\User;
use App\Models\Membre;
use App\Models\CompteMembre;
use App\Models\Adhesion;
use App\Models\Notification;

class InscriptionController extends Controller {

    public function index() {
        $inscriptions = Inscription::orderBy('created_at', 'desc')->get();
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function accepter($id) {
        $inscription = Inscription::findOrFail($id);

        // Créer le User
        $user = User::create([
            'nom'       => $inscription->nom,
            'prenom'    => $inscription->prenom,
            'email'     => $inscription->email,
            'telephone' => $inscription->telephone,
            'password'  => $inscription->password,
            'role'      => 'membre',
            'statut'    => 'actif',
        ]);

        // Créer le Membre
        $membre = Membre::create(['user_id' => $user->id]);

        // Créer le CompteMembre
        CompteMembre::create([
            'membre_id'   => $membre->id,
            'solde'       => 0,
            'total_cotise'=> 0,
            'statut'      => 'actif',
        ]);

        // Créer l'Adhésion au groupe unique
        Adhesion::create([
            'membre_id'    => $membre->id,
            'date_adhesion'=> now(),
            'role'         => 'membre',
            'statut'       => 'actif',
        ]);

        // Notification de bienvenue
        Notification::create([
            'user_id' => $user->id,
            'type'    => 'inscription',
            'canal'   => 'web',
            'message' => 'Bienvenue ' . $user->prenom . ' ! Votre inscription a été acceptée.',
            'statut'  => 'non_lu',
        ]);

        // Mettre à jour le statut inscription
        $inscription->update(['statut' => 'accepte']);

        return redirect()->back()->with('success', 'Inscription acceptée ! Membre créé avec succès.');
    }

    public function refuser($id) {
        $inscription = Inscription::findOrFail($id);
        $inscription->update(['statut' => 'refuse']);
        return redirect()->back()->with('success', 'Inscription refusée.');
    }
}