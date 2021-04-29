<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class User extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['username', 'pass', 'email', 'userType' , 'hashedpass'];

    protected $table = 'user';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
