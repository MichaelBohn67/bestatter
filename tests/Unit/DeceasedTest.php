<?php

namespace Tests\Unit;

use App\Models\Deceased;
use App\Models\FuneralService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeceasedTest extends TestCase
{
    use RefreshDatabase;

    public function test_deceased_can_be_created(): void
    {
        $deceased = Deceased::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

        $this->assertDatabaseHas('deceased', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);
    }

    public function test_get_full_name_attribute(): void
    {
        $deceased = Deceased::factory()->make([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('Jane Doe', $deceased->full_name);
    }

    public function test_deceased_has_funeral_services_relationship(): void
    {
        $deceased = Deceased::factory()->create();
        $funeralService = FuneralService::factory()->create(['deceased_id' => $deceased->id]);

        $this->assertTrue($deceased->funeralServices->contains($funeralService));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $deceased->funeralServices);
    }

    public function test_deceased_supports_soft_deletes(): void
    {
        $deceased = Deceased::factory()->create();
        $deceased->delete();

        $this->assertSoftDeleted($deceased);
    }

    public function test_date_fields_are_cast_to_carbon(): void
    {
        $deceased = Deceased::factory()->create([
            'date_of_birth' => '1950-01-01',
            'date_of_death' => '2023-01-01',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $deceased->date_of_birth);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $deceased->date_of_death);
    }
}
