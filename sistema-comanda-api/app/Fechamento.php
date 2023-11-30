<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fechamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'comandas_id',
        'tipo_pagamentos_id',
        'valor_total'
    ];

    public function comandas(){
        return $this->belongsTo(Comanda::class);
    }

    public function tipo_pagamentos(){
        return $this->belongsTo(TipoPagamento::class);
    }
}
