<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'telephone' => '0123456789',
            'password'=> Hash::make('1')
        ])->assignRole('Administrador');
        User::create([
            'name' => 'Gestor',
            'email' => 'gestor@example.com',
            'telephone' => '0123456789',
            'password'=> Hash::make('1')
        ])->assignRole('Gestor');
        $coord = User::create([
            'name' => 'Coordenador',
            'email' => 'coordenador@example.com',
            'telephone' => '0123456789',
            'password'=> Hash::make('1')
        ]);
        $coord->assignRole('Coordenador');
        Coordinator::create([
            'user_id' => $coord->id,
            'ppg_id' => 1
        ]);
    }
}
