$(document).ready(function () {
    'use strict';

    let tableName = '#testimonialTbl';
    $(tableName).DataTable({
        scrollX: false,
        deferRender: true,
        scroller: true,
        processing: true,
        serverSide: true,
        'order': [[1, 'asc']],
        ajax: {
            url: testimonialUrl,
        },
        columnDefs: [
            {
                'targets': [0],
                'width': '8%',
                'orderable': false,
                'className': 'text-center',
            },
            {
                'targets': [2],
                'width': '8%',
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
                    return '<img src="' + row.customer_image_url +
                        '" class="rounded-circle thumbnail-rounded"' + '</img>';

                },
                name: 'customer_name',
            },
            {
                data: function (row) {
                    let element = document.createElement('textarea');
                    element.innerHTML = row.customer_name;
                    return '<a href="#" class="show-btn" data-id="' + row.id +
                        '">' + element.value + '</a>';
                },
                name: 'customer_name',
            },
            {
                data: function (row) {
                    if (isEmpty(row.customer_image_url)) {
                        return 'N/A';
                    } else {
                        return '<a  href="download-image/' + row.id +
                            '">' + 'Download' +
                            '</a>';
                    }
                },
                name: 'customer_name',
            },
            {
                data: function (row) {
                    let data = [{ 'id': row.id }];
                    return prepareTemplateRender('#testimonialActionTemplate',
                        data);
                }, name: 'id',
            },
        ],
    });

    $(document).on('submit', '#addNewForm', function (e) {
        e.preventDefault();
        if (!checkSummerNoteEmpty('#description',
            'Description field is required.', 1)) {
            return true;
        }
        processingBtn('#addNewForm', '#btnSave', 'loading');
        $.ajax({
            url: testimonialSaveUrl,
            type: 'POST',
            data: new FormData(this),
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
        let testimonialId = $(event.currentTarget).data('id');
        renderData(testimonialId);
    });

    window.renderData = function (id) {
        $.ajax({
            url: testimonialUrl + id + '/edit',
            type: 'GET',
            success: function (result) {
                if (result.success) {
                    let element = document.createElement('textarea');
                    element.innerHTML = result.data.customer_name;
                    $('#testimonialId').val(result.data.id);
                    $('#editCustomerName').val(element.value);
                    if (isEmpty(result.data.customer_image_url)) {
                        $('#editPreviewImage').
                            attr('src', defaultDocumentImageUrl);
                    } else {
                        $('#editPreviewImage').
                            attr('src', result.data.customer_image_url);
                    }
                    $('#editDescription').
                        summernote('code', result.data.description);
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
            'Description field is required.', 1)) {
            return true;
        }
        processingBtn('#editForm', '#btnEditSave', 'loading');
        const id = $('#testimonialId').val();
        $.ajax({
            url: testimonialUrl + id + '/update',
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

    $(document).on('click', '.show-btn', function (event) {
        let testimonialId = $(event.currentTarget).data('id');
        $.ajax({
            url: testimonialUrl + testimonialId,
            type: 'GET',
            success: function (result) {
                console.log(result.data);
                if (result.success) {
                    $('#showCustomerName').html('');
                    $('#showDescription').html('');
                    $('#documentUrl').html('');

                    $('#showCustomerName').append(result.data.customer_name);
                    if (isEmpty(result.data.customer_image_url)) {
                        $('#documentUrl').hide();
                        $('#noDocument').show();
                    } else {
                        $('#noDocument').hide();
                        $('#documentUrl').show();
                        $('#documentUrl').
                            attr('src', result.data.customer_image_url);
                    }
                    let element = document.createElement('textarea');
                    element.innerHTML = (!isEmpty(result.data.description))
                        ? result.data.description
                        : 'N/A';
                    $('#showDescription').append(element.value);
                    $('#showModal').appendTo('body').modal('show');
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });

    $(document).on('click', '.addTestimonialModal', function () {
        $('#addModal').appendTo('body').modal('show');
    });

    $(document).on('click', '.delete-btn', function (event) {
        let testimonialId = $(event.currentTarget).data('id');
        deleteItem(testimonialUrl + testimonialId, tableName, 'Testimonial');
    });

    $('#addModal').on('hidden.bs.modal', function () {
        resetModalForm('#addNewForm', '#validationErrorsBox');
        $('#description').summernote('code', '');
        $('#previewImage').attr('src', defaultDocumentImageUrl);
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });

    $('#description, #editDescription').summernote({
        minHeight: 200,
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    $(document).on('change', '#customerImage', function () {
        if (isValidFile($(this), '#validationErrorsBox')) {
            displayPhoto(this, '#previewImage');
        }
    });

    $(document).on('change', '#editCustomerImage', function () {
        if (isValidFile($(this), '#editValidationErrorsBox')) {
            displayPhoto(this, '#editPreviewImage');
        }
    });
});

