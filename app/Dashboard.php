<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public static function getCards(){
        $cards=[
            "alugueisVencidos"=>Dashboard::alugueisVencidos(),
            "retornoHoje"=>Dashboard::retornoHoje(),
            "produtosFalta"=>Dashboard::produtosFalta(),
            "vendasHoje"=>Dashboard::vendasHoje(),
            "saidaHoje"=>Dashboard::saidaHoje(),
            "produtosQtdFora"=>Dashboard::produtosQtdFora(),
        ];
        return $cards;
    }

    public static function alugueisVencidos(){
        $hoje= date("Y-m-d");
        return \DB::table('rents')->where('data_retorno','<',$hoje)
                        ->where('devolvido',0)->count();
    }

    public static function retornoHoje(){
        $hoje= date("Y-m-d");
        return \DB::table('rents')->where('data_retorno',$hoje)->count();
    }

    public static function produtosFalta(){
        return \DB::table('produtos')->where('qtd_disponivel',0)->count();
    }

    public static function vendasHoje(){
        $hoje= date("Y-m-d");
        return \DB::table('vendas')->where('data_venda', $hoje)->count();
    }

    public static function saidaHoje(){
        $hoje= date("Y-m-d");
        return \DB::table('rents')->where('data_saida', $hoje)->count();
    }

    public static function produtosQtdFora(){
        return \DB::table('produto_rent')->where('devolvido',0)->sum('qtd');
    }
}
