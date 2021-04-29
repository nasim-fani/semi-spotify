<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class IpLoginlimit extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['ID', 'ip', 'timeDiff'];

    protected $table = 'ip_loginLimit';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
