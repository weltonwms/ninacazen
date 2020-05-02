var languageDatatable = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "<span class='text-danger'>(Filtrados de _MAX_ registros)</span>",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "<i class='fa fa-search' aria-hidden='true'></i> Pesquisar",
    "oPaginate": {
        "sNext": "<i class='fa fa-forward' aria-hidden='true'></i>",
        "sPrevious": "<i class='fa fa-backward' aria-hidden='true'></i>",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "decimal": ",",
    "thousands": ".",
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    },
    "select": {
        "rows": {
            "_": "Selecionado %d linhas",
            "0": "Nenhuma linha selecionada",
            "1": "Selecionado 1 linha"
        }
    }
};

var Tabela = (function () {
    var instance;
    var colId;

    function createInstance(params) {
        if (params && params.colId)
        {
            //console.log('vou setar o colId');
            colId = params.colId;
        }

        var config= {
            language: languageDatatable,
            "bStateSave": true,
            select: {
                style: 'multi',
                selector: '.select-checkbox',
                items: 'row',
            },
            responsive: {
                details: {
                    type: 'column',
                    target: 0
                }
            },
            columnDefs: [{
                targets: 0,
                className: 'control'
            },
            {
                targets: 1,
                className: 'select-checkbox'
            },
            {
                targets: [0, 1],
                orderable: false
            }
            ],
            order: [2, 'asc']

        }; //fim configuração 1
        var config2= {
            language: languageDatatable,
            "bStateSave": true,
            select: {
                style: 'multi',
                selector: '.select-checkbox',
                items: 'row',
            },
            columnDefs: [
            {
                targets: 0,
                className: 'select-checkbox',
                orderable: false
            }
            ],
            order: [colId, 'desc']

        };
        var xConfig= (params && params.responsive===true)?config:config2;
        var table = $('#dataTable1').DataTable(xConfig);
        return table;
    }

    return {
        getInstance: function (params) {
            if (!instance)
            {
                instance = createInstance(params);
            }
            return instance;
        },
        getSelectedTable: function () {
            console.log('colId ', colId);
            if (!instance)
            {
                console.log('nenhuma instância criada ainda');
                return false;
            }
            var targetId = colId || 2; //default id is second column
            var dt = instance.rows({ selected: true }).data();
            var ids = [];
            dt.each(function (el) {
                ids.push(el[targetId]);
            });
            return ids;

        }
    };
})();


/**
 * *********************************
 * Functions for toolbar actions in datatables
 * **********************************
 */


function dataTableSubmit(event) {
    var dados = event.target.dataset;
    var ids = Tabela.getSelectedTable();
    var route = dados.route;
    if (ids.length === 0)
    {
        alert('nenhum item selecionado!');
        return false;
    }


    if (!route)
    {
        console.log('route undefined');
    }
    if (ids[0] && route)
    {
        route = route.replace('{id}', ids[0]);
    }


    if (dados.type === 'link')
    {
        window.location.href = route;
        return true;
    }

    if (dados.type === "delete")
    {
        confirmDelete(function () {
            $("#adminForm").attr('METHOD', 'POST');
            $("#adminForm").attr('action', dados.route);
            $("#adminForm").append("<input type='hidden' name='_method' value='DELETE'>\n");
            ids.forEach(function (id) {
                $("#adminForm").append("<input type='hidden' name='ids[]' value='" + id +
                    "'>\n");
            });
            $("#adminForm").submit();

        });
        return true;
    }



}

$(".checkall").change(function(){
    var t= Tabela.getInstance();
    if(!t){
        console.log('nenhuma instância de DataTable');
        return false;
    }
    var check= $(this).is(":checked");
    if(check){
        t.rows({page:'current'}).select();
    }
    else{
        t.rows({page:'current'}).deselect();
    }
});

