<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venda;
use Faker\Generator as Faker;

$clientes_id= \App\Cliente::all()->pluck('id');
$factory->define(Venda::class, function (Faker $faker) use ($clientes_id) {
    $n=$faker->numberBetween(0,$clientes_id->count() -1);
    return [
        'data_venda' => date('d/m/Y'),
        'cliente_id'=>$clientes_id[$n],
    ];
});
