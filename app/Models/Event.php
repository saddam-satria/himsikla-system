<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = "event";
    protected $fillable = array(
        "eventName",
        "startAt",
        "endAt",
        "description",
        "status",
        "banner",
        "isGeneral",
        "member_id",
        "isFree",
        "price",
        "detailLocation",
        "isOnline",
        "location",
        "feedback",
        "payment",
        "contactPerson"
    );
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
    public function absence()
    {
        return $this->hasMany(EventAbsence::class);
    }
    public function note()
    {
        return $this->hasOne(EventNote::class);
    }
}
