<?php

namespace App\Http\Controllers;

use App\Rent;
use Illuminate\Http\Request;
use App\Http\Requests\RentRequest;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $rents = Rent::with('cliente')->get();
        return view("rents.index", compact('rents'));
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
        return view('rents.create', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentRequest $request)
    {
         $rent= Rent::create($request->all());
         $this->saveProdutos($rent, $request);
        \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        return redirect('rents');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        return $rent->load('produtos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
       $dados = [
            'produtos' => \App\Produto::all(),
            'clientes' => \App\Cliente::pluck('nome', 'id'),
             'rent'=>$rent
        ];
        return view('rents.edit', $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(RentRequest $request, Rent $rent)
    {
        
         $rent->update($request->all());
         $this->saveProdutos($rent, $request);
        \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
        return redirect()->route('rents.index');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //$retorno = $rent->verifyAndDelete();
       $retorno = $rent->delete();
       if ($retorno):
           \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
       endif;

       return redirect()->route('rents.index');
    }
    
    public function destroyBath()
    {
     $retorno= Rent::destroy(request('ids'));
     if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans_choice('messages.actionDelete', $retorno)]);
        endif;

        return redirect()->route('rents.index');
    }
    
    private function saveProdutos($rent, $request)
    {
        $produtos= json_decode($request->produtos_json, true);
        $dados= [];
        //montar array com índice sendo o produto_id. Ex: 3=>['qtd'=>10,'valor_aluguel'=>100]
        foreach($produtos as $produto):
            $product=$produto;
            unset($product['produto_id']);
            $dados[$produto['produto_id']]=$product;
            
        endforeach;
        
        $rent->produtos()->sync($dados);
        
    }
}
