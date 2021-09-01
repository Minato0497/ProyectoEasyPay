<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditCard extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = 'credit_cards';
    protected $primaryKey = 'codCreditCard';

    protected $fillable = [
        'credit_card_numbers',
        'name',
        'code',
        'credit_card_type',
        'savings_account',
        'current_account',
        'credit_card_expiration_date',
        'codUser',
    ];
    protected $hidden = [
        'code',
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
