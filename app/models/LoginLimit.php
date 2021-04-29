<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class LoginLimit extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['ID', 'username', 'timeDiff'];
    
    protected $table = 'loginLimit';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
