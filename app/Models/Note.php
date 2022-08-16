<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table  = "note";
    protected $fillable = array(
        "event_note_id",
        "note"
    );
    use HasFactory;
    public function event()
    {
        return $this->belongsTo(EventNote::class);
    }
}
