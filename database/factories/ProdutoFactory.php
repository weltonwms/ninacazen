<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produto;
use Faker\Generator as Faker;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'nome' => $faker->state,
        'valor_aluguel' => $faker->randomNumber(2),
        'valor_venda' => $faker->randomNumber(2),
        'qtd_estoque' => $faker->numberBetween(20,1000)
        
    ];
});
