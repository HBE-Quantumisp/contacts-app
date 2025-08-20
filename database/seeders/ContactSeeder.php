<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los usuarios existentes
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No hay usuarios en la base de datos. Ejecuta primero UserSeeder.');
            return;
        }

        // Contactos adicionales para cada usuario
        $contactosAdicionales = [
            [
                'nombre' => 'Pedro',
                'apellido' => 'Rodríguez',
                'telefono' => '+34111222333',
                'email' => 'pedro.rodriguez@email.com',
                'direccion' => 'Calle Sol 15, Málaga, España'
            ],
            [
                'nombre' => 'Elena',
                'apellido' => 'Jiménez',
                'telefono' => '+34666777888',
                'email' => 'elena.jimenez@email.com',
                'direccion' => 'Avenida Luna 42, Granada, España'
            ],
            [
                'nombre' => 'Miguel',
                'apellido' => 'Torres',
                'telefono' => '+34999888777',
                'email' => 'miguel.torres@email.com',
                'direccion' => null
            ],
            [
                'nombre' => 'Carmen',
                'apellido' => 'Ruiz',
                'telefono' => '+34333444555',
                'email' => 'carmen.ruiz@email.com',
                'direccion' => 'Plaza España 7, Bilbao, España'
            ],
            [
                'nombre' => 'Francisco',
                'apellido' => 'Moreno',
                'telefono' => '+34222333444',
                'email' => 'francisco.moreno@email.com',
                'direccion' => 'Calle Victoria 89, Zaragoza, España'
            ],
            [
                'nombre' => 'Isabel',
                'apellido' => 'Guerrero',
                'telefono' => '+34888999000',
                'email' => 'isabel.guerrero@email.com',
                'direccion' => 'Avenida Libertad 156, Valladolid, España'
            ]
        ];

        // Agregar contactos adicionales al primer usuario
        foreach ($users as $user) {
            foreach ($contactosAdicionales as $index => $contacto) {
                // Modificar ligeramente los datos para cada usuario para evitar duplicados
                $contacto['telefono'] = '+34' . (100000000 + ($user->id * 1000000) + $index);
                $contacto['email'] = str_replace('@email.com', $user->id . '@email.com', $contacto['email']);

                $user->contacts()->create($contacto);
            }
        }

        $this->command->info('✅ Contactos adicionales creados para todos los usuarios!');
    }
}
