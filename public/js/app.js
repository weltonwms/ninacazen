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

var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
      }
  };

function adminFormSubmit(event) {
    var form = document.getElementById("adminForm");
    form.submit();
}

$(document).ready(function () {
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00', { reverse: true });
    $('.phone').mask(SPMaskBehavior, spOptions);
    $('.money').mask('000.000.000.000.000,00', {reverse: true});

});

