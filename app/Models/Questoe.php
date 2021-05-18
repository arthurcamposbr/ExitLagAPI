<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'pergunta'
    ];

    public function respostas()
    {
        return $this->hasMany('App\Models\Resposta');
    }
}
