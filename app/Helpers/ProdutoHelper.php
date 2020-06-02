<?php

namespace App\Helpers;
//use App\Rent;
use App\Produto;

/**
 * Classe de apoio a Produtos
 *
 * @author welton
 */
class ProdutoHelper {
    
   
    public static function getProdutosByRentsIds($rents_ids)
    {
        $produtos = Produto::whereHas('rents', function ($query) use($rents_ids){
            $query->whereIn('rent_id', $rents_ids);
        })->get();
        return $produtos;
    }

    public static function updateQtdDisponivelByProdutoId($produto_id)
    {
        $produto= Produto::find($produto_id);
        $produto->updateQtdDisponivel();
    }

    public static function updateQtdDisponivelByProdutos($produtos)
    {
        foreach($produtos as $produto):
            $produto->updateQtdDisponivel();
        endforeach;
    }

    
}
