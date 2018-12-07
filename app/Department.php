<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 */
class Department extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function users() {
        return $this->hasMany('App\User');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }

    public function supervisor() {
        return $this->hasMany('App\User')->where('type', 'supervisor');
    }

    public function members() {
        return $this->hasMany('App\User')->where('type', 'member');
    }
}
