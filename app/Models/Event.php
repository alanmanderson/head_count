<?php

namespace Alanmanderson\HeadCount\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    public function users(){
        return $this->belongsToMany('Alanmanderson\HeadCount\Models\User');
    }

    public function occurrences(){
        return $this->hasMany('Alanmanderson\HeadCount\Models\Occurrence');
    }

}