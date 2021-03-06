<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $connection ='users';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function userPriv()
    {
        return $this->hasMany('App\Models\UserPriv');
    }

    public function level()
    {
        $check = $this->userPriv()->where('syscode','intranet')->first();
        if($check)
            return $check->level;
        return 'standard';
    }

    public function approved()
    {
        return $this->hasMany('App\Models\Approve');
    }

    public function isApproved($node_id)
    {
        if($this->isAdmin()){
            return true;
        }
        return $this->approved()->where('node_id',$node_id)->first();
    }

    public function isAdmin()
    {
        return $this->userPriv()->where('syscode','intranet')->where('level','admin')->exists();
    }
}
