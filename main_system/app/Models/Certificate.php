<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = "certificate";
    protected $fillable = array(
        "link",
        "event_id"
    );
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
