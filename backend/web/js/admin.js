$(document).ready(function () {

    var $body = $('body');

    /* Navigation active */
    var moduleHref = '/admin/' + window.location.pathname.split('/')[2];
    $moduleLink = $("a[href='" + moduleHref + "']");
    $moduleLink.closest('li').addClass('active open');
    $moduleLink.parent().parent().parent().addClass('open');


    /* Link generate */
    $body.on('focus', '[data-transliterate-target]', function () {
        $target = $($(this).data('transliterate-target'));
        if ($.trim($(this).val()) == '') {
            $(this).val(strtolink($target.val()));
        }
    });


    // Data tables
    var $dataTable = $('.data-table');

    if ($dataTable.length) {
        var dtInfo = $dataTable.DataTable({"pageLength": 50});
        var dtColumnLength = $dataTable.find('th').length;
        var dtLength = $('.data-table tbody tr').length;
    }

    $('.data-table tbody').on('click', '.block-sort', function (e) {
        e.preventDefault();

        $table = $(this).closest('.data-table');

        var dtInfo = $table.DataTable();
        var dtLength = $table.find('tbody tr').length;


        var tr = $(this).closest('tr').get(0);
        var $tr = $(this).closest('tr');

        var trIndex = dtInfo.row(tr).index();


        if ($(this).hasClass('block-sort-up')) {
            var trIndexSwap = trIndex - 1;
            var $trSwap = $tr.prev();
        } else {
            var trIndexSwap = trIndex + 1;
            var $trSwap = $tr.next();
        }

        var TrClassTmp = $trSwap.attr('class');
        $trSwap.attr('class', $tr.attr('class'));
        $tr.attr('class', TrClassTmp);


        if (trIndexSwap >= 0 && trIndexSwap < dtLength) {
            swapDataTableRows(dtInfo, trIndex, trIndexSwap);
        }

        return false;
    });

    // Свои табы
    var $adminTabs = $('#admin-tabs');
    if ($adminTabs.length) {

        $adminTabs.on('click', '[data-toggle = tab]', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $adminTabs.find('.tab-pane').removeClass('active in');
            $adminTabs.find($(this).attr('href')).addClass('active in');
            $adminTabs.find('.nav-tabs li').removeClass('active');
            $(this).parent().addClass('active');


            // Меняем action формы чтобы после сохранения попадать на ту же вкладку
            $('form[action="' + window.location.pathname + '"]').attr('action', window.location.pathname + window.location.hash)
            $('form[action^="' + window.location.pathname + '#"]').attr('action', window.location.pathname + window.location.hash)

        });
    }

    // Активация таба, если нет активных
    var $tabs = $('#admin-tabs ul.nav-tabs > li'),
        $activeTabs = $tabs.filter('.active');
    if (!$activeTabs.length) {
        $tabs.eq(0).find('a').trigger('click');
    }


    // Hash click
    var hash = window.location.hash;
    if (hash) {
        var $target = $('[href="' + hash + '"]');
        if ($target.length) {
            $target.trigger('click');
        }
    }


    // Удаление изображения
    $body.on('click', '.admin-delete-image', function () {
        $(this).closest('.admin-image_item').remove();
    });


    // Открытие / закртытие подменю
    var navOpen = $.cookie('navOpen') ? JSON.parse($.cookie('navOpen')) : {};
    $body.on('click', '.subnav-toggle', function (e) {

        e.preventDefault();

        var $subanv = $(this).closest('a').next();

        $subanv.stop(true, true);

        if (!$subanv.is(":visible")) {

            navOpen[$(this).data('id')] = true;
        } else {

            delete navOpen[$(this).data('id')];
        }
        $.cookie('navOpen', JSON.stringify(navOpen), {expires: 7, path: '/'});

        $subanv.slideToggle(200);

        return false;

    });

    // Multiselect block list toggle
    $body.on('click', '.block-list__multiselect-item', function () {
        $(this).toggleClass('no-active');

        var toggleType = 1 - $(this).hasClass('no-active');
        $.post('/admin/blocks/block-multi-select-toggle-value', {
            table: $(this).data('table'),
            key: $(this).data('key'),
            item_id: $(this).data('item-id'),
            value: $(this).data('value'),
            toggle: toggleType
        }, function (data) {
            console.log(data);
        });


    });


    // Image Cropper
    var cropResultX, cropResultY, cropResultW, cropResultH, cropResultId;
    var cropper; // Cropper object

    $('#crop-submit-btn').click(function () {
        $('#crop-image-modal').modal('hide');
        $.post("/admin/upload/cropimage", {
            x: cropResultX,
            y: cropResultY,
            w: cropResultW,
            h: cropResultH,
            id: cropResultId
        }, function (data) {
            var json = JSON.parse(data),
                newName = json.newName,
                oldName = json.oldName;
            $('.admin-image_item-img').each(function () {

                var $cont = $(this).parent().parent();
                $cont.html($cont.html().split(oldName).join(newName));

            });
        });
    });


    $body.on('click', '.admin-crop-image', function () {

        var $cropImg = $('#admin-crop-image-example'),
            imageSrc = $(this).data('src'),
            cropX = $(this).data('crop-x') || 16,
            cropY = $(this).data('crop-y') || 9;

        cropResultId = $(this).data('id');

        console.log(imageSrc);
        if ($cropImg.length) {
            $cropImg.unbind('load');
            $cropImg.attr('src', '');

            $cropImg.on('load', function () {

                var imgH = this.height,
                    imgW = this.width,
                    initialWidth = 568,
                    initialHeigh = initialWidth * imgH / imgW;

                // console.log(initialWidth, initialHeigh);

                var image = document.getElementById('admin-crop-image-example');
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: cropX / cropY,
                    minContainerHeight: initialHeigh,
                    minContainerWidth: initialWidth,
                    checkCrossOrigin: false,
                    zoomable: false,
                    crop: function (event) {
                        // console.log('crop event!');
                        cropResultX = event.detail.x;
                        cropResultY = event.detail.y;
                        cropResultW = event.detail.width;
                        cropResultH = event.detail.height;
                        // console.log(event.detail.x);
                        // console.log(event.detail.y);
                        // console.log(event.detail.width);
                        // console.log(event.detail.height);
                        // console.log(event.detail.rotate);
                        // console.log(event.detail.scaleX);
                        // console.log(event.detail.scaleY);
                        // console.log('---------');
                    }
                });

            });
            $cropImg.attr('src', imageSrc);
        }


    });


    // Add hash to lang items
    $(window).on('hashchange', addHashToLangItems);
    addHashToLangItems();


    // Translate controls
    var $translateEditModal = $('#add-translate-modal');
    $body.on('click', '#translate-delete-confirm-btn', function () {

        $('#confirm-translate-modal').modal('hide');

        $.get('/admin/translate/delete/' + $(this).data('id'), function (data) {
            if (data.id) {
                var table = $('#translate-table').DataTable();
                table
                    .row($('.translate-block-delete--' + data.id).closest('tr'))
                    .remove()
                    .draw();
            }
        });

    });

    $body.on('click', '.translate-block-delete', function (e) {
        e.preventDefault();
        $('#translate-delete-confirm-btn').data('id', $(this).data('id'));
        $('#confirm-translate-modal').modal({backdrop: 'static', keyboard: false});
    });

    $body.on('click', '.translate-block-edit', function (e) {

        var id = $(this).data('id') || 0;

        e.preventDefault();
        $translateEditModal.find('.modal-body').html('<i class="fa fa-spinner text-primary rotating"></i>');
        $translateEditModal.modal({backdrop: 'static', keyboard: false});
        $.get('/admin/translate/edit/' + id, function (data) {
            $translateEditModal.find('.modal-body').html(data);
        });
    });

    // Submit translate form
    $body.on('click', '.translate-edit-form-submit', function () {
        $('#translate-edit-form').submit();
    });

    $body.on('submit', '#translate-edit-form', function (e) {

        e.preventDefault();
        $('#add-translate-modal').modal('hide');

        var $translateEditForm = $('#translate-edit-form');

        var formData = new FormData($translateEditForm[0]);

        $.ajax({
            url: $translateEditForm.attr("action"),
            type: 'POST',
            data: formData,
            async: true,
            success: function (data) {

                if (data.error) {
                    alert(data.message);
                }

                console.log(data);

                var table = $('#translate-table').DataTable();
                if (data.isNewRecord) {
                    console.log('add data');
                    table
                        .row
                        .add(data.data)
                        .draw();
                } else {
                    table
                        .row($('.translate-block-delete--' + data.id).closest('tr'))
                        .data(data.data)
                        .draw();
                }

            },
            error: function (e) {
            },
            cache: false,
            contentType: false,
            processData: false
        });    });


});


