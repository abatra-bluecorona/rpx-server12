<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website_url', 'rpx_token', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'client_products')->withPivot('updates_enabled');
    }

}
