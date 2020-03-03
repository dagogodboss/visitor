<?php

namespace App;

use App\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use YoHang88\LetterAvatar\LetterAvatar;


class User extends Authenticatable
{
    use Notifiable, HasRoles;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarAttribute()
    {
        return new LetterAvatar($this->name);

    }
    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == 'admin')
            {
                return 'admin';
            }elseif($role->name == 'employee'){
                return 'employee';
            }
        }
        return false;
    }
    public function employee()
    {
        return $this->hasOne('App\Models\Employee');
    }
}
