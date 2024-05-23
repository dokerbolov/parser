<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';

    protected $table = 'genre';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
    ];
}
