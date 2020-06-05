@extends('layouts.app')

@section('breadcrumb')
    @breadcrumbs(['title'=>'Aluguéis', 'icon'=>'fa-taxi','route'=>route('rents.index'),'subtitle'=>'Gerenciamento de Alugueis'])

    @endbreadcrumbs
@endsection

@section('toolbar')
@toolbar
<a  class="btn btn-sm btn-success mr-1 mb-1" href="{{route('rents.create')}}" > <i class="fa fa-plus-circle"></i>Novo</a>
<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link" data-route="{{url('rents/{id}/edit')}}" onclick="dataTableSubmit(event)"> <i class="fa fa-pencil"></i>Editar</button>
<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link" target="_blank" data-route="{{url('rents/{id}/print')}}" onclick="dataTableSubmit(event)"> <i class="fa fa-print"></i>Imprimir</button>
<button class="btn btn-sm btn-outline-danger mr-1 mb-1" type="button" data-type="delete" data-route="{{route('rents_bath.destroy')}}" onclick="dataTableSubmit(event)"> <i class="fa fa-trash"></i>Excluir</button>
@endtoolbar
@endsection

@section('content')
    @datatables
<thead>
    <tr>
        <th><input class="checkall" type="checkbox"></th>
        <th>ID</th>
        <th>Cliente</th>
        <th>Data Saída</th>
        <th>Data Retorno</th>
        <th>Observação</th>
        <th>Devolvido</th>
        <th>ID</th>
    </tr>
</thead>

<tbody>
   @foreach($rents as $rent)
    <tr>
       
        <td></td>
        <td><a href="{{route('rents.edit', $rent->id)}}">{{$rent->id}}</a></td>
        <td>{{$rent->cliente->nome}}</td>
        <td>{{$rent->data_saida}}</td>
        <td>{{$rent->data_retorno}}</td>
        <td>{{$rent->observacao}}</td>
        <td>{{$rent->devolvido}}</td>
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
    Tabela.getInstance({colId:7}); //instanciando dataTable e informando a coluna do id
});
   //fim start Datatable//
</script>

@endpush