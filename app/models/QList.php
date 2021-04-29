<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
class QList extends Eloquent
{
    public $name;

    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = ['question','username' ,'answer'];

    protected $table = 'questionslist';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
