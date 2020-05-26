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
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Qtd</th>
                <th>Total</th>
                <th><i class="fa fa-edit"></i></th>
                <th><i class="fa fa-trash"></i></th>
            </tr>

        </thead>

        <tbody id="tbodyTableProduto">

        </tbody>
    </table>
</div>




<!-- Modal -->
<div class="modal fade" id="ModalFormProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalFormProduto" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalFormProduto">Produto</h5>
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
                                        <?php echo $produto->descricao ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="formProduto_qtd" class="col-form-label">Qtd:</label>
                            <input type="text" class="form-control" id="formProduto_qtd">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="formProduto_valor" class="col-form-label">Valor Aluguel:</label>
                            <input type="text" class="form-control" id="formProduto_valor_aluguel">
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
        function inicializeItems(){
            var itemsJson= $("#produtos_json").val() || '[]';
            var itemsObj= JSON.parse(itemsJson);
            items=itemsObj;
            updateTableProduto();
        }        
        
        
        function saveItem() {
            var id = $("#formProduto_id").val().trim();
            var produto_id = $("#formProduto_produto_id").val();
            var qtd = $("#formProduto_qtd").val();
            var valor_aluguel = $("#formProduto_valor_aluguel").val();
            var item = {produto_id: produto_id, qtd: qtd, valor_aluguel: valor_aluguel};
            if (id) {
                updateItem(item, id);
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
            $("#formProduto_valor_aluguel").val(item.valor_aluguel);
            $("#formProduto_id").val(index);
            console.log('item', item);
            $('#ModalFormProduto').modal('show')

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
                var product=getObjProduct(item.produto_id);
                return "<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td>" + product.descricao + "</td>" +
                        "<td>" + item.valor_aluguel + "</td>" +
                        "<td>" + item.qtd + "</td>" +
                        "<td>" + item.qtd + "</td>" +
                        '<td><a href="#" editProduct="' + i + '"> <i class="fa fa-edit"></i>  </a></td>' +
                        '<td><a href="#" deleteProduct="' + i + '"> <i class="fa fa-trash text-danger"></i>  </a></td>' +
                        "</tr>"
            });
            $("#tbodyTableProduto").html(tableItems);
            $("a[editProduct]").click(editProduct);
            $("a[deleteProduct]").click(deleteProduct);
            //console.log(tableItems);
        }

        function resetFormProduto() {
            $("#formProduto_id").val('');
            $("#formProduto_produto_id").val('');
            $("#formProduto_qtd").val('');
            $("#formProduto_valor_aluguel").val('');
        }

        return {
            addItem: addItem,
            deleteItem: deleteItem,
            updateItem: updateItem,
            getItems: getItems,
            updateTableProduto: updateTableProduto,
            saveItem: saveItem,
            resetFormProduto: resetFormProduto,
            inicializeItems:inicializeItems
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

    var obj = Produtos();
    obj.inicializeItems();
    $("#btn_save_item").click(function () {
        obj.saveItem();
        obj.resetFormProduto();
        obj.updateTableProduto();
        console.log(obj.getItems());
    });

    $('#ModalFormProduto').on('hidden.bs.modal', function (e) {
        obj.resetFormProduto();
    });

    $('#formProduto_produto_id').change(function (e) {
        var produto= getObjProduct(this.value);
        $("#formProduto_valor_aluguel").val(produto.valor_aluguel);
    });

</script>
@endpush



