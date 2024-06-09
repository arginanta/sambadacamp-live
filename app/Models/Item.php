<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type_id',
        'brand_id',
        'photos',
        'features',
        'price',
        'star',
        'review',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    // Get first photo from photos
    public function getThumbnailAttribute() // thumbnail
    {
        // If photos exist
        if ($this->photos) {
            return Storage::url(json_decode($this->photos)[0]);
        }

        return 'https://via.placeholder.com/800x600';
    }

    // Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class); // One to Many (Inverse atau kebalikannya) / Belongs To
    }

    // Type
    public function type()
    {
        return $this->belongsTo(Type::class); // One to Many (Inverse atau kebalikannya) / Belongs To
    }

    // Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class); // One to Many
    }
}
