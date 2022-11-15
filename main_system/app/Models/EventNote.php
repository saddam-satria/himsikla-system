<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventNote extends Model
{
    protected $table = "event_note";
    protected $fillable = array(
        "id",
        "event_id"
    );
    use HasFactory;
    public function note()
    {
        return $this->hasOne(Note::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
