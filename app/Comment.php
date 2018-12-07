<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $guarded = ['id'];
    
    public function ticket() {
        return $this->belongsTo('App\Ticket');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
