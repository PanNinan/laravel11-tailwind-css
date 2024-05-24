<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackHardwareResult extends Model
{
    protected $table = 'hack_hardware_result';

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'unique_id', 'terminal_id');
//        return $this->belongsTo(Device::class, 'terminal_id', 'unique_id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'unique_id', 'mac');
//        return $this->belongsTo(Sensor::class, 'mac', 'unique_id');
    }
}
