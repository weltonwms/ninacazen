@extends('vendas.master-edit')

@section('edit-content')

{!! Form::model($venda,['route'=>['vendas.update',$venda->id],'class'=>'','id'=>'adminForm','method'=>'PUT'])!!}
        @include('vendas.form')

       
{!! Form::close() !!}
@endsection



