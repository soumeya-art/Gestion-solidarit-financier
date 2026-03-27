<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membre;
use App\Models\Cotisation;

class MembreController extends Controller {

    public function index() {
        $membres = User::where('role', 'membre')
                    ->with('membre')
                    ->get();
        return view('admin.membres.index', compact('membres'));
    }

    public function suspendre($id) {
        $user = User::findOrFail($id);
        $user->statut = 'suspendu';
        $user->save();
        return redirect()->back()->with('success',
            '⚠️ Membre suspendu !');
    }

    public function reactiver($id) {
        $user = User::findOrFail($id);
        $user->statut = 'actif';
        $user->save();
        return redirect()->back()->with('success',
            '✅ Membre réactivé !');
    }

    public function exclure($id) {
        $user = User::findOrFail($id);
        $membre = Membre::where('user_id', $user->id)->first();

        if ($membre) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type'    => 'groupe',
                'canal'   => 'web',
                'message' => '⛔ Vous avez été exclu du groupe de solidarité.',
                'statut'  => 'non_lu',
            ]);
            $membre->delete();
        }

        $user->statut = 'exclu';
        $user->save();

        return redirect()->back()->with('success',
            '⛔ Membre ' . $user->prenom . ' ' . $user->nom . ' exclu !');
    }

   public function notifierTous(\Illuminate\Http\Request $request) {
    $request->validate(['message' => 'required|string']);

    $membres = User::where('role', 'membre')->get();
    foreach ($membres as $user) {
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type'    => 'groupe',
            'canal'   => 'web',
            'message' => '📢 ' . $request->message,
            'statut'  => 'non_lu',
        ]);
    }

    return redirect()->back()->with('success',
        '✅ Notification envoyée à ' . $membres->count() . ' membres !');
}
public function alerterEnRetard() {
    $membresEnRetard = \App\Models\Membre::with('user')
        ->whereHas('user')
        ->whereDoesntHave('cotisations', function($q) {
            $q->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
        })->get();

    foreach ($membresEnRetard as $membre) {
        \App\Models\Notification::create([
            'user_id' => $membre->user->id,
            'type'    => 'retard',
            'canal'   => 'web',
            'message' => '⚠️ Rappel : Vous n\'avez pas encore cotisé ce mois de ' .
                now()->locale('fr')->monthName . ' ! Pensez à payer votre cotisation.',
            'statut'  => 'non_lu',
        ]);
    }

    return redirect()->back()->with('success',
        '✅ Alerte envoyée à ' . $membresEnRetard->count() . ' membres en retard !');
}
}
