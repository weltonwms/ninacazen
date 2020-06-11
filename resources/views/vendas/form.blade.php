<div class="form-row">
    <div class="col-md-4">
        {{ Form::bsSelect('cliente_id',$clientes,null,['label'=>"Cliente *", 'placeholder' => '--Selecione--']) }}

    </div>
    <div class="col-md-4 ">
        {{ Form::bsDate('data_venda',null,['label'=>"Data Venda *"]) }}
    </div>
   
    <div class="col-md-4">
        {{ Form::bsText('observacao',null,['label'=>"Observação"]) }}
    </div>
</div>
{{ Form::hidden('produtos_json',null,['class'=>"form-control", 'id'=>'produtos_json']) }}
@error('produtos_json')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@include('vendas.produto-venda')



