<?php

namespace Database\Factories;

use App\Enums\InterestRateEnum;
use App\Enums\PaymentTermsEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanySettingFactory extends Factory
{
  public function definition(): array
  {
    return [
      'company_name' => 'Test Company',
      'company_email' => 'info@test.com',
      'company_phone' => '0600000000',
      'address_line1' => '123 Test Street',
      'address_line2' => null,
      'postal_code' => '00000',
      'city' => 'Test City',
      'country' => 'France',
      'siren' => '123456789',
      'siret' => '12345678900011',
      'vat_number' => 'FR123456789',
      'ape_code' => $this->faker->numerify('#####') . 'Z',
      'website' => 'https://example.com',
      'logo_path' => null,
      'currency' => 'EUR',
      'default_tax_rate' => 20.00,
      'footer_note' => 'Thank you for your business.',
    ];
  }
}
