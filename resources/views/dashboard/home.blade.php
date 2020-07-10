@extends('layouts.app')

@section('breadcrumb')
  @breadcrumbs(['title'=>'Painel de Controle',
  'icon'=>'fa-dashboard','route'=>route('home'),'subtitle'=>'Página Inicial do
  Sistema NinaCazen'])
  @endbreadcrumbs
@endsection


@section('content')
<style>
  .tile.tile-mensagens {
    display: none;
  }
</style>


{{-- inicio cards --}}
@include('dashboard.cards')
{{-- temino cards --}}








<div class="row">
  <div class="col-md-12">
    <div class="tile">
      {{-- inicio corpo --}}
















      {{-- Fim corpo --}}
    </div>
  </div>
</div>

@endsection