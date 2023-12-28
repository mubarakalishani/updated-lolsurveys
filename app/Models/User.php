<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'username', 'unique_user_id', 'secret_key', 'signup_ip', 'last_ip', 'country', 'email', 'password', 'status',
    ];

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function advertiserStat()
    {
        return $this->hasMany(AdvertiserStat::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addWorkerBalance($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function deductWorkerBalance($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }

    public function addAdvertiserBalance($amount)
    {
        $this->deposit_balance += $amount;
        $this->save();
    }

    public function deductAdvertiserBalance($amount)
    {
        $this->deposit_balance -= $amount;
        $this->save();
    }

    public function scopeSearch($query, $value)
    {
         $query->where('username', 'like', "%{$value}%")
         ->orWhere('country', 'like', "%{$value}%")
         ->orWhere('name', 'like', "%{$value}%");
    }



}
