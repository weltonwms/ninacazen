<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable=['nome','descricao','valor_aluguel','valor_venda','qtd_estoque'];

    public function getFormatedValorAluguelAttribute()
    {
        return number_format($this->attributes['valor_aluguel'], 2, ',', '.');
    }
    
    public function getFormatedValorVendaAttribute()
    {
        return number_format($this->attributes['valor_venda'], 2, ',', '.');
    }

    
    public function setValorAluguelAttribute($price)
    {
        if (!is_numeric($price)):
            $price = str_replace(".", "", $price);
            $price = str_replace(",", ".", $price);
        endif;
        $this->attributes['valor_aluguel'] = $price;
    }
    
    public function setValorVendaAttribute($price)
    {
        if (!is_numeric($price)):
            $price = str_replace(".", "", $price);
            $price = str_replace(",", ".", $price);
        endif;
        $this->attributes['valor_venda'] = $price;
    }
}
