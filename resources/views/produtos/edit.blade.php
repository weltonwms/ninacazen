@extends('produtos.master-edit')

@section('edit-content')
<h5 class="text-center">Qtd Disponível: <span class="badge badge-primary qtd_disponivel">{{$produto->qtd_estoque}}</span></h5>
{!! Form::model($produto,['route'=>['produtos.update',$produto->id],'class'=>'','id'=>'adminForm','method'=>'PUT'])!!}
        @include('produtos.form')

       
{!! Form::close() !!}
@endsection

@push('scripts')
<script>
$('#qtd_estoque').change(function(){
        var v= this.value;
        $('.qtd_disponivel').text(v);
});

</script>

@endpush