<?php

namespace App\Http\Controllers;

use App\Venda;
use Illuminate\Http\Request;
use App\Http\Requests\VendaRequest;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::with('cliente')->get();
        return view("vendas.index", compact('vendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados = [
            'produtos' => \App\Produto::all(),
            'clientes' => \App\Cliente::pluck('nome', 'id'),
        ];
        return view('vendas.create', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaRequest $request)
    {
        $venda= Venda::create($request->all());
        $this->saveProdutos($venda, $request);
        \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        return redirect('vendas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function show(Venda $venda)
    {
        return $venda->load('produtos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function edit(Venda $venda)
    {
        $dados = [
            'produtos' => \App\Produto::all(),
            'clientes' => \App\Cliente::pluck('nome', 'id'),
             'venda'=>$venda
        ];
        return view('vendas.edit', $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function update(VendaRequest $request, Venda $venda)
    {
        $venda->update($request->all());
        $this->saveProdutos($venda, $request);
       \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
       return redirect()->route('vendas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venda $venda)
    {
        $produtos=$venda->produtos;
        //$retorno = $venda->verifyAndDelete();
       $retorno = $venda->delete();
       if ($retorno):
       // \App\Helpers\ProdutoHelper::updateQtdDisponivelByProdutos($produtos);
           \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
       endif;

       return redirect()->route('vendas.index');
    }

    public function destroyBath()
    {
    // $produtos= \App\Helpers\ProdutoHelper::getProdutosByRentsIds(request('ids'));
     $retorno= Venda::destroy(request('ids'));
     if ($retorno):
       // \App\Helpers\ProdutoHelper::updateQtdDisponivelByProdutos($produtos);
        \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans_choice('messages.actionDelete', $retorno)]);
        endif;

        return redirect()->route('vendas.index');
    }

    private function saveProdutos($venda, $request)
    {
        $produtos= json_decode($request->produtos_json, true);
        $dados= [];
        
        //montar array com índice sendo o produto_id. Ex: 3=>['qtd'=>10,'valor_venda'=>100]
        foreach($produtos as $produto):
            $product=$produto;
            unset($product['produto_id']);
            $dados[$produto['produto_id']]=$product;
        endforeach;
        $venda->produtos()->sync($dados);
        
    }

    public function print(Venda $venda)
    {
      return view('vendas.print', compact('venda'));
    }

}
