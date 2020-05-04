@extends('layouts.app')
@section('breadcrumb')
@breadcrumbs(['title'=>'Usuários', 'icon'=>'fa-user-secret','route'=>route('users.index'),'subtitle'=>'Gerenciamento de Usuários'])

@endbreadcrumbs
@endsection

@section('toolbar')
@toolbar
<a class="btn btn-sm btn-success mr-1 mb-1" onclick="adminFormSubmit(event)" > <i class="fa fa-save"></i>Salvar</a>
<a class="btn btn-sm btn-outline-secondary mr-1 mb-1"  href="{{route('users.index')}}" > <i class="fa fa-close"></i>Cancelar</a>

@endtoolbar
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">


           @yield('edit-content')


        </div>
    </div>

</div>





@endsection
