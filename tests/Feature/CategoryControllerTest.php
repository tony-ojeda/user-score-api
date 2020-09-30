<?php 

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $response->assertJsonCount(5,'data');
    }

    public function test_create_new_category() {
        $data = [
            'name' => 'Hola',
        ];

        $response = $this->postJson('/api/categories',$data);

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDatabaseHas('categories',$data);
    }

    public function test_update_categories() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $category = \App\Models\Category::factory()->create();

        $data = [
            'name' => 'Update Category',
        ];

        $response = $this->patchJson("/api/categories/{$category->getKey()}",$data);
        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
    }

    public function test_unique_name_create_category() {
        $data = [
            'name' => 'Hola'
        ];

        $this->postJson('/api/categories', $data);
        $response = $this->postJson('/api/categories',$data);

        $response->assertJsonValidationErrors([
            'name'
        ]);


    }

    public function test_show_category() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $product = \App\Models\Category::factory()->create();

        $response = $this->getJson("/api/categories/{$product->getKey}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');

    }

    public function test_delete_category() {
        /** @var Category $product */
        // $product = factory(Category::class)->create();
        $product = \App\Models\Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type','application/json');
        $this->assertDeleted($product);
    }
}