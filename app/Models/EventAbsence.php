<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAbsence extends Model
{
    use HasFactory;
    protected $table = "event_absence";
    protected $fillable = array(
        "email",
        "nim",
        "university",
        "event_id",
        "status",
        "isPaidOff"
    );
    public function event()
    {
        return $this->belongsToMany(Event::class);
    }
}
