<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItensComanda extends Model
{
    protected $fillable = [
        'comandas_id',
        'produtos_id',
        'quantidade',
        'valor',
        'status'
    ];

    public function comandas(){
        return $this->belongsTo(Comanda::class, 'comandas_id');
    }

    public function produtos(){
        return $this->belongsTo(Produto::class, 'produtos_id');
    }
}
