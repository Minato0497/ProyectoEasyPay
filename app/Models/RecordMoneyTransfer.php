<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordMoneyTransfer extends Model
{
    use HasFactory;
    protected $table = 'record_money_transfers';


    protected $fillable = [
        'email_envia',
        'email_recibe',
        'monto',
        'envia_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
