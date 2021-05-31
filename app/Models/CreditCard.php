<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_card_type',
        'credit_card_numbers',
        'credit_card_expiration_date',

    ];

    protected $hidden = [
        'code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
