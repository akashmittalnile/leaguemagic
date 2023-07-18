<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reagion extends Model
{
    protected $hidden = ['sort_order', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function confrence()
    {
        return $this->belongsTo(Conference::class, "confefrence_id");
    }
}
