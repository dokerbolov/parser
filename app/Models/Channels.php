<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';

    protected $table = 'channels';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
    ];

    public function matches() {
        return $this->hasMany(Matches::class, 'channel', 'id');
    }
}
