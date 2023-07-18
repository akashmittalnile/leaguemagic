<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $hidden = ['updated_at'];

    public function programClubs()
    {
        return $this->hasMany(ProgramClub::class);
    }
    public function programLocations()
    {
        return $this->hasMany(ProgramLocation::class);
    }
    public function programDates()
    {
        return $this->hasMany(ProgramDate::class);
    }

    public function programSlot()
    {
        return $this->hasOne(ProgramSlot::class);
    }
    public function programClubDivisions()
    {
        return $this->hasMany(ProgramClubDivision::class);
    }

    public function seasion()
    {
        return $this->belongsTo(Seasons::class, "season_id");
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
