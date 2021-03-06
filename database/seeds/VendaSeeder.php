<?php

use Illuminate\Database\Seeder;

class VendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Venda::class, 21)->create()->each(function ($venda) {
            
            // Seed the relation with 5 purchases
            $produtos = factory(App\Produto::class, 2)->make();
            foreach($produtos as $produto):
                $venda->produtos()->save($produto,['qtd'=>1,'valor_venda'=>$produto->valor_venda]);
            endforeach;
        });
    }
}
