<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Play extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['Mname','pDate' ,'ArtName' , 'username'];
    
    protected $table = 'playlist';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
