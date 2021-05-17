'use strict';

let tableName = '#brandingSlidersTbl';
let tbl = $('#brandingSlidersTbl').DataTable({
    processing: true,
    serverSide: true,
    'order': [1, 'asc'],
    ajax: {
        url: brandingSliderUrl,
        data: function (data) {
            data.is_active = $('#branding_filter_status').
                find('option:selected').
                val();
        },
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '10%',
            'orderable': false,
            'className': 'text-center',
        },
        {
            'targets': [1],
            'orderable': true,
            'className': 'text-center',
        },
        {
            'targets': [2],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
    ],
    columns: [
        {
            data: function (row) {
                return '<img src="' + row.branding_slider_url +
                    '" class="rounded-circle thumbnail-rounded"' + '</img>';
            },
            name: 'id',
        },
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.title;
                return element.value;
            },
            name: 'title',
        },
        {
            data: function (row) {
                let checked = row.is_active === 0 ? '' : 'checked';
                let data = [{ 'id': row.id, 'checked': checked }];
                return prepareTemplateRender('#isActive', data);
            },
            name: 'is_active',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#brandingSliderActionTemplate',
                    data);
            },
            name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $('#branding_filter_status').change(function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).ready(function () {
    $('#branding_filter_status').select2();
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: brandingSliderSaveUrl,
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addNewForm', '#btnSave');
        },
    });
});

$(document).on('click', '.edit-btn', function (event) {
    let brandingSliderId = $(event.currentTarget).data('id');
    renderData(brandingSliderId);
});

window.renderData = function (id) {
    $.ajax({
        url: brandingSliderUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.title;
                $('#brandingSliderId').val(result.data.id);
                if (isEmpty(result.data.branding_slider_url)) {
                    $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
                } else {
                    $('#editPreviewImage').
                        attr('src', result.data.branding_slider_url);
                    $('#brandingSliderUrl').
                        attr('href', result.data.branding_slider_url);
                    $('#brandingSliderUrl').text(view);
                }
                $('#editTitle').val(element.value);
                $('#editModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$(document).on('submit', '#editForm', function (event) {
    event.preventDefault();
    processingBtn('#editForm', '#btnEditSave', 'loading');
    const id = $('#brandingSliderId').val();
    $.ajax({
        url: brandingSliderUrl + '/' + id + '/update',
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#editForm', '#btnEditSave');
        },
    });
});

$(document).on('click', '.addBrandingSliderModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('click', '.delete-btn', function (event) {
    let brandingSliderId = $(event.currentTarget).data('id');
    deleteItem(brandingSliderUrl + '/' + brandingSliderId, tableName,
        'Brand');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
    $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
});

window.displayImage = function (input, selector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                $(selector).attr('src', e.target.result);
                displayPreview = true;
            };
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
            $(selector).show();
        }
    }
};

window.isValidImage = function (inputSelector, validationMessageSelector) {
    let ext = $(inputSelector).val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        $(inputSelector).val('');
        $(validationMessageSelector).removeClass('d-none');
        $(validationMessageSelector).
            html(brandingExtensionMessage).
            show();
        return false;
    }
    $(validationMessageSelector).hide();
    return true;
};

$(document).on('change', '#brandingSlider', function () {
    $('#addModal #validationErrorsBox').addClass('d-none');
    if (isValidImage($(this), '#addModal #validationErrorsBox')) {
        displayImage(this, '#previewImage', '#addModal #validationErrorsBox');
    }
});

$(document).on('change', '#editBrandingSlider', function () {
    $('#editModal #editValidationErrorsBox').addClass('d-none');
    if (isValidFile($(this), '#editModal #editValidationErrorsBox')) {
        displayImage(this, '#editPreviewImage',
            '#editModal #editValidationErrorsBox');
    }
});

$(document).on('change', '.isActive', function (event) {
    let brandingSliderId = $(event.currentTarget).data('id');
    changeIsActive(brandingSliderId);
});

window.changeIsActive = function (id) {
    $.ajax({
        url: brandingSliderUrl + '/' + id + '/change-is-active',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};
