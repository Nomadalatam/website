'use strict';

let tableName = '#noticeboardsTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: noticeboardUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '20%',
        },
        {
            'targets': [1],
            render: function (data) {
                return data.length > 100 ?
                    data.substr(0, 100) + '...' :
                    data;
            },
        },
        {
            'targets': [2, 3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.title;
                return '<a href="#" class="show-btn" data-id="' + row.id +
                    '">' + element.value + '</a>';
            },
            name: 'title',
        },
        {
            data: function (row) {
                if (!isEmpty(row.description)) {
                    let element = document.createElement('textarea');
                    element.innerHTML = row.description;
                    return element.value;
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
                return prepareTemplateRender('#noticeboardActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addNoticeboardModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    if (!checkSummerNoteEmpty('#description',
        'Description field is required.', 1)) {
        return true;
    }
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: noticeboardSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
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
    let noticeboardId = $(event.currentTarget).data('id');
    renderData(noticeboardId);
});

window.renderData = function (id) {
    $.ajax({
        url: noticeboardUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.title;
                $('#noticeboardId').val(result.data.id);
                $('#editTitle').val(element.value);
                $('#editDescription').
                    summernote('code', result.data.description);
                (result.data.is_active == 1) ? $('#editIsActive').
                    prop('checked', true) : $('#editIsActive').
                    prop('checked', false);
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
    const id = $('#noticeboardId').val();
    $.ajax({
        url: noticeboardUrl + id,
        type: 'put',
        data: $(this).serialize(),
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
    let noticeboardId = $(event.currentTarget).data('id');
    $.ajax({
        url: noticeboardUrl + noticeboardId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showTitle').html('');
                $('#showDescription').html('');
                $('#showTitle').append(result.data.title);
                let element = document.createElement('textarea');
                element.innerHTML = (!isEmpty(result.data.description))
                    ? result.data.description
                    : 'N/A';
                $('#showDescription').append(element.value);
                (result.data.is_active === 1)
                    ? $('#showIsActive').
                        html('Active')
                    : $('#showIsActive').
                        html('Deactive');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let noticeboardId = $(event.currentTarget).data('id');
    deleteItem(noticeboardUrl + noticeboardId, tableName, 'Noticeboard');
});

$(document).on('change', '.isActive', function (event) {
    let noticeId = $(event.currentTarget).data('id');
    $.ajax({
        url: noticeboardUrl + noticeId + '/' + 'change-status',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
    });
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#description').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$('#description, #editDescription').summernote({
    minHeight: 200,
    height: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]],
});
