<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketerCommissionPayment extends Model
{
    use HasFactory;

    public function marketer(){
        return $this->belongsTo(User::class, 'marketer_id', 'id');
    }

}
