<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_product_belongs_to_many_users()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->rate($product,5);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$user->ratings(Product::class)->get());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$product->qualifiers(User::class)->get());
    }

    public function test_averageRating() 
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $product = Product::factory()->create();

        $user->rate($product,5);
        $user2->rate($product,10);

        $this->assertEquals(7.5, $product->averageRating(User::class));
    }

    public function test_rating_model() 
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->rate($product,5);

        $rating = Rating::first();

        $this->assertInstanceOf(Product::class, $rating->rateable);
        $this->assertInstanceOf(User::class, $rating->qualifier);
    }
}
