<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Playlist extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['pName','username' ,'Mname' , 'addDate', 'ArtName'];

    protected $table = 'playlist';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
