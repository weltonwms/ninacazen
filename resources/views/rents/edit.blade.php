@extends('rents.master-edit')

@section('edit-content')

{!! Form::model($rent,['route'=>['rents.update',$rent->id],'class'=>'','id'=>'adminForm','method'=>'PUT'])!!}
        @include('rents.form')

       
{!! Form::close() !!}
@endsection



