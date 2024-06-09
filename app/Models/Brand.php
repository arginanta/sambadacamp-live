<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    // bahwa satu Brand dapat memiliki banyak Item, tetapi setiap Item hanya dimiliki oleh satu Brand.
    public function items() {
        return $this->hasMany(Item::class); // One To Many
    }

}
