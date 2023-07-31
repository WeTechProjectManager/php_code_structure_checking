<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paid_for',
        'transaction_id',
        'amount',
        'date',
        'Status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
