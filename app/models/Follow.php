<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Follow extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['firstUsername', 'secondUsername'];

    protected $table = 'follow';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
