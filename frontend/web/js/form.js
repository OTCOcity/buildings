$('body').on('submit', 'form.ajax-validate', function (e) {

    e.preventDefault();
    const form = $(this);
    const formData = new FormData($(this)[0]);

    // Before send function
    if (form.data('beforeSendCallback') && window[form.data('beforeSendCallback')] !== undefined) {
        var beforeSendResult = window[$(this).data('beforeSendCallback')](form);
        if (!beforeSendResult) {
            console.log('beforeSendCallback return false!');
            return false;
        }
    }

    form.addClass('loading');
    form.find('.help-block').html('');

    $.ajax({
        url: form.attr("action"),
        type: 'POST',
        data: formData,
        async: true,
        success: function (data) {

            form.removeClass('loading');

            requestDataCallback(data, form);


        },
        error: function (e) {
            
            console.log(e);
            
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


function requestDataCallback(data, funcAttr) {
    if (typeof data === 'object') { // Объект (переделать под более гибкую форму)

        if (window[data.function] !== undefined) {
            window[data.function](data.data, funcAttr);
        }

        if (data.error) {
            console.log(data.error);

        }

        // errors
        // console.log(funcAttr);
        $(funcAttr).find("[data-name]").removeClass('has-error');
        for (let prop in data) {
            $(funcAttr).find(`[data-name=${prop}]`).removeClass('has-success').addClass('has-error').find('.help-block').text(data[prop][0]);
        }


    } else if (window[data] !== undefined) {  // Запуск функции

        window[data](funcAttr);


    } else { // Вернулась также страница, поэтому извлекаем ошибки

        // Доделать обработку Flash в всплывающие подсказки

        console.log('Same page');

        const $data = $(data);
        setTimeout(function () { // Fix blink error message
            $data.find('.help-block').each(function () {
                var eHtml = $(this).html();
                if (eHtml.length) {
                    var $fg = $(this).closest('.form-group'),
                        $inp = $fg.find('[id]');
                    var $newFg = funcAttr.find('#' + $inp.attr('id')).closest('.form-group');
                    $newFg.addClass('has-error').find('.help-block').html(eHtml);
                }
            });
        }, 100);

    }
}


function feedbackSuccess(data) {
    if (data.scenario === 'feedback') {
        $('.js-fb-thanks').show();
        $('.js-fb-thanks').prev().hide();
    }

    if (data.scenario === 'vac') {
        const $fbiContent = $('.fbi__content');
        $('.fp-success__title-name').text(data.name)
        $fbiContent.find('form').remove();
        $fbiContent.find('.fp-success').addClass('is-active');
    }
}
