<?php

namespace App\Models;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = 'addresses';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'codAddress';

    protected $fillable = [
        'name',
        'addressPrimary',
        'addressSecundary',
        'postal_code',
        'city',
        'state',
        'codCountry',
        'codUser'
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'codCountry', 'codCountry');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
