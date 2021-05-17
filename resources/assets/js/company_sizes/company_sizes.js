'use strict';
$(document).ready(function () {
    $("#size, #editCompanySize").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '-' && (e.which < 48 || e.which > 57)) {
            $("#errMsg, #errEditMsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
});
let tableName = '#companySizeTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: companySizeUrl,
    },
    columnDefs: [
        {
            'targets': [1],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
    ],
    columns: [
        {
            data: 'size',
            name: 'size',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#companySizeActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addCompanySizeModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: companySizeSaveUrl,
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addModal').modal('hide');
                $('#companySizeTbl').DataTable().ajax.reload(null, false);
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
    let companySizeId = $(event.currentTarget).data('id');
    renderData(companySizeId);
});

window.renderData = function (id) {
    $.ajax({
        url: companySizeUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#companySizeId').val(result.data.id);
                $('#editCompanySize').val(result.data.size);
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
    var id = $('#companySizeId').val();
    $.ajax({
        url: companySizeUrl + id,
        type: 'put',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editModal').modal('hide');
                $('#companySizeTbl').DataTable().ajax.reload(null, false);
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
    let companySizeId = $(event.currentTarget).data('id');
    deleteItem(companySizeUrl + companySizeId, '#companySizeTbl',
        'Company Size');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$('#addModal').on('shown.bs.modal', function () {
    $('#size').focus();
});

$('#editModal').on('shown.bs.modal', function () {
    $('#editCompanySize').focus();
});
