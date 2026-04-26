<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Deceased;
use App\Models\FuneralService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuneralServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_funeral_service_can_be_created(): void
    {
        $funeralService = FuneralService::factory()->create([
            'order_number' => 'FS-12345',
        ]);

        $this->assertDatabaseHas('funeral_services', [
            'order_number' => 'FS-12345',
        ]);
    }

    public function test_funeral_service_belongs_to_deceased(): void
    {
        $deceased = Deceased::factory()->create();
        $funeralService = FuneralService::factory()->create(['deceased_id' => $deceased->id]);

        $this->assertInstanceOf(Deceased::class, $funeralService->deceased);
        $this->assertEquals($deceased->id, $funeralService->deceased->id);
    }

    public function test_funeral_service_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        $funeralService = FuneralService::factory()->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $funeralService->customer);
        $this->assertEquals($customer->id, $funeralService->customer->id);
    }

    public function test_funeral_service_supports_soft_deletes(): void
    {
        $funeralService = FuneralService::factory()->create();
        $funeralService->delete();

        $this->assertSoftDeleted($funeralService);
    }

    public function test_funeral_date_is_cast_to_carbon(): void
    {
        $funeralService = FuneralService::factory()->create([
            'funeral_date' => '2026-02-01',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $funeralService->funeral_date);
    }
}
