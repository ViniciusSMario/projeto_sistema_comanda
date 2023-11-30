<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome'];

    public function produtos(){
        return $this->hasMany(Produto::class);
    }

}
