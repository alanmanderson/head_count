<?php

namespace Alanmanderson\HeadCount\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
    protected $fillable = ['user_id', 'occurrence_id', 'likelihood'];

    public function user(){
        return $this->belongsTo('Alanmanderson\HeadCount\Models\User');
    }

    public function scopeByUserAndOccurrence($query, $userId, $occurrenceId){
        $query->whereColumn([
            ['user_id' => $userId],
            ['occurrence_id' => $occurrenceId]
        ]);
    }
}
