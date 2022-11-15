<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetNote extends Model
{
    use HasFactory;
    protected $table = "meet_note";
    protected $fillable = array(
        "meet_id",
        "note"
    );
    public function meet()
    {
        return $this->belongsTo(Meet::class);
    }
}
