<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Artist extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['ArtName', 'nationality', 'startDate', 'username', 'userType', 'resType'];

    protected $table = 'artist';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
