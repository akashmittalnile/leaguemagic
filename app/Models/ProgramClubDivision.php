<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramClubDivision extends Model
{
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    public function combinedDivision()
    {
        $combined = "";
        if ($this->division_id != null || $this->division_id != "") {
            $combined .=   $this->division->name;
        }
        if ($this->level_id != null || $this->level_id != "") {
            $combined .= " " . $this->level->name;
        }
        if ($this->group_id != null || $this->group_id != "") {
            $combined .= " " . $this->group->name;
        }
        return $combined;
    }

    public function programClubDivisionSetting()
    {
        return $this->hasOne(ProgramClubDivisionSetting::class);
    }
}
