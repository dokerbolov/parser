<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';

    protected $table = 'matches';

    protected $primaryKey = 'id';

    protected $fillable = [
        'hash_id',
        'title',
        'description',
        'channel',
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
    ];
}
