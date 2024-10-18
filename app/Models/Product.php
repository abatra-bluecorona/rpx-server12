<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = ['slug', 'name', 'type', 'updates_enabled', 'download_url', 'version'];

    public function clients() {
        return $this->belongsToMany(Client::class, 'client_products')->withPivot('updates_enabled');
    }
}
