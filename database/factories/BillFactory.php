<?php

namespace Database\Factories;

use App\Models\{Bill, Customer, CompanySetting};
use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BillFactory extends Factory
{
    protected $model = Bill::class;

    public function definition(): array
    {
        $company = CompanySetting::first() ?? CompanySetting::factory()->create();
        $customer = Customer::inRandomOrder()->first() ?? Customer::factory()->create();

        return [
            'type' => 'quote',
            'number' => 'TMP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => Arr::random([
                BillStatus::Draft,
                BillStatus::Sent,
                BillStatus::Accepted,
                BillStatus::Rejected,
            ]),
            'customer_id' => $customer->id,
            'company_setting_id' => $company->id,
            'issue_date' => now()->subDays(rand(5, 20)),
            'due_date' => now()->addDays(rand(5, 30)),
            'notes' => $this->faker->sentence(),
            'footer_note' => 'Merci pour votre confiance.',
        ];
    }

    public function invoice(): static
    {
        return $this->state(function () {
            return [
                'type' => 'invoice',
                'status' => Arr::random([
                    BillStatus::Draft,
                    BillStatus::Sent,
                    BillStatus::Paid,
                    BillStatus::Overdue,
                ]),
                'footer_note' => 'Merci pour votre règlement.',
            ];
        });
    }
}
