<?php 

namespace Database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Maestros
        User::create([
            'name' => 'Maestro 1',
            'email' => 'maestro1@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Maestro 2',
            'email' => 'maestro2@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Estudiantes
        foreach (range(1, 3) as $i) {
            User::create([
                'name' => "Alumno {$i}",
                'email' => "alumno{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }
    }
}