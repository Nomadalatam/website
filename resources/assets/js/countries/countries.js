'use strict';

let tableName = '#countriesTbl';
let tbl = $('#countriesTbl').DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: countryUrl,
    },
    columnDefs: [
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
    ],
    columns: [
        {
            data: 'name',
            name: 'name',
        },
        {
            data: 'short_code',
            name: 'short_code',
        },
        {
            data: 'phone_code',
            name: 'phone_code',
            defaultContent: 'N/A',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#countryActionTemplate', data);
            },
            name: 'id',
        },
    ],
});

$(document).on('click', '.addCountryModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: countrySaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $(tableName).DataTable().ajax.reload(null, true);
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
    let countryId = $(event.currentTarget).data('id');
    renderData(countryId);
});

window.renderData = function (id) {
    $.ajax({
        url: countryUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {

                $('#countryId').val(result.data.id);
                $('#editName').val(result.data.name);
                $('#editShortCode').val(result.data.short_code);
                $('#editPhoneCode').val(result.data.phone_code);
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
    const id = $('#countryId').val();
    $.ajax({
        url: countryUrl + '/' + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $(tableName).DataTable().ajax.reload(null, true);
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

$(document).on('click', '.delete-btn', function (event) {
    let countryId = $(event.currentTarget).data('id');
    deleteItem(countryUrl + '/' + countryId, tableName, 'Country');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});
