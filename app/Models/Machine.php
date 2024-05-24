<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Machine extends Model
{
    protected $table = 'machine';

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
