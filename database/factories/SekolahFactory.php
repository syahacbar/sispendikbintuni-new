<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sekolah>
 */
class SekolahFactory extends Factory
{
    public function definition(): array
    {
        return [
            'npsn' => $this->faker->unique()->numerify('##########'),
            'nama' => $this->faker->company,
            'alamat' => $this->faker->address,
            'kode_wilayah' => $this->faker->postcode,
            'status_sekolah' => $this->faker->randomElement(['Negeri', 'Swasta']),
            'akreditasi' => $this->faker->randomElement(['A', 'B', 'C', 'T'])
        ];
    }
}
