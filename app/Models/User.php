<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'cedula_identidad',
        'email',
        'password',
        'phone',
        'address',
        'profile',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImagenAttribute()
    {
        if (file_exists('storage/usuarios/' . $this->image)) {
            return $this->image;
        } else {
            return 'default.png';
        }
    }
    public static function check_old_password($id, $old_password)
    {
        $user = User::find($id);
        if (password_verify($old_password, $user->password)) {
            return true;
        } else {
            return false;
        }
    }
}
