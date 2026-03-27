<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\DemandeAide;
use App\Models\FondCommun;
use App\Models\User;
use App\Models\Membre;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RapportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class RapportController extends Controller {

    public function index() {
        $stats = [
            'total_membres'     => User::where('role', 'membre')->count(),
            'total_cotisations' => Cotisation::sum('montant'),
            'total_aides'       => DemandeAide::where('statut', 'approuve')->sum('montant_approuve'),
            'aides_en_attente'  => DemandeAide::where('statut', 'en_attente')->count(),
            'aides_approuvees'  => DemandeAide::where('statut', 'approuve')->count(),
            'aides_refusees'    => DemandeAide::where('statut', 'refuse')->count(),
            'fonds_disponible'  => FondCommun::first()?->solde_disponible ?? 0,
            'fonds_total'       => FondCommun::first()?->solde_total ?? 0,
        ];

        $dernieres_cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->take(10)->get();

        $dernieres_aides = DemandeAide::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')
            ->take(10)->get();

        $membresEnRetard = Membre::with('user')
            ->whereHas('user')
            ->whereDoesntHave('cotisations', function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            })->get();

        $top_membres = Membre::with('user')
            ->whereHas('user')
            ->get()
            ->map(function($membre) {
                return [
                    'nom'    => $membre->user->prenom . ' ' . $membre->user->nom,
                    'total'  => Cotisation::where('membre_id', $membre->id)->sum('montant'),
                    'nombre' => Cotisation::where('membre_id', $membre->id)->count(),
                ];
            })
            ->sortByDesc('total')
            ->take(10);

        return view('admin.rapports.index', compact(
            'stats', 'dernieres_cotisations', 'dernieres_aides',
            'membresEnRetard', 'top_membres'
        ));
    }

    public function exportPdf() {
        $stats = [
            'total_membres'     => User::where('role', 'membre')->count(),
            'total_cotisations' => Cotisation::sum('montant'),
            'total_aides'       => DemandeAide::where('statut', 'approuve')->sum('montant_approuve'),
            'aides_en_attente'  => DemandeAide::where('statut', 'en_attente')->count(),
            'aides_approuvees'  => DemandeAide::where('statut', 'approuve')->count(),
            'aides_refusees'    => DemandeAide::where('statut', 'refuse')->count(),
            'fonds_disponible'  => FondCommun::first()?->solde_disponible ?? 0,
            'fonds_total'       => FondCommun::first()?->solde_total ?? 0,
        ];

        $cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')->get();

        $aides = DemandeAide::with('membre.user')
            ->whereHas('membre.user')
            ->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.rapports.pdf', compact('stats', 'cotisations', 'aides'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('rapport-solidarite-' . date('d-m-Y') . '.pdf');
    }

    public function exportExcel() {
        return Excel::download(
            new RapportExport(),
            'rapport-solidarite-' . date('d-m-Y') . '.xlsx'
        );
    }

    public function rapportPeriode(Request $request) {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after:date_debut',
        ]);

        $stats = [
            'total_membres'     => User::where('role', 'membre')->count(),
            'total_cotisations' => Cotisation::whereBetween('created_at', [
                $request->date_debut, $request->date_fin
            ])->sum('montant'),
            'total_aides'       => DemandeAide::where('statut', 'approuve')
                ->whereBetween('created_at', [
                    $request->date_debut, $request->date_fin
                ])->sum('montant_approuve'),
            'aides_en_attente'  => DemandeAide::where('statut', 'en_attente')->count(),
            'aides_approuvees'  => DemandeAide::where('statut', 'approuve')->count(),
            'aides_refusees'    => DemandeAide::where('statut', 'refuse')->count(),
            'fonds_disponible'  => FondCommun::first()?->solde_disponible ?? 0,
            'fonds_total'       => FondCommun::first()?->solde_total ?? 0,
        ];

        $dernieres_cotisations = Cotisation::with('membre.user')
            ->whereHas('membre.user')
            ->whereBetween('created_at', [$request->date_debut, $request->date_fin])
            ->orderBy('created_at', 'desc')->get();

        $dernieres_aides = DemandeAide::with('membre.user')
            ->whereHas('membre.user')
            ->whereBetween('created_at', [$request->date_debut, $request->date_fin])
            ->orderBy('created_at', 'desc')->get();

        $date_debut = $request->date_debut;
        $date_fin   = $request->date_fin;

        $membresEnRetard = Membre::with('user')
            ->whereHas('user')
            ->whereDoesntHave('cotisations', function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            })->get();

        $top_membres = Membre::with('user')
            ->whereHas('user')
            ->get()
            ->map(function($membre) {
                return [
                    'nom'    => $membre->user->prenom . ' ' . $membre->user->nom,
                    'total'  => Cotisation::where('membre_id', $membre->id)->sum('montant'),
                    'nombre' => Cotisation::where('membre_id', $membre->id)->count(),
                ];
            })
            ->sortByDesc('total')
            ->take(10);

        return view('admin.rapports.index', compact(
            'stats', 'dernieres_cotisations', 'dernieres_aides',
            'membresEnRetard', 'top_membres', 'date_debut', 'date_fin'
        ));
    }
}
