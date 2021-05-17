'use strict';

let tableName = '#languagesTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: languageUrl,
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
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.language;
                return element.value;
            },
            name: 'language',
        },
        {
            data: 'iso_code',
            name: 'iso_code',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#languageActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addLanguageModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: languageSaveUrl,
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
    let languageId = $(event.currentTarget).data('id');
    renderData(languageId);
});

window.renderData = function (id) {
    $.ajax({
        url: languageUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.language;
                $('#languageId').val(result.data.id);
                $('#editLanguage').val(element.value);
                $('#editNative').val(result.data.native);
                $('#editIso').val(result.data.iso_code);
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
    const id = $('#languageId').val();
    $.ajax({
        url: languageUrl + id,
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

$(document).on('click', '.delete-btn', function (event) {
    let languageId = $(event.currentTarget).data('id');
    deleteItem(languageUrl + languageId, tableName, 'Language');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

