'use strict';

let tableName = '#headerSlidersTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    bSort: false,
    ajax: {
        url: headerSliderUrl,
        data: function (data) {
            data.is_active = $('#headerFilterStatus').
                find('option:selected').
                val();
        },
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '100%',
        },
        {
            'targets': [1, 2],
            'className': 'text-center',
            'width': '10%',
        },
    ],
    columns: [
        {
            data: function (row) {
                return '<img src="' + row.header_slider_url +
                    '" class="rounded-circle thumbnail-rounded"' + '</img>';
            },
            name: 'id',
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
                return prepareTemplateRender('#headerSliderActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $('#headerFilterStatus').change(function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).ready(function () {
    $('#headerFilterStatus').select2();
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    if ($('#description').summernote('isEmpty')) {
        $('#description').val('');
    }
    $.ajax({
        url: headerSliderSaveUrl,
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#headerSlidersTbl').DataTable().ajax.reload(null, false);
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
    let headerSliderId = $(event.currentTarget).data('id');
    renderData(headerSliderId);
});

window.renderData = function (id) {
    $.ajax({
        url: headerSliderUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#headerSliderId').val(result.data.id);
                if (isEmpty(result.data.header_slider_url)) {
                    $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
                } else {
                    $('#editPreviewImage').
                        attr('src', result.data.header_slider_url);
                    $('#imageSliderUrl').
                        attr('href', result.data.header_slider_url);
                    $('#imageSliderUrl').text(view);
                }
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
    const id = $('#headerSliderId').val();
    $.ajax({
        url: headerSliderUrl + id + '/update',
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#headerSlidersTbl').DataTable().ajax.reload(null, false);
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

$(document).on('click', '.addHeaderSliderModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('click', '.delete-btn', function (event) {
    let headerSliderId = $(event.currentTarget).data('id');
    deleteItem(headerSliderUrl + headerSliderId, '#headerSlidersTbl',
        'Header Slider');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
});

window.displayImage = function (input, selector, validationMessageSelector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                if ((image.height < 1080 || image.width < 1920)) {
                    $('#imageSlider').val('');
                    $(validationMessageSelector).removeClass('d-none');
                    $(validationMessageSelector).
                        html(headerSizeMessage).
                        show();
                    return false;
                }
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
            html(headerSizeMessage).
            show();
        return false;
    }
    $(validationMessageSelector).hide();
    return true;
};

$(document).on('change', '#headerSlider', function () {
    $('#addModal #validationErrorsBox').addClass('d-none');
    if (isValidImage($(this), '#addModal #validationErrorsBox')) {
        displayImage(this, '#previewImage', '#addModal #validationErrorsBox');
    }
});

$(document).on('change', '#editHeaderSlider', function () {
    $('#editModal #validationErrorsBox').addClass('d-none');
    if (isValidFile($(this), '#editModal #validationErrorsBox')) {
        displayImage(this, '#editPreviewImage',
            '#editModal #validationErrorsBox');
    }
});

$(document).on('change', '.isActive', function (event) {
    let headerSliderId = $(event.currentTarget).data('id');
    changeIsActive(headerSliderId);
});

window.changeIsActive = function (id) {
    $.ajax({
        url: headerSliderUrl + id + '/change-is-active',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#headerSlidersTbl').DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$('.searchIsActive').on('change', function () {
    $.ajax({
        url: headerSliderUrl + 'change-search-disable',
        method: 'post',
        data: $('#searchIsActive').serialize(),
        dataType: 'JSON',
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#imageSlidersTbl').DataTable().ajax.reload(null, false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
