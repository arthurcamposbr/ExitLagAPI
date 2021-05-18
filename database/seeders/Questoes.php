<?php

namespace Database\Seeders;

use App\Models\Questoe;
use App\Models\Resposta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Questoes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Questoe::factory()->count(3)->create()->each(function ($questao) {
            Resposta::factory()->count(3)->create(['questoe_id'=>$questao->id]);
        });
    }
}
