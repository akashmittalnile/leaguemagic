<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $hidden = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
