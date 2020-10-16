<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, CanBeRate;

    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class,'created_by');
    }

}
