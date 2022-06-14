<?php

namespace App\Models;

use App\Models\Address;
use App\Models\CreditCard;
use Spatie\MediaLibrary\HasMedia;
use App\Models\RecordMoneyTransfer;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, InteractsWithMedia;
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

    public function has_movements()
    {
        return $this->hasMany(Movement::class, 'codEmisor', 'id')->orderBy('date_movement', 'DESC');
    }

    public function adminlte_image()
    {
        // return $this->getFirstMediaPath('profile');
        return asset('img/logo.jpeg');
    }

    public function adminlte_desc()
    {
        // $user = User::find(Auth::user()->id);
        $roles = [];
        $view = '';
        if ($this->roles) {
            foreach ($this->roles->pluck('name') as $role) {
                $roles[] = $role;
            }
            $view = implode(", ", $roles);
        } else {
            $view = '';
        }
        return $view;
        // return $role = $user->getRoleNames();
    }

    public function adminlte_profile_url()
    {
        return route('user.profiles.show', auth()->user()->id);
    }

    public function registerMediaCollections(): void
    {
        //Para que funcione, debe de matchear la addMediaCollection
        $this->addMediaCollection('profile')->singleFile();
    }
}
