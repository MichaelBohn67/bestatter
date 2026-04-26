<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\FuneralService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_be_created(): void
    {
        $customer = Customer::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Smith',
        ]);

        $this->assertDatabaseHas('customers', [
            'first_name' => 'John',
            'last_name' => 'Smith',
        ]);
    }

    public function test_get_full_name_attribute(): void
    {
        $customer = Customer::factory()->make([
            'first_name' => 'John',
            'last_name' => 'Smith',
        ]);

        $this->assertEquals('John Smith', $customer->full_name);
    }

    public function test_customer_has_funeral_services_relationship(): void
    {
        $customer = Customer::factory()->create();
        $funeralService = FuneralService::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->funeralServices->contains($funeralService));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $customer->funeralServices);
    }

    public function test_customer_supports_soft_deletes(): void
    {
        $customer = Customer::factory()->create();
        $customer->delete();

        $this->assertSoftDeleted($customer);
    }
}
