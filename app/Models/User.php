<?php

namespace App\Models;

use App\Models\Address;
use App\Models\CreditCard;
use App\Models\RecordMoneyTransfer;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phoneNumber',
        'monedero',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function credit_card()
    {
        return $this->hasOne(CreditCard::class, 'codUser', 'id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'codUser', 'id');
    }

    public function record_money_transfer()
    {
        return $this->hasOne(RecordMoneyTransfer::class, 'envia_id', 'id');
    }

    public function adminlte_image()
    {
        return asset('img/logo.jpeg');
    }

    public function adminlte_desc()
    {
        $user = User::find(Auth::user()->id);

        return $role = $user->getRoleNames();
    }

    public function adminlte_profile_url()
    {
        return 'user/profile/{profile}';
    }
}
