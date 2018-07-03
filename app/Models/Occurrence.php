<?php

namespace Alanmanderson\HeadCount\Models;

use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model {
    protected $fillable = ['event_id', 'start_time'];
    protected $casts = [
            'start_time' => 'datetime'
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function replies(){
        return $this->hasMany('Alanmanderson\HeadCount\Models\Reply');
    }
}
