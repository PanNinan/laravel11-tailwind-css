<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensor';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
