@extends('layouts.app')

@section('breadcrumb')
@breadcrumbs(['title'=>'Aluguéis', 'icon'=>'fa-taxi','route'=>route('rents.index'),'subtitle'=>'Gerenciamento de
Alugueis'])

@endbreadcrumbs
@endsection

@section('toolbar')
@toolbar
@if($st!=1)
<a class="btn btn-sm btn-success mr-1 mb-1" href="{{route('rents.create')}}">
    <i class="fa fa-plus-circle"></i>Novo
</a>
@endif

<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link"
    data-route="{{url('rents/{id}/edit')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-pencil"></i>Editar
</button>

<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link" target="_blank"
    data-route="{{url('rents/{id}/print')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-print"></i>Imprimir
</button>
@if($st==0)
<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="patch"
    data-route="{{url('rents/{id}/quitar')}}" onclick="dataTableSubmit(event)" 
    data-confirm="Deseja Realmente Quitar? " title="Colocar como Devolvido">
    <i class="fa fa-check-square-o"></i>Quitar
</button>
@endif

@if($st==1)
<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="patch"
    data-route="{{url('rents/{id}/desquitar')}}" onclick="dataTableSubmit(event)" 
    data-confirm="Deseja Realmente Desquitar? " title="Desfazer Devolução">
    <i class="fa fa-square-o"></i>Desquitar
</button>
@endif

<button class="btn btn-sm btn-outline-danger mr-1 mb-1" type="button" data-type="delete"
    data-route="{{route('rents_bath.destroy')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-trash"></i>Excluir
</button>

@endtoolbar
@endsection

@section('content')

<div class="tile tile-nomargin">
   
    <label class="text-primary">Alugueis</label>
    {!!Form::select('status', ['0' => 'Em Aberto', '1' => 'Quitado/Devolvido'], $st,
    ['id'=>'select-status', 'class'=>'','data-url'=>route('rents.index')]
    )!!}
</div>

@datatables
<thead>
    <tr>
        <th><input class="checkall" type="checkbox"></th>
        <th>Status</th>
        <th>Cliente</th>
        <th>Data Saída</th>
        <th>Data Retorno</th>
        <th>Observação</th>
        <th>ID</th>
    </tr>
</thead>

<tbody>
    @foreach($rents as $rent)
    <tr>

        <td></td>
        <td><a href="{{route('rents.edit', $rent->id)}}">{!!$rent->getNomeStatus()!!}</a></td>
        <td>{{$rent->cliente->nome}}</td>
        <td>{{$rent->data_saida}}</td>
        <td>{{$rent->data_retorno}}</td>
        <td>{{$rent->observacao}}</td>
        <td>{{$rent->id}}</td>
    </tr>
    @endforeach
</tbody>
@enddatatables
@endsection

@push('scripts')
<script>
    /**
     * First start on Table
     * **********************************
     */
$(document).ready(function() {
    Tabela.getInstance({colId:6}); //instanciando dataTable e informando a coluna do id
});
   //fim start Datatable//

 $("#select-status").change(function(e){
       window.location.href = this.dataset.url+'?st='+this.value;
});

</script>

@endpush