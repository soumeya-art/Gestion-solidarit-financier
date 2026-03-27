<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegleGroupe;
use App\Models\FondCommun;

class InitialDataSeeder extends Seeder {
    public function run(): void {

        // Créer Admin
        User::firstOrCreate(['email' => 'admin@solidarite.com'], [
            'nom'       => 'Admin',
            'prenom'    => 'Super',
            'telephone' => '77000001',
            'password'  => bcrypt('Admin123'),
            'role'      => 'administrateur',
            'statut'    => 'actif',
        ]);

        // Créer Caissier
        User::firstOrCreate(['email' => 'caissier@solidarite.com'], [
            'nom'       => 'Caissier',
            'prenom'    => 'Test',
            'telephone' => '77000003',
            'password'  => bcrypt('Caissier123'),
            'role'      => 'caissier',
            'statut'    => 'actif',
        ]);

        // Règles du groupe
        RegleGroupe::updateOrCreate(['id' => 1], [
            'cotisation_minimale' => 5000,
            'frequence'           => 'mensuel',
            'penalite_retard'     => 5,
            'description'         => 'Cotisation mensuelle de 5 000 fdj. Pénalité de 5% en cas de retard.',
        ]);

        // Fonds commun
        if (FondCommun::count() == 0) {
            FondCommun::create([
                'solde_total'      => 0,
                'solde_disponible' => 0,
                'solde_reserve'    => 0,
            ]);
        }
    }
}