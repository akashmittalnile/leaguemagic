<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $hidden = ['updated_at'];
    public function confrence()
    {
        return $this->belongsTo(Conference::class, "conference_id");
    }
    public function region()
    {
        return $this->belongsTo(Reagion::class, "region_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
