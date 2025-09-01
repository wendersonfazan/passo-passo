<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'user_id',
        'evento_id',
        'status'
    ];

    public function Evento(): HasOne
    {
        return $this->hasOne(Evento::class, 'id', 'evento_id');
    }

    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
