<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable=['descricao','observacao','valor_aluguel','qtd_estoque'];

    public function getFormatedValorAluguelAttribute()
    {
        return number_format($this->attributes['valor_aluguel'], 2, ',', '.');
    }

    
    public function setValorAluguelAttribute($price)
    {
        if (!is_numeric($price)):
            $price = str_replace(".", "", $price);
            $price = str_replace(",", ".", $price);
        endif;
        $this->attributes['valor_aluguel'] = $price;
    }
}
