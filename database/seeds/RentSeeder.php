<?php

use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Rent::class, 20)->create()->each(function ($rent) {
            
            // Seed the relation with 5 purchases
            $produtos = factory(App\Produto::class, 2)->make();
            foreach($produtos as $produto):
                $rent->produtos()->save($produto,['qtd'=>1,'valor_aluguel'=>$produto->valor_aluguel,'devolvido'=>0]);
            endforeach;
        });
    }
}
