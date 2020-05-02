<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produto;
use Faker\Generator as Faker;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'descricao' => $faker->city,
        'valor_aluguel' => $faker->randomNumber(2),
        'qtd_estoque' => $faker->numberBetween(20,1000)
        
    ];
});
