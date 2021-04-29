<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Listener extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['firstName', 'lastName', 'nationality', 'DateOfBirth', 'username', 'userType'];

    protected $table = 'listener';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
