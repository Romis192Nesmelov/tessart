$(document).ready(function ($) {
    window.editPriceModal = $('#edit-table');

    $('a.img-preview').fancybox({padding: 3});

    // Phone mask
    $('input[name=prefix]').mask("999");
    $('input[name=phone]').mask("+7(999)999-99-99");
    $('input[name=main_phone]').mask("999-99-99");
    
    // Preview upload image
    $('input[type=file]').change(function () {
        var input = $(this)[0];
        var imagePreview = $(this).parents('.edit-image-preview').find('img');

        if (input.files[0].type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.attr('src', '/images/placeholder.jpg');
        }
    });

    // Click to delete items
    bindDeleteItem();

    // Click YES on delete modal
    $('.delete-yes').click(function () {
        $('#'+localStorage.getItem('delete_modal')).modal('hide');

        $.post('/admin/'+localStorage.getItem('delete_function'), {
            '_token': $('input[name=_token]').val(),
            'id': localStorage.getItem('delete_id'),
        }, function (data) {
            if (data.success) {
                var row = localStorage.getItem('delete_row');
                $('#'+row).remove();
            }
        });
    });
    
    // Click adding to table
    $('table.edit-table button').click(function (e) {
        e.preventDefault();
        var self = $(this);

        window.editId = null;
        window.parentId = self.parents('td').attr('parent-id');
        window.addField = self.parents('td').attr('add-field');
        window.editFubction = self.parents('a').attr('href');

        window.editPriceModal.modal('show');

        window.callBackFun = function (data) {
            var row = self.parents('tr');
            row.before(
                '<tr role="row" id="edit_table_item_'+data.id+'">' +
                    '<td class="id">'+data.id+'</td>' +
                    '<td class="text-center left">'+data.left+'</td>' +
                    '<td class="text-center right">'+data.right+'</td>' +
                    '<td class="edit"><span edit-data="'+data.id+'" edit-function="'+window.editFubction+'" class="icon-database-edit2"></span></td>' +
                    '<td class="text-center delete"><span del-data="'+data.id+'" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span></td>' +
                '</tr>');
            bindDeleteItem();
            bindEditTable();
            window.editPriceModal.find('input[name=left]').val('');
            window.editPriceModal.find('input[name=right]').val('');
            window.editPriceModal.modal('hide');
        };
    });

    // Click to edit table
    bindEditTable();

    // Click to edit table of percents
    $('table.edit-percent .edit > .icon-database-edit2, table.edit-percent button').click(function (e) {
        e.preventDefault();
        var row = $(this).parents('tr'),
            modal = $('#edit-percents');

        modal.find('input[name=id]').val(parseInt(row.attr('id').replace('percent_','')));
        modal.find('input[name=position]').val(parseInt(row.attr('position')));
        modal.find('input[name=sum]').val(parseInt(row.find('span.sum').html()));
        modal.find('input[name=percent]').val(row.find('span.percent').html());
        modal.modal('show');
    });

    // Click SAVE on edit-price modal
    $('.save-table').click(function () {
        $('.error').html('');
        $.post(window.editFubction, {
            '_token': $('input[name=_token]').val(),
            'id': window.editId,
            'parentId': window.parentId,
            'addField': window.addField,
            'left': window.editPriceModal.find('input[name=left]').val(),
            'right': window.editPriceModal.find('input[name=right]').val()
        })
        .done(function(data) {
            if (window.callBackFun) window.callBackFun(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            var responseMsg = jQuery.parseJSON(jqXHR.responseText);
            $.each(responseMsg.errors, function (field, error) {
                var errorMsg = error[0];
                $('.error.'+field).html(errorMsg);
            });
        });
    });

    // Display range input value
    $('input[type=range]').on('input', function () { bindRangeInputChange($(this)); });
    $('.range-input .value input').change(function () {
        var _self = $(this),
            inputRange = _self.parents('.range-input').find('input[type=range]'),
            addClass = inputRange.hasClass('with-add-unit') ? ' with-add-unit' : '';

        var parentInputRange = inputRange.parents('.slider');
        var attrsInputRange = {
            'class':'form-control pull-left'+addClass,
            'min':inputRange.attr('min'),
            'max':inputRange.attr('max'),
            'name':inputRange.attr('name'),
            'step':inputRange.attr('step'),
            'type':'range',
            'value':_self.val()
        };
        inputRange.remove();
        var newInput = $('<input>').attr(attrsInputRange).on('input', function () {
            bindRangeInputChange($(this));
        });
        parentInputRange.append(newInput);
    });
    
    // Add ya-maps
    if (window.maps && window.maps.length) {
        $.each(window.maps, function (k,coords) {
            addMap(coords, 'map-'+(k+1));
        });
    }
});

function deleteItem(obj) {
    var deleteModal = $('#'+obj.attr('modal-data'));

    localStorage.clear();
    localStorage.setItem('delete_id',obj.attr('del-data'));
    localStorage.setItem('delete_function',deleteModal.find('.modal-body').attr('del-function'));
    localStorage.setItem('delete_row', (obj.parents('tr').length ? obj.parents('tr').attr('id') : obj.parents('.col-lg-2').attr('id')));
    localStorage.setItem('delete_modal',obj.attr('modal-data'));

    deleteModal.modal('show');
}

function bindRangeInputChange(obj) {
    var valCell = obj.parents('.range-input').find('.value input');
    valCell.val(obj.val());
}

function bindDeleteItem() {
    $('.glyphicon-remove-circle').click(function () {
        deleteItem($(this));
    });
}

function bindEditTable() {
    $('table.edit-table .edit > .icon-database-edit2').click(function () {
        var row = $(this).parents('tr');

        window.editId = $(this).attr('edit-data');
        window.parentId = null;
        window.addField = null;
        window.editFubction = $(this).attr('edit-function');

        window.editPriceModal.find('input[name=left]').val(row.find('td.left').html());
        window.editPriceModal.find('input[name=right]').val(row.find('td.right').html());
        window.editPriceModal.modal('show');

        window.callBackFun = function (data) {
            row.find('td.left').html(data.left);
            row.find('td.right').html(data.right);
            window.editPriceModal.modal('hide');
        };
    });
}

function addMap(coords, container) {
    ymaps.ready(function () {
        var myMap = new ymaps.Map(container, {
            center: coords,
            zoom: 12,
            controls: ['zoomControl', 'fullscreenControl']
        });

        myMap.behaviors.disable('scrollZoom');
        var mark = new ymaps.Placemark(
            coords,
            {iconContent: 'Ломбард «Т.чка»'},
            {preset: 'islands#redStretchyIcon'}
        );
        myMap.geoObjects.add(mark);
    });
}