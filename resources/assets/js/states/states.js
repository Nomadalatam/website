'use strict';

$(document).ready(function () {
    $('#countryId,#editCountryId').select2({
        'width': '100%',
    });
    $('#filter_country').select2({
        width: '170px',
    });
});

let tableName = '#statesTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: stateUrl,
        data: function (data) {
            data.country = $('#filter_country').
                find('option:selected').
                val();
        },
    },
    columnDefs: [
        {
            'targets': [2],
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
            data: 'country.name',
            name: 'country.name',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#stateActionTemplate', data);
            },
            name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $('#filter_country').change(function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).on('click', '.addStateModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: stateSaveUrl,
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
    let stateId = $(event.currentTarget).data('id');
    renderData(stateId);
});

window.renderData = function (id) {
    $.ajax({
        url: stateUrl + '/' + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#stateId').val(result.data.id);
                $('#editName').val(result.data.name);
                $('#editCountryId').
                    val(result.data.country_id).
                    trigger('change');
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
    const id = $('#stateId').val();
    $.ajax({
        url: stateUrl + '/' + id,
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
    let stateId = $(event.currentTarget).data('id');
    deleteItem(stateUrl + '/' + stateId, tableName, 'State');
});

$('#addModal').on('hidden.bs.modal', function () {
    $('#countryId').val('').trigger('change');
    resetModalForm('#addNewForm', '#validationErrorsBox');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});
