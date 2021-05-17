'use strict';

let tableName = '#jobShiftTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: jobShiftUrl,
    },
    columnDefs: [
        {
            'targets': [2],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
        {
            'targets': [0],
            'width': '25%',
        },
        {
            'targets': [1],
            render: function (data) {
                return data.length > 80 ?
                    data.substr(0, 80) + '...' :
                    data;
            },
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.shift;
                return '<a href="#" class="show-btn" data-id="' + row.id +
                    '">' + element.value + '</a>';
            },
            name: 'shift',
        },
        {
            data: function (row) {
                if (row.description != '') {
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
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#jobShiftActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addJobShiftModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    if (!checkSummerNoteEmpty('#description',
        'Description field is required.', 1)) {
        processingBtn('#addNewForm', '#btnSave');
        return true;
    }
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: jobShiftSaveUrl,
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
    let jobShiftId = $(event.currentTarget).data('id');
    renderData(jobShiftId);
});

window.renderData = function (id) {
    $.ajax({
        url: jobShiftUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.shift;
                $('#jobShiftId').val(result.data.id);
                $('#editShift').val(element.value);
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
        processingBtn('#editForm', '#btnEditSave');
        return true;
    }
    processingBtn('#editForm', '#btnEditSave', 'loading');
    const id = $('#jobShiftId').val();
    $.ajax({
        url: jobShiftUrl + id,
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
    let jobShiftId = $(event.currentTarget).data('id');
    $.ajax({
        url: jobShiftUrl + jobShiftId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showShift').html('');
                $('#showDescription').html('');
                $('#showShift').append(result.data.shift);
                let element = document.createElement('textarea');
                element.innerHTML = result.data.description;
                $('#showDescription').append(element.value);
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let jobShiftId = $(event.currentTarget).data('id');
    deleteItem(jobShiftUrl + jobShiftId, tableName, 'Job Shift');
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
