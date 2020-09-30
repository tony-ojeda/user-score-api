<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_category_has_many_products() {
        $category = \App\Models\Category::factory()->create();
        // $product1 = Product::factory()->create(['category_id' => $category->id]);
        // $product2 = Product::factory()->create(['category_id' => $category->id]);
        // $product3 = Product::factory()->create(['category_id' => $category->id]);

        // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$category->products);
        // $this->assertEquals(3, $category->products->count());
    }
}
