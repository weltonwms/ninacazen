{{-- Usando o componentede Form bsText: forma mais curta que component blade FormGroup --}}
{{ Form::bsText('descricao',null,['label'=>"Nome *"]) }}
{{ Form::bsText('valor_aluguel',null,['label'=>"Valor Aluguel *", 'class'=>"money"]) }}
{{ Form::bsNumber('qtd_estoque',null,['label'=>"Qtd Estoque *"]) }}
{{ Form::bsText('observacao',null,['label'=>"Observação"]) }}




      