function addHashToLangItems() {
    var hash = window.location.hash || '';
    $('.lang__item').each(function () {
        var hrefArr = $(this).attr('href').split('#');
        $(this).attr('href', hrefArr[0] + hash);
    });

}

strtolink = (function () {
    var rus = "а б в г д е ё ж з и й к л м н о п р с т у ф х ц ч ш щ ы э ю я".split(/ +/g),
        eng = "a b v g d e e zh z i y k l m n o p r s t u f h c ch sh sh i e u ya".split(/ +/g);

    return function (text) {

        text = text.toLowerCase();

        for (var x = 0; x < rus.length; x++) {
            text = text.split(rus[x]).join(eng[x]);
        }
        text = text.replace(/[ъь]+/gi, '');
        text = text.replace(/[\W]+/gi, '-');
        text = text.replace(/[-]+$/gi, '');
        text = text.replace(/^[-]+/gi, '');

        return text;
    }
})();


function swapDataTableRows(dtInfo, row1Index, row2Index) {

    var datatable = dtInfo;
    //var rows = datatable.rows().data();
    var row1Data = datatable.row(row1Index).data();
    var row2Data = datatable.row(row2Index).data();

    console.log();

    datatable.row(row1Index).data(row2Data);
    datatable.row(row2Index).data(row1Data);
    //datatable.drow();
}


