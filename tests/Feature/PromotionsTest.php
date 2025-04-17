<?php

namespace Tests\Feature;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionsTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_can_list_promotions()
    {
        $user = User::factory()->create();
        Promotion::factory()->count(5)->create();

        $this->actingAs($user)
            ->get(route('promotions.index'))
            ->assertStatus(200)
            ->assertSee(Promotion::first()->name);
    }


    public function test_it_can_filter_promotions_by_status()
    {
        $user = User::factory()->create();
        Promotion::factory()->create(['start_date' => now()->subDays(5), 'end_date' => now()->addDays(5)]); // Ongoing
        Promotion::factory()->create(['start_date' => now()->subDays(10), 'end_date' => now()->subDays(5)]); // Expired
        Promotion::factory()->create(['start_date' => now()->addDays(5), 'end_date' => now()->addDays(10)]); // Upcoming

        $this->actingAs($user)
            ->get(route('promotions.index', ['status' => 'V teku']))
            ->assertStatus(200)
            ->assertSee('V teku')
            ->assertDontSee('Potekla')
            ->assertDontSee('Prihajajoča');
    }


    public function test_it_can_create_a_promotion()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'New Promotion',
            'description' => 'This is a test promotion.',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDays(5)->toDateTimeString(),
            'is_active' => true,
        ];

        $this->actingAs($user)
            ->post(route('promotions.store'), $data)
            ->assertRedirect(route('promotions.index'));

        $this->assertDatabaseHas('promotions', ['name' => 'New Promotion']);
    }


    public function test_it_can_update_a_promotion()
    {
        $user = User::factory()->create();
        $promotion = Promotion::factory()->create();

        $data = [
            'name' => 'Updated Promotion',
            'description' => 'Updated description.',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDays(5)->toDateTimeString(),
        ];

        $this->actingAs($user)
            ->put(route('promotions.update', $promotion), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('promotions', ['name' => 'Updated Promotion']);
    }


    public function test_it_can_delete_a_promotion()
    {
        $user = User::factory()->create();
        $promotion = Promotion::factory()->create();

        $this->actingAs($user)
            ->delete(route('promotions.destroy', $promotion))
            ->assertRedirect();

        $this->assertSoftDeleted('promotions', ['id' => $promotion->id]);
    }


    public function test_it_can_show_active_promotions_to_visitors()
    {
        Promotion::factory()->create(['is_active' => true, 'start_date' => now()->subDays(1), 'end_date' => now()->addDays(1)]);

        $this->get(route('public.promotions.active'))
            ->assertStatus(200)
            ->assertSee(Promotion::first()->name);
    }


    public function test_it_validates_promotion_data_on_create()
    {
        $user = User::factory()->create();

        $data = [
            'name' => '', // Invalid name
            'description' => 'This is a test promotion.',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->subDays(5)->toDateTimeString(), // Invalid date range
        ];

        $this->actingAs($user)
            ->post(route('promotions.store'), $data)
            ->assertSessionHasErrors(['name', 'end_date']);
    }
}
