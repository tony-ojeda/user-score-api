<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Pivot
{
    use HasFactory; 
    public $incrementing = true; // le dicimos que tenemos campos autoincrementables
    protected $table = 'ratings';

    public function rateable() { // definimos las relaciones
        return $this->morphTo();
    }

    public function qualifier() { // definimos las relaciones
        return $this->morphTo();
    }
}
