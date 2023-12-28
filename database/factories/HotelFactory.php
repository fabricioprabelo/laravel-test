<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locale = 'pt_BR';
        $fake = fake($locale);
        $company = $fake->company();
        $companyWebsite = 'http://' . Str::slug($company, '') . '.com.br';

        return [
            'name' => $company,
            'address' => $fake->streetName() . ', ' . $fake->buildingNumber(),
            'complement' => $fake->secondaryAddress(),
            'neighborhood' => null,
            'city' => $fake->city(),
            'state' => $fake->stateAbbr(),
            'zip_code' => $fake->postcode(),
            'website' => $companyWebsite,
        ];
    }
}
