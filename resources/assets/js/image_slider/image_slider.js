'use strict';

    let tableName = '#imageSlidersTbl';
    $(tableName).DataTable({
        processing: true,
        serverSide: true,
        'order': [[1, 'asc']],
        ajax: {
            url: imageSliderUrl,
            data: function (data) {
                data.is_active = $('#image_filter_status').
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
                'className': 'text-center description',
            },
            {
                'targets': [2],
                'orderable': false,
                'className': 'text-center',
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
                    return '<img src="' + row.image_slider_url +
                        '" class="rounded-circle thumbnail-rounded"' + '</img>';
                },
                name: 'id',
            },
            {
                data: function (row) {
                    if (!isEmpty(row.description)) {
                        let element = document.createElement('textarea');
                        element.innerHTML = row.description;
                        return element.value.length > 80 ? element.value.substr(
                            0, 80) + '...' : element.value;
                    } else
                        return 'N/A';
                },
                name: 'description',
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
                    return prepareTemplateRender('#imageSliderActionTemplate',
                        data);
                }, name: 'id',
            },
        ],
        'fnInitComplete': function () {
            $('#image_filter_status').change(function () {
                $(tableName).DataTable().ajax.reload(null, true);
            });
        },
    });

$(document).ready(function () {
    $('#image_filter_status').select2();
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    if (!checkSummerNoteEmpty('#description',
        'Description field is required.')) {
        return true;
    }
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: imageSliderSaveUrl,
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                    $('#addModal').modal('hide');
                    $('#imageSlidersTbl').DataTable().ajax.reload(null, false);
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
        let imageSliderId = $(event.currentTarget).data('id');
        renderData(imageSliderId);
    });

    window.renderData = function (id) {
        $.ajax({
            url: imageSliderUrl + id + '/edit',
            type: 'GET',
            success: function (result) {
                if (result.success) {
                    $('#imageSliderId').val(result.data.id);
                    if (isEmpty(result.data.image_slider_url)) {
                        $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
                    } else {
                        $('#editPreviewImage').
                            attr('src', result.data.image_slider_url);
                        $('#imageSliderUrl').
                            attr('href', result.data.image_slider_url);
                        $('#imageSliderUrl').text(view);
                    }
                    $('#editDescription').summernote('code', result.data.description);
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
        if (!checkSummerNoteEmpty('#editDescription',
            'Description field is required.')) {
            return true;
        }
        processingBtn('#editForm', '#btnEditSave', 'loading');
        const id = $('#imageSliderId').val();
        $.ajax({
            url: imageSliderUrl + id + '/update',
            type: 'POST',
            data: new FormData($(this)[0]),
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#editModal').modal('hide');
                    $('#imageSlidersTbl').DataTable().ajax.reload(null, false);
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

    $(document).on('click', '.addImageSliderModal', function () {
        $('#addModal').appendTo('body').modal('show');
    });

    $(document).on('click', '.delete-btn', function (event) {
        let imageSliderId = $(event.currentTarget).data('id');
        deleteItem(imageSliderUrl + imageSliderId, '#imageSlidersTbl',
            'Image Slider');
    });

    $('#addModal').on('hidden.bs.modal', function () {
        resetModalForm('#addNewForm', '#validationErrorsBox');
        $('#description').summernote('code', '');
        $('#previewImage').attr('src', defaultDocumentImageUrl);
    });

$('#description, #editDescription').summernote({
    minHeight: 200,
    height: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]],
});

window.displayImage = function (input, selector, validationMessageSelector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                if ((image.height < 500 || image.width < 1140)) {
                    $('#imageSlider').val('');
                    $(validationMessageSelector).removeClass('d-none');
                    $(validationMessageSelector).
                        html(imageSizeMessage).
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
            html(imageExtensionMessage).
            show();
        return false;
    }
    $(validationMessageSelector).hide();
    return true;
};

$(document).on('change', '#imageSlider', function () {
    $('#addModal #validationErrorsBox').addClass('d-none');
    if (isValidImage($(this), '#addModal #validationErrorsBox')) {
        displayImage(this, '#previewImage', '#addModal #validationErrorsBox');
    }
});

$(document).on('change', '#editImageSlider', function () {
    $('#editModal #validationErrorsBox').addClass('d-none');
    if (isValidFile($(this), '#editModal #validationErrorsBox')) {
        displayImage(this, '#editPreviewImage',
            '#editModal #validationErrorsBox');
    }
});

$(document).on('change', '.isActive', function (event) {
    let imageSliderId = $(event.currentTarget).data('id');
    changeIsActive(imageSliderId);
});

window.changeIsActive = function (id) {
    $.ajax({
        url: imageSliderUrl + id + '/change-is-active',
        method: 'post',
        cache: false,
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
};

$('.isFullSlider').on('change', function () {
    $.ajax({
        url: imageSliderUrl + 'change-full-slider',
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

$('.isSliderActive').on('change', function () {
    $.ajax({
        url: imageSliderUrl + 'change-slider-active',
        method: 'post',
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
