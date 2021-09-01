<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecordMoneyTransfer extends Model
{
    use HasFactory;
    protected $table = 'record_money_transfers';
    protected $primaryKey = 'codRecordMoneyTransfers';



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
