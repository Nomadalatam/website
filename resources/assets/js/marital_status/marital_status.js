'use strict';

let tableName = '#maritalStatusTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: maritalStatusUrl,
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
            'width': '15%',
        },
        {
            'targets': [1],
            render: function (data) {
                return data.length > 100 ?
                    data.substr(0, 100) + '...' :
                    data;
            },
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.marital_status;
                return '<a href="#" class="show-btn" data-id="' + row.id +
                    '">' + element.value + '</a>';
            },
            name: 'marital_status',
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
                return prepareTemplateRender('#maritalStatusActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addMaritalStatusModal', function () {
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
        url: maritalStatusSaveUrl,
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
    let maritalStatusId = $(event.currentTarget).data('id');
    renderData(maritalStatusId);
});

window.renderData = function (id) {
    $.ajax({
        url: maritalStatusUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.marital_status;
                $('#maritalStatusId').val(result.data.id);
                $('#editMaritalStatus').val(element.value);
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
    const id = $('#maritalStatusId').val();
    $.ajax({
        url: maritalStatusUrl + id,
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
    let salaryPeriodId = $(event.currentTarget).data('id');
    $.ajax({
        url: maritalStatusUrl + salaryPeriodId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showMaritalStatus').html('');
                $('#showDescription').html('');
                $('#showMaritalStatus').append(result.data.marital_status);
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

$(document).on('click', '.delete-btn', function (event) {
    let maritalStatusId = $(event.currentTarget).data('id');
    deleteItem(maritalStatusUrl + maritalStatusId, tableName, 'Marital Status');
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
