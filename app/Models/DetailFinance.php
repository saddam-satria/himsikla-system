<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFinance extends Model
{
    use HasFactory;
    protected $table = "detail_finance";
    protected $fillable = array(
        "member_id",
        "finance_id",
        "receipt_id",
        "paymentMethod",
        "cash",
        "status",
    );
    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }
}
