<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    use HasFactory;
    protected $table = "meet";
    protected $fillable = array(
        "meetName",
        "material",
        "startAt",
        "endAt",
        "location",
        "status",
        "isOnline",
        "description",
        "banner",
        "price",
        "detailLocation",
        "member_id",
    );
    public function note()
    {
        return $this->hasOne(MeetNote::class);
    }
    public function absence()
    {

        return $this->belongsToMany(Member::class, "meet_absence");
    }
}
