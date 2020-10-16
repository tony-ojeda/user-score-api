<?php 

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProductControllerTest extends TestCase 
{
    use RefreshDatabase;

    protected function setUp():void {
        parent::setUp();
        Sanctum::actingAs(\App\Models\User::factory()->create());
    }

    public function test_index() {

        // factory(Product::class, 5)->create();
        \App\Models\Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');
        // dd($response->content());

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $response->assertJsonCount(5,'data');
    }

    public function test_create_new_product() {
        $data = [
            'name' => 'Hola',
            'price' => 1000
        ];

        $response = $this->postJson('/api/products',$data);

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDatabaseHas('products',$data);
    }

    public function test_validation_new_product() {
        $data = [
            'price' => 1000,
        ];

        $response = $this->postJson('/api/products',$data);
        $response->assertJsonValidationErrors([
            'name',
        ]);
    }

    public function test_update_product() {
        /** @var Product $product */
        // $product = factory(Product::class)->create();
        $product = \App\Models\Product::factory()->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}",$data);
        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
    }

    public function test_show_product() {
        /** @var Product $product */
        // $product = factory(Product::class)->create();
        $product = \App\Models\Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->getKey}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');

    }

    public function test_delete_product() {
        /** @var Product $product */
        // $product = factory(Product::class)->create();
        $product = \App\Models\Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDeleted($product);
    }
}