<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = "member";
    protected $fillable = [
        "name",
        "address",
        "nim",
        "status",
        "image",
        "occupation",
        "token",
        "location",
        "periode",
        "user_id",
        "phoneNumber"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function meet()
    {
        return $this->belongsToMany(Meet::class, "meet_absence");
    }
}
