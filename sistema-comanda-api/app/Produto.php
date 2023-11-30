<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categorias_id'
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function itens_comandas(){
        return $this->hasMany(ItensComanda::class, 'produtos_id');
    }
}
