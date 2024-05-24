<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackTerminalResult extends Model
{
    protected $table = 'hack_terminal_result';

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'terminal_id', 'terminal_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
