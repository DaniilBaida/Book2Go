<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Barbeiro',
            'Esteticista',
            'Dentista',
            'Personal Trainer',
            'Terapeuta',
            'Mecânico',
            'Advogado',
            'Consultor de TI',
            'Designer Gráfico',
            'Desenvolvedor Web'
        ];

        foreach ($services as $service) {
            Service::create(['name' => $service]);
        }
    }
}