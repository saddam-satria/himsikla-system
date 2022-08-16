<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    use HasFactory;
    protected $table = "gallery";
    protected $fillable = array(
        "image"
    );
    public $incrementing = true;
    public $keyType = 'int';
}
