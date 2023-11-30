<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoPagamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
    ];

    public function fechamentos(){
        return $this->hasMany(Fechamento::class);
    }

}
