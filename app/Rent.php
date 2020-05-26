<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable=['cliente_id','data_saida','data_retorno','observacao'];
    
     public function produtos()
    {
        return $this->belongsToMany('App\Produto')
                ->withPivot('qtd', 'valor_aluguel','devolvido')
                ->withTimestamps();
    }
    
    public function cliente(){
        return $this->belongsTo("App\Cliente");
    }

    

    public function getProdutosJsonAttribute() {
         $x= $this->produtos;
         $list=[];
         foreach($this->produtos as $produto):
             $x= new \stdClass();
             $x->produto_id=$produto->id;
             $x->qtd=$produto->pivot->qtd;
             $x->valor_aluguel=$produto->pivot->valor_aluguel;
             $list[]=$x;
         endforeach;
         return json_encode($list);
         //return '[{"produto_id":"5","qtd":"37","valor_aluguel":"10.00"},{"produto_id":"4","qtd":"30","valor_aluguel":"1.00"}]';
    }
}
