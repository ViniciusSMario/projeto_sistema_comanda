<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    protected $table = "comandas";

    protected $fillable = [
        'mesas_id',
        'nome',
        'celular',
        'status'
    ];

    public function mesas(){
        return $this->belongsTo(Mesa::class);
    }

    public function fechamentos(){
        return $this->hasMany(Fechamento::class, 'comandas_id');
    }

    public function itens_comandas(){
        return $this->hasMany(ItensComanda::class, 'comandas_id');
    }
}
