<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPriv extends Model
{
    use HasFactory;
    protected $connection = 'users';
    protected $table = 'user_priv';
    protected $fillable = ['user_id','level','syscode'];
    public $timestamps = false;
}
