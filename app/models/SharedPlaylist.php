<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class SharedPlaylist extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['pName','mainUsername' ,'addUsername' ];

    protected $table = 'sharedplaylist';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
