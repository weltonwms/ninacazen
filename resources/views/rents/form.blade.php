<div class="form-row">
    <div class="col-md-4">
        {{ Form::bsSelect('cliente_id',$clientes,null,['label'=>"Cliente", 'placeholder' => '--Selecione--']) }}

    </div>
    <div class="col-md-2 col-sm-6 ">
        {{ Form::bsDate('data_saida',null,['label'=>"Data Saída"]) }}
    </div>
    <div class="col-md-2 col-sm-6">
        {{ Form::bsDate('data_retorno',null,['label'=>"Data Retorno"]) }}
    </div>
    <div class="col-md-4">
        {{ Form::bsText('observacao',null,['label'=>"Observação"]) }}
    </div>
</div>
{{ Form::hidden('produtos_json',null,['class'=>"form-control", 'id'=>'produtos_json']) }}
@error('produtos_json')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-success  pull-right" 
                data-toggle="modal"
                data-target="#ModalFormProduto"
                id="btn_add_item">
            <i class="fa fa-plus"></i>  Novo
        </button>

    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Valor Un</th>
                <th>Total</th>
                <th><i class="fa fa-edit"></i></th>
                <th><i class="fa fa-trash"></i></th>
            </tr>

        </thead>

        <tbody id="tbodyTableProduto">

        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="text-center table-primary"><b>Total Geral</b></td>
                <td class="table-primary"><span id="total_geral_tabela">0</span></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>




