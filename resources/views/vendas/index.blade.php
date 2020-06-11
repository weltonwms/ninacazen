@extends('layouts.app')

@section('breadcrumb')
@breadcrumbs(['title'=>'Vendas', 'icon'=>'fa-cart-plus','route'=>route('vendas.index'),'subtitle'=>'Gerenciamento de
Vendas'])

@endbreadcrumbs
@endsection

@section('toolbar')
@toolbar
<a class="btn btn-sm btn-success mr-1 mb-1" href="{{route('vendas.create')}}">
    <i class="fa fa-plus-circle"></i>Novo
</a>

<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link"
    data-route="{{url('vendas/{id}/edit')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-pencil"></i>Editar
</button>

<button class="btn btn-sm btn-outline-secondary mr-1 mb-1" type="button" data-type="link" target="_blank"
    data-route="{{url('vendas/{id}/print')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-print"></i>Imprimir
</button>


<button class="btn btn-sm btn-outline-danger mr-1 mb-1" type="button" data-type="delete"
    data-route="{{route('vendas_bath.destroy')}}" onclick="dataTableSubmit(event)">
    <i class="fa fa-trash"></i>Excluir
</button>

@endtoolbar
@endsection

@section('content')



@datatables
<thead>
    <tr>
        <th><input class="checkall" type="checkbox"></th>
        <th>ID</th>
        <th>Cliente</th>
        <th>Data Venda</th>
        
        <th>Observação</th>
        <th>ID</th>
    </tr>
</thead>

<tbody>
    @foreach($vendas as $venda)
    <tr>

        <td></td>
        <td><a href="{{route('vendas.edit', $venda->id)}}">{{$venda->id}}</a></td>
        <td>{{$venda->cliente->nome}}</td>
        <td>{{$venda->data_venda}}</td>
       
        <td>{{$venda->observacao}}</td>
        <td>{{$venda->id}}</td>
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
    Tabela.getInstance({colId:5}); //instanciando dataTable e informando a coluna do id
});
   //fim start Datatable//

 

</script>

@endpush