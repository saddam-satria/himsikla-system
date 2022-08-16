<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $table = "role";
    protected $fillable = array(
        "id",
        'roleName'
    );
    public $incrementing = true;
    public $keyType = 'int';
}
