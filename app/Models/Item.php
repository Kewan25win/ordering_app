<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'ku',
        'ar',
        'en',
        'desc_ku',
        'desc_ar',
        'desc_en',
        'brand_id',
        'subcategory_id',
        'price',
        'discount',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
