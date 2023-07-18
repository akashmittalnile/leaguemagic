<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{

    protected $hidden = ['sort_order', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
