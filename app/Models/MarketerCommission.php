<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketerCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_id',
        'transaction_id',
        'amount',
        'status',
    ];

    public function marketer(){
        return $this->belongsTo(User::class, 'marketer_id', 'id');
    }
}
