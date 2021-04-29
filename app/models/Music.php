<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Music extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['Mname', 'Mtime', 'ArtName', 'report'];

    protected $table = 'music';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
