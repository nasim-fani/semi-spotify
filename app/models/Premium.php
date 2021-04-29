<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Premium extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['cardNo', 'expcardDate', 'buyDate', 'expDate', 'username', 'userType'];

    protected $table = 'premium';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
