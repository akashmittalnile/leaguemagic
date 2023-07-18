<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function position()
    {
        return $this->belongsTo(Positions::class, 'group_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
