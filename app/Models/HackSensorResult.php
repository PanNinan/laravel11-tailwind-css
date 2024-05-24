<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackSensorResult extends Model
{
    protected $table = 'hack_sensor_result';

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
        return $this->belongsTo(Device::class, 'mac', 'terminal_id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'mac', 'mac');
    }
}
