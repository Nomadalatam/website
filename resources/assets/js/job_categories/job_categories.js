'use strict';

let tableName = '#jobCategoriesTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: jobCategoryUrl,
        data: function (data) {
            data.is_featured = $('#filterFeatured').
                find('option:selected').
                val();
        },
    },
    columnDefs: [
        {
            'targets': [2],
            'orderable': false,
            'className': 'text-center',
            'width': '9%',
        },
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
        {
            'targets': [1],
            render: function (data) {
                return data.length > 80 ?
                    data.substr(0, 80) + '...' :
                    data;
            },
        },
        {
            'targets': [0],
            'width': '25%',
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.name;
                return '<a href="#" class="show-btn" data-id="' + row.id +
                    '">' + element.value + '</a>';
            },
            name: 'name',
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
                let checked = row.is_featured === false ? '' : 'checked';
                let data = [{ 'id': row.id, 'checked': checked }];
                return prepareTemplateRender('#isFeatured', data);
            },
            name: 'is_featured',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#jobCategoryActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
    'fnInitComplete': function () {
        $('#filterFeatured').change(function () {
            $(tableName).DataTable().ajax.reload(null, true);
        });
    },
});

$(document).ready(function () {
    $('#filterFeatured').select2();
});

$(document).on('click', '.addJobCategoryModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    processingBtn('#addNewForm', '#btnSave', 'loading');
    if (!checkSummerNoteEmpty('#description',
        'Description field is required.')) {
        processingBtn('#addNewForm', '#btnSave');
        return true;
    }

    $.ajax({
        url: jobCategorySaveUrl,
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
    let jobCategoryId = $(event.currentTarget).data('id');
    renderData(jobCategoryId);
});

window.renderData = function (id) {
    $.ajax({
        url: jobCategoryUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#jobCategoryId').val(result.data.id);
                $('#editName').val(element.value);
                $('#editDescription').
                    summernote('code', result.data.description);
                (result.data.is_featured == 1) ? $('#editIsFeatured').
                    prop('checked', true) : $('#editIsFeatured').
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
    processingBtn('#editForm', '#btnEditSave', 'loading');
    if (!checkSummerNoteEmpty('#editDescription',
        'Description field is required.')) {
        processingBtn('#editForm', '#btnEditSave');
        return true;
    }
    const id = $('#jobCategoryId').val();
    $.ajax({
        url: jobCategoryUrl + id,
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
    let jobCategoryId = $(event.currentTarget).data('id');
    $.ajax({
        url: jobCategoryUrl + jobCategoryId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showName').html('');
                $('#showDescription').html('');
                $('#showIsFeatured').html('');
                $('#showName').append(result.data.name);
                let element = document.createElement('textarea');
                element.innerHTML = (!isEmpty(result.data.description))
                    ? result.data.description
                    : 'N/A';
                $('#showDescription').append(element.value);
                (result.data.is_featured == 1) ? $('#showIsFeatured').
                        append('Yes')
                    : $('#showIsFeatured').append('No');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let jobCategoryId = $(event.currentTarget).data('id');
    deleteItem(jobCategoryUrl + jobCategoryId, tableName, 'Job Category');
});

$('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#description').summernote('code', '');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
});

$(document).on('change', '.isFeatured', function (event) {
    let jobCategoryId = $(event.currentTarget).data('id');
    activeIsFeatured(jobCategoryId);
});

window.activeIsFeatured = function (id) {
    $.ajax({
        url: jobCategoryUrl + id + '/change-status',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
    });
};

$('#description, #editDescription').summernote({
    minHeight: 200,
    height: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]],
});
