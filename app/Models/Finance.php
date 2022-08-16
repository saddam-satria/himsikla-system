<?php

namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $table = "finance";
    protected $fillable = array(
        "month",
        "price",
        "description",
        "payment",
        "penalty"
    );
    public function detail()
    {
        return $this->hasMany(DetailFinance::class);
    }
}
