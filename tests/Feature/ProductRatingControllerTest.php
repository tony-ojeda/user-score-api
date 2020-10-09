<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRatingControllerTest extends TestCase
{
    use RefreshDatabase;
    private User $normalUser;
    private User $adminUser;
    private Product $product;

    protected function setUp(): void {
        parent::setUp();
        $this->normalUser = \App\Models\User::factory()->create();
        $this->adminUser = \App\Models\User::factory()->create();
        $this->product = \App\Models\Product::factory()->create();
    }

    public function test_rate_product() {
        Sanctum::actingAs($this->normalUser);

        $response = $this->postJson("/api/products/{$this->product->getKey()}/rate",[
            'score' => 5
        ]);
        
        // dd($response->content());
        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDatabaseHas('ratings',[
            'score' => 5,
            'rateable_id' => $this->product->getKey(),
            'rateable_type' => Product::class
        ]);
    }

    public function test_invalid_rate_without_user_logged() {
        $response = $this->postJson("/api/products/{$this->product->getKey()}/rate",[
            'score' => 10
        ]);

        $response->assertUnauthorized();
    }

    public function test_invalid_rate_without_score() {
        Sanctum::actingAs($this->normalUser);
        $response = $this->postJson("/api/products/{$this->product->getKey()}/rate",[]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'score' => 'required'
        ]);
    }

    public function test_unrate_product() {
        Sanctum::actingAs($this->normalUser);

        $this->normalUser->rate($this->product, 3);
        $response = $this->postJson("/api/products/{$this->product->getKey()}/unrate");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDatabaseMissing('ratings',[
            'score' => 3,
            'rateable_id' => $this->product->getKey(),
            'rateable_type' => Product::class
        ]);
    }

    public function test_invalid_unrate_without_user_logged() {
        $response = $this->postJson("/api/products/{$this->product->getKey()}/unrate");
        $response->assertUnauthorized();
    }
}
