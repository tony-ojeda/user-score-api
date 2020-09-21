<?php 

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CategoryControllerTest extends TestCase 
{
    use RefreshDatabase;

    protected function setUp():void {
        parent::setUp();
        Sanctum::actingAs(\App\Models\User::factory()->create());
    }

    public function test_index() {

        // factory(Category::class, 5)->create();
        \App\Models\Category::factory()->count(5)->create();

        $response = $this->getJson('/api/categories');
        // dd($response->content());

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $response->assertJsonCount(5);
    }

    public function test_create_new_product() {
        $data = [
            'name' => 'Hola',
        ];

        $response = $this->postJson('/api/categories',$data);

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDatabaseHas('categories',$data);
    }

    public function test_update_product() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $product = \App\Models\Category::factory()->create();

        $data = [
            'name' => 'Update Category',
        ];

        $response = $this->patchJson("/api/categories/{$product->getKey()}",$data);
        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
    }

    public function test_show_product() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $product = \App\Models\Category::factory()->create();

        $response = $this->getJson("/api/categories/{$product->getKey}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');

    }

    public function test_delete_product() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $product = \App\Models\Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDeleted($product);
    }
}