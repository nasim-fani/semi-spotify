<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class RequestControl extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['ip', 'requests', 'expires'];

    protected $table = 'RequestControl';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
