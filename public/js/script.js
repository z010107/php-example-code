$(document).ready(function () {

    $(".confirm-delete").click(function (e) {
        var info = $(this).data('info');
        if (confirm("Вы действительно хотите удалить: " + info)) {
            return true;
        }
        return false;
    });

    $(".form-phone").mask("+7 (999) 999-9999");

    $('.datepicker').datepicker({
        language: "ru",
        format: 'dd.mm.yyyy',
        todayHighlight: true
    });

    $(".only-chars").keydown(function (e) {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''));
    });

    $("body").on('click', 'form.ajax-form button[type="submit"]', function (e) {
        var form = $(this).closest('form'),
            action = form.prop('action'),
            data = form.serialize(),
            allow = true;

        $(form).parent().find('.alert').remove();

        $.each(form.find('.form-group.req input'), function(idx, item) {
            if ($(item).val().length == 0) {
                $(item).parent().parent().addClass('has-error');
                allow = false;
            } else {
                $(item).parent().parent().removeClass('has-error');
            }
        });

        if (allow) {
            $.ajax({
                method: "POST",
                url: action,
                data: data
            })
                .done(function (msg) {
                    if (msg.result) {
                        $('<div class="alert alert-success" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button>' +
                            (msg.message) + '</div>').insertBefore($(form));
                    } else {
                        $('<div class="alert alert-danger" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button>' +
                            (msg.message) + '</div>').insertBefore($(form));
                    }
                });
        }
        return false;
    });
});
