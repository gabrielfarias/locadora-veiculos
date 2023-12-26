<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Criar 5 usuarios fictícios
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->word,
                'email' => $faker->unique()->safeEmail,
                'CPF' => $this->generateCPF(),
                'password' => bcrypt('123456'), // Senha padrão criptografada
            ]);
        }
    }

    /**
     * Gera um CPF fictício.
     *
     * @return string
     */
    protected function generateCPF()
    {
        $cpf = '';

        // Gera os 9 primeiros dígitos do CPF
        for ($i = 0; $i < 9; $i++) {
            $cpf .= mt_rand(0, 9);
        }

        // Calcula os dígitos verificadores
        $digit1 = $this->calculateCPFCheckDigit($cpf);
        $digit2 = $this->calculateCPFCheckDigit($cpf . $digit1);

        return $cpf . $digit1 . $digit2;
    }

    /**
     * Calcula o dígito verificador do CPF.
     *
     * @param string $partialCPF
     * @return int
     */
    protected function calculateCPFCheckDigit($partialCPF)
    {
        $sum = 0;
        $length = strlen($partialCPF);

        for ($i = 0; $i < $length; $i++) {
            $sum += (int)$partialCPF[$i] * ($length + 1 - $i);
        }

        $remainder = $sum % 11;
        return ($remainder < 2) ? 0 : 11 - $remainder;
    }
}
