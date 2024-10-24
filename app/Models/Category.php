<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'ku',
        'ar',
        'en',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
