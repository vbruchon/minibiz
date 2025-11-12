<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = \App\Models\Customer::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'company_email' => $this->faker->unique()->companyEmail(),
            'company_phone' => $this->faker->phoneNumber(),
            'address_line1' => $this->faker->streetAddress(),
            'address_line2' => $this->faker->optional()->secondaryAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'website' => $this->faker->optional()->url(),
            'vat_number' => strtoupper('FR' . $this->faker->numerify('##########')),
            'contact_name' => $this->faker->name(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'prospect']),

            'siren' => $this->faker->numerify('#########'),
            'siret' => $this->faker->numerify('#########000##'),
            'ape_code' => $this->faker->numerify('#####') . 'Z',
        ];
    }
}
