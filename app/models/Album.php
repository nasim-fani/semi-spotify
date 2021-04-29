<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class Album extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['AlbumTitle', 'genre', 'regDate', 'Mname', 'Mtime', 'ArtName'];

    protected $table = 'album';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
