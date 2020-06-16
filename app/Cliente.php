<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon ;
use Collective\Html\Eloquent\FormAccessible;

class Cliente extends Model
{
    use FormAccessible;
    protected $fillable=['nome','email','telefone','nascimento','cep', 'endereco','cpf'];
    protected $dates = array('nascimento');
    
//    public function rents()
//     {
//         return $this->hasMany("App\Rent");
//     }
    
    public function getNascimentoAttribute($value)
    {
        if($value):
            //evitando fazer um parse em nada. Não seria necessário se campo fosse obrigatório
            return Carbon::parse($value)->format('d/m/Y');
            //return Carbon::parse($value)->format('Y-m-d');
        endif;
    }

        
    
    public function formNascimentoAttribute($value)
    {
        if($value):
            return Carbon::parse($value)->format('Y-m-d');
        endif;
       
    }
    
    
    public function setNascimentoAttribute($value){
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $value);
            $value = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            //sobrescrevendo o value em formato mysql
        }
        if($value){
            //protegendo de fazer um parse em nada. Isso resulta em data e hora atual
            $this->attributes['nascimento'] = Carbon::parse($value)->format('Y-m-d');
        } 
        else{
            $this->attributes['nascimento'] = null;
        }    
       
    }
    
//    public function verifyAndDelete()
//    {
//        if ($this->rents->count()) {
//            \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => "Existe Aluguel relacionado a este Cliente"]);
//            return false;
//        }
//        return $this->delete();
//    }
    
    
}
