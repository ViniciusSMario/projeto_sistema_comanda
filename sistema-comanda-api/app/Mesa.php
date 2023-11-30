<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'status',
    ];

    public function comandas(){
        return $this->hasMany(Comanda::class, 'mesas_id');
    }

}
