<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetAbsence extends Model
{
    use HasFactory;
    protected $table = "meet_absence";
    protected $fillable = array(
        "meet_id",
        "status",
        "member_id"
    );
    public function meet()
    {
        return $this->belongsToMany(Meet::class);
    }
    public function member()
    {
        return $this->belongsToMany(Member::class);
    }
}
