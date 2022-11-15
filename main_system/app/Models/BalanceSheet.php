<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasFactory;
    protected $table = "balance_sheet";
    protected $fillable = array(
        "month",
        "kredit",
        "debit",
        "note",
    );
}
