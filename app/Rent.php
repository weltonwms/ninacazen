<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon ;
use Collective\Html\Eloquent\FormAccessible;

class Rent extends Model
{
    use FormAccessible;
    protected $fillable=['cliente_id','data_saida','data_retorno','observacao'];
    protected $dates = array('data_saida','data_retorno');
    
    
    public function produtos()
    {
        return $this->belongsToMany('App\Produto')
                ->withPivot('qtd', 'valor_aluguel','devolvido')
                ->withTimestamps();
    }
    
    public function cliente(){
        return $this->belongsTo("App\Cliente");
    }
    
     public function getDataSaidaAttribute($value)
    {
       return Carbon::parse($value)->format('d/m/Y');
    }
    
     public function formDataSaidaAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function setDataSaidaAttribute($value){
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $value);
            $value = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            //sobrescrevendo o value em formato mysql
        }
        if($value){
            //protegendo de fazer um parse em nada. Isso resulta em data e hora atual
            $this->attributes['data_saida'] = Carbon::parse($value)->format('Y-m-d');
        } 
        else{
            $this->attributes['data_saida'] = null;
        }    
       
    }
    
     public function getDataRetornoAttribute($value)
    {
       return Carbon::parse($value)->format('d/m/Y');
    }
    
     public function formDataRetornoAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function setDataRetornoAttribute($value){
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $value);
            $value = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            //sobrescrevendo o value em formato mysql
        }
        if($value){
            //protegendo de fazer um parse em nada. Isso resulta em data e hora atual
            $this->attributes['data_retorno'] = Carbon::parse($value)->format('Y-m-d');
        } 
        else{
            $this->attributes['data_retorno'] = null;
        }    
       
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
