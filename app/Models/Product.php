<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock', 'unit'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
