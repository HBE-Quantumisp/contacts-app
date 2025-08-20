<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ContactSeeder::class,
        ]);

        $this->command->info('🎉 Base de datos poblada exitosamente!');
        $this->command->info('🚀 Ya puedes usar la aplicación en: http://localhost:8000');
        $this->command->line('');
        $this->command->info('👤 Credenciales de prueba:');
        $this->command->info('📧 Email: admin@test.com');
        $this->command->info('🔑 Contraseña: password123');
    }
}
