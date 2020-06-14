@extends('rents.master-edit')

@section('edit-content')

{!! Form::model($rent,['route'=>['rents.update',$rent->id],'class'=>'','id'=>'adminForm','method'=>'PUT'])!!}
@if($rent->devolvido==1)
<h3 class="text-primary text-center">
        <i class="fa fa-check"></i> Aluguel Quitado
</h3>
@endif
@include('rents.form')


{!! Form::close() !!}
@endsection