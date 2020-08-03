<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rent;
use Faker\Generator as Faker;

$clientes_id= \App\Cliente::all()->pluck('id');
$factory->define(Rent::class, function (Faker $faker) use ($clientes_id) {
    $n=$faker->numberBetween(0,$clientes_id->count() -1);
    return [
        'data_saida' => date('d/m/Y'),
        'data_retorno'=>date('d/m/Y'),
        'cliente_id'=>$clientes_id[$n],
        'devolvido'=>0
    ];
});
