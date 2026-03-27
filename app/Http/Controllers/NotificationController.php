<?php
namespace App\Http\Controllers;
use App\Models\Notification;

class NotificationController extends Controller {

    public function index() {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Marquer toutes comme lues
        Notification::where('user_id', auth()->id())
            ->where('statut', 'non_lu')
            ->update(['statut' => 'lu']);

        return view('notifications.index', compact('notifications'));
    }

    public function marquerLu($id) {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['statut' => 'lu']);
        return redirect()->back();
    }
}