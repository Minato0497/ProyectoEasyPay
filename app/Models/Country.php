<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory,Notifiable;
    protected $table='countries';
    protected $primaryKey = 'codCountry';
    protected $fillable=[
        'country',
    ];


    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
