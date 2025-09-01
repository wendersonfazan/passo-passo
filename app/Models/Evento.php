<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'evento';

    protected $fillable = [
        'nome',
        'data',
        'descricao',
        'duracao',
        'status',
    ];

    public function Agendas()
    {
        return $this->hasMany(Agenda::class, 'evento_id', 'id');
    }

}
