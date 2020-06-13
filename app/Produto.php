<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'descricao', 'valor_aluguel', 'valor_venda', 'qtd_estoque'];

    public function vendas()
    {
        return $this->belongsToMany('App\Venda')
            ->using('App\ProdutoVenda')
            ->withPivot('qtd', 'valor_venda')
            ->withTimestamps();
    }

    public function rents()
    {
        return $this->belongsToMany('App\Rent')
            ->wherePivot('devolvido', 0)
            ->using('App\ProdutoRent')
            ->withPivot('qtd', 'valor_aluguel', 'devolvido')
            ->withTimestamps();
    }

    public function countRents()
    {
        $produtosAlugados = $this->rents;
        $count = 0;
        foreach ($produtosAlugados as $produtoRent):
            $count += $produtoRent->pivot->qtd;
        endforeach;
        return $count;
    }

    public function countVendas()
    {
        $produtosVendidos = $this->vendas;
        $count = 0;
        foreach ($produtosVendidos as $produtoVenda):
            $count += $produtoVenda->pivot->qtd;
        endforeach;
        return $count;
    }

    public function updateQtdDisponivel()
    {
        $this->qtd_disponivel= $this->qtd_estoque - $this->countRents();
        $this->save();
    }

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
