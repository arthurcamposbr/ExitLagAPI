<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = [
        'resposta'
    ];

    public function questao()
    {
        return $this->belongsTo('App\Models\Questoe');
    }
}
