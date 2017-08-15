<?php

namespace Alanmanderson\HeadCount\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events() {
        return $this->belongsToMany('Alanmanderson\HeadCount\Models\Event');
    }

    public function routeNotificationForNexmo() {
        if (strpos($this->phone, '1') === 0){
            return $this->phone;
        }
        return '1' . $this->phone;
    }
}
