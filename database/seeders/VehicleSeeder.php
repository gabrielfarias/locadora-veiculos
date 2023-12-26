<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista de modelos e marcas correspondentes
        $modelBrandMapping = [
            'Onix' => 'Chevrolet',
            'Civic' => 'Honda',
            'Corolla' => 'Toyota',
            'Fusion' => 'Ford',
            'Camaro' => 'Chevrolet',
        ];

        foreach ($modelBrandMapping as $model => $brand) {
            Vehicle::create([
                'model' => $model,
                'brand' => $brand,
                'year' => rand(2000, 2023), // Ano aleatório entre 2000 e 2023
                'plate' => $this->generateLicensePlate() // Gera uma placa no formato ABC-1C23
            ]);
        }
    }

    /**
     * Gera uma placa de veículo fictícia.
     *
     * @return string
     */
    protected function generateLicensePlate()
    {
        $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)); // Gera três letras aleatórias (A-Z)
        $numbers = rand(1, 9); // Gera um número aleatório entre 1 e 9
        $alpha = chr(rand(65, 90)); // Gera uma letra aleatória (A-Z)
        $numericPart = rand(10, 99); // Gera um número aleatório entre 10 e 99

        return $letters . '-' . $numbers . $alpha . $numericPart;
    }
}
