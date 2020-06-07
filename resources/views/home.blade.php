@extends('layouts.app')

@section('breadcrumb')
<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i> Painel de Controle</h1>
    <p>Página Inicial do Sistema NinaCazen</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
  <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
  </ul>
</div>

@endsection


@section('content')


  <div class="row">
    <div class="col-md-12">
      
      <div class="tile">
        <div class="tile-body">Neste Espaço Inicial do Sistema contruíremos alguns indicadores importantes</div>
      </div>

    </div>
  </div>

@endsection
