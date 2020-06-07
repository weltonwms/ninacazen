function confirmDelete(callback) {
    swal({
        title: 'Deseja Realmente Excluir?',
        type: "warning",
        showCancelButton: true
    }, function (ok) {
        if (ok) {
            callback();
        }
    });
}

function confirm(callback, title="Deseja Realmente  ?", content="") {
    swal({
        title: title,
        type: "warning",
        showCancelButton: true,
        text:content,
    }, function (ok) {
        if (ok) {
            callback();
        }
    });
}


var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
      }
  };

function adminFormSubmit(event) {
    event.preventDefault();
    var btn= event.target;
    var form = document.getElementById("adminForm");
    form.submit();
    $(btn).attr('disabled','disabled');
    $(btn).removeAttr('onclick');
    $(btn).unbind();
}

$(document).ready(function () {
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00', { reverse: true });
    $('.phone').mask(SPMaskBehavior, spOptions);
    $('.money').mask('000.000.000.000.000,00', {reverse: true});

    //função busca CEP em Webservice
    $("#cep").keyup(function () {
        if (this.value.length == 9) {
            $('#cep').css({'background': "url('../img/preload.GIF') no-repeat right", 'background-size': '30px 30px'});
            $('body').append("<div class='fundo_preload  modal-backdrop fade show'></div>");
            $.getJSON("//viacep.com.br/ws/" + this.value + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    var string_endereco= dados.logradouro+' '+dados.complemento+' ';
                    string_endereco+=dados.bairro+' '+dados.localidade+' - '+dados.uf+' '+dados.unidade;
                    $("#endereco").val(string_endereco);
                } else {

                    alert("CEP não encontrado.");
                }
            }).done(function () {
                $('#cep').css('background', "url()");
                $('.fundo_preload').remove();
            }).fail(function () {
               $('#cep').css('background', "url()");
               $('.fundo_preload').remove();
                console.log('falha de rede ou erro lançado pelo webservice');
                
            });
        }
    }); //fim  KEYUP função busca CEP
    //FIM BUSCA CEP

});

