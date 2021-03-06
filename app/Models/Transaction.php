<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'status_id',
        'gateway_id'
    ];

    /*
    * Relações
    */

    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
