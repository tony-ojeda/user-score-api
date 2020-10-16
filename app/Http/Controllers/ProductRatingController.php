<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\User;

class ProductRatingController extends Controller
{
    public function rate(Product $product, Request $request) {
        $this->validate($request,[
            'score' => 'required'
        ]);

        $user = $request->user();
        $user->rate($product, $request->get('score'));

        return new ProductResource($product);
    }

    public function unrate(Product $product, Request $request) {
        $user = $request->user();
        $user->unrate($product);

        return new ProductResource($product);
    }
}
