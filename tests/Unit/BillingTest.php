<?php

namespace Tests\Unit;

use App\Models\Billing;
use App\Models\FuneralService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    public function test_billing_can_be_created(): void
    {
        $billing = Billing::factory()->create([
            'invoice_number' => 'INV-10001',
        ]);

        $this->assertDatabaseHas('billings', [
            'invoice_number' => 'INV-10001',
        ]);
    }

    public function test_billing_fillable_attributes_are_defined(): void
    {
        $billing = new Billing();

        $this->assertEquals([
            'funeral_service_id',
            'invoice_number',
            'status',
            'issued_at',
            'due_at',
            'subtotal',
            'tax_rate',
            'tax_amount',
            'total',
            'notes',
        ], $billing->getFillable());
    }

    public function test_billing_belongs_to_funeral_service(): void
    {
        $funeralService = FuneralService::factory()->create();
        $billing = Billing::factory()->create(['funeral_service_id' => $funeralService->id]);

        $this->assertInstanceOf(FuneralService::class, $billing->funeralService);
        $this->assertEquals($funeralService->id, $billing->funeralService->id);
    }

    public function test_billing_casts_are_configured(): void
    {
        $billing = new Billing();
        $casts = $billing->getCasts();

        $this->assertSame('date', $casts['issued_at']);
        $this->assertSame('date', $casts['due_at']);
        $this->assertSame('decimal:2', $casts['subtotal']);
        $this->assertSame('decimal:2', $casts['tax_rate']);
        $this->assertSame('decimal:2', $casts['tax_amount']);
        $this->assertSame('decimal:2', $casts['total']);
        $this->assertSame('datetime', $casts['deleted_at']);
    }

    public function test_billing_supports_soft_deletes(): void
    {
        $billing = Billing::factory()->create();
        $billing->delete();

        $this->assertSoftDeleted($billing);
    }

    public function test_billing_date_casts_are_applied(): void
    {
        $billing = Billing::factory()->create([
            'issued_at' => '2026-02-01',
            'due_at' => '2026-02-15',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $billing->issued_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $billing->due_at);
    }
}