<!-- Modal -->
<div class="modal fade" id="ModalFormProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalFormProduto" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalFormProduto">Produto para Alugar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <input type="hidden" id="formProduto_id" value="">
                        <div class="form-group col-md-12">
                            <label for="formProduto_produto" class="col-form-label">Produto:</label>
                            <select class="form-control" id="formProduto_produto_id">
                                <option value="">--Selecione--</option>
                                <?php foreach ($produtos as $produto): ?>
                                    <option value="<?php echo $produto->id ?>" data-obj="<?php echo base64_encode(json_encode($produto)) ?>">
                                        <?php echo $produto->nome ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="formProduto_qtd" class="col-form-label">Qtd:</label>
                            <input type="number" min="0" class="form-control" id="formProduto_qtd">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="formProduto_valor" class="col-form-label">Valor Un. Aluguel:</label>
                            <input type="text"  class="form-control money" id="formProduto_valor_aluguel">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="formProduto_total" class="col-form-label">Total:</label>
                            <input type="text" class="form-control" id="formProduto_total" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn_save_item">Salvar</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>

    function Produtos() {
        var items = [];

        function addItem(item) {
            items.push(item);
        }

        function deleteItem(index) {
            items.splice(index, 1);
        }

        function updateItem(item, index) {
            items.splice(index, 1, item);
        }

        function getItems() {
            return items;
        }


        /*
         * Metodos de uma possivel outra classe. mexe com DOM
         */
        function inicializeItems() {
            var itemsJson = $("#produtos_json").val() || '[]';
            var itemsObj = JSON.parse(itemsJson);
            items = itemsObj;
            updateTableProduto();
        }
        
        function getTotalGeral(){
            var map= items.map(function(item, i){
                return parseFloat(getTotalItem(i));
            });
            var soma= map.reduce(function(a,b){
               return a + b;
            },0)
            return soma;
        }
        
        function getTotalItem(index) {
            var item = items[index];
            if (item) {
                var total = parseInt(item.qtd) * parseFloat(item.valor_aluguel);
                return total.toFixed(2);
            }
        }
       

        function saveItem() {
            var id = $("#formProduto_id").val().trim();
            var produto_id = $("#formProduto_produto_id").val();
            var qtd = $("#formProduto_qtd").val();
            var valor_aluguel = ler_valor("#formProduto_valor_aluguel");
            var item = {produto_id: produto_id, qtd: qtd, valor_aluguel: valor_aluguel};
            if (id) {
                updateItem(item, id);
                $('#ModalFormProduto').modal('hide');
            } else {
                addItem(item);
            }

        }

        function editProduct(event) {
            event.preventDefault();
            var index = $(this).attr('editProduct');
            var item = items[index];
            $("#formProduto_produto_id").val(item.produto_id);
            $("#formProduto_qtd").val(item.qtd);
            $("#formProduto_valor_aluguel").val(valorFormatado(item.valor_aluguel));
            $("#formProduto_id").val(index);

            $('#ModalFormProduto').modal('show');

        }

        function deleteProduct(event) {
            event.preventDefault();
            var index = $(this).attr('deleteProduct');
            deleteItem(index);
            updateTableProduto();
        }
        function updateTableProduto() {
            var itemsString = JSON.stringify(items);
            $("#produtos_json").val(itemsString);
            var tableItems = items.map(function (item, i) {
                var product = getObjProduct(item.produto_id);
                return "<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td>" + product.nome + "</td>" +
                        "<td>" + item.qtd + "</td>" +
                        "<td>" + valorFormatado(item.valor_aluguel) + "</td>" +
                        "<td>" + valorFormatado(getTotalItem(i)) + "</td>" +
                        '<td><a href="#" editProduct="' + i + '"> <i class="fa fa-edit"></i>  </a></td>' +
                        '<td><a href="#" deleteProduct="' + i + '"> <i class="fa fa-trash text-danger"></i>  </a></td>' +
                        "</tr>"
            });
            $("#tbodyTableProduto").html(tableItems);
            $("#total_geral_tabela").html(valorFormatado(getTotalGeral()));
            $("a[editProduct]").click(editProduct);
            $("a[deleteProduct]").click(deleteProduct);
            //console.log(tableItems);
        }

        function resetFormProduto() {
            $("#formProduto_id").val('');
            $("#formProduto_produto_id").val('');
            $("#formProduto_qtd").val('');
            $("#formProduto_valor_aluguel").val('');
            $("#formProduto_total").val('');
        }

        return {
            addItem: addItem,
            deleteItem: deleteItem,
            updateItem: updateItem,
            getItems: getItems,
            updateTableProduto: updateTableProduto,
            saveItem: saveItem,
            resetFormProduto: resetFormProduto,
            inicializeItems: inicializeItems,
            getTotalItem: getTotalItem,
            getTotalGeral:getTotalGeral
        };

    }

    function getObjProduct(id) {
        var option = $('#formProduto_produto_id option[value=' + id + ']');
        if (option.val()) {
            var produtoJson = atob(option.attr('data-obj'));
            var produto = JSON.parse(produtoJson);
            return produto;
        }
    }

    function calculoTotal() {
        var qtd = ler_valor("#formProduto_qtd");
        var valor_aluguel = ler_valor("#formProduto_valor_aluguel");
        console.log('qtd', qtd);
        console.log('valor_aluguel', valor_aluguel); 
        if (qtd && valor_aluguel) {
            var total = qtd * valor_aluguel;
            
            $("#formProduto_total").val(valorFormatado(total));

        } else {
            $("#formProduto_total").val('');
        }
    }
    
    function valorFormatado(valorNumber){
        var v= Number.parseFloat(valorNumber); //garantindo que param vai ser number
        var valor_formatado = v.toFixed(2).toString().replace('.', ',');
        return valor_formatado; //string formatada
    }
    
    function ler_valor(campo) {
        var valor = $(campo).val().replace('.', '').replace(',', '.');
        return parseFloat(valor);
    }

    function checkErrors(){
        var qtd= ler_valor("#formProduto_qtd");
        var valor_aluguel= ler_valor("#formProduto_valor_aluguel");
        var produto_id= $("#formProduto_produto_id").val();
        var errors=[];
        if(!produto_id){
            errors.push("Produto não Selecionado");
            return errors; // Não tem como prosseguir sem produto_id
        }
        var produto = getObjProduct(produto_id);
        if(!qtd || qtd < 1){
            errors.push("Quantidade Inválida");
        }
        if(!valor_aluguel){
            errors.push("Valor de Aluguel não Inserido");
        }
        
        if(qtd > produto.qtd_disponivel){
            errors.push("Qtd maior que Quantidade Disponível");
        }
        return errors;
    }
    
    

    var obj = Produtos();
    obj.inicializeItems();
    $("#btn_save_item").click(function () {
        var errors=checkErrors();
        if(errors.length===0){
            obj.saveItem();
            obj.resetFormProduto();
            obj.updateTableProduto();
            console.log(obj.getItems());
        }
        else{
            alert(errors.join('\n'));
        }
        
    });

    $('#ModalFormProduto').on('hidden.bs.modal', function (e) {
        obj.resetFormProduto();
    });

    $('#formProduto_produto_id').change(function (e) {
        var produto = getObjProduct(this.value);
        console.log(produto);
        $("#formProduto_valor_aluguel").val(valorFormatado(produto.valor_aluguel));
        calculoTotal();
    });

    $("#formProduto_qtd, #formProduto_valor_aluguel ").on("change", function () {
        calculoTotal();
    });

</script>
@endpush



