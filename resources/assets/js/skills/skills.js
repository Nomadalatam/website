'use strict';

let tableName = '#skillsTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: skillUrl,
    },
    columnDefs: [
        {
            targets: '_all',
            defaultContent: 'N/A',
        },
        {
            'targets': [0],
            'width': '20%',
        },
        {
            'targets': [1],
            render: function (data) {
                if (isEmpty(data)) {
                    return 'N/A';
                }
                return data.length > 100 ?
                    data.substr(0, 100) + '...' :
                    data;
            },
        },
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
                element.innerHTML = row.name;
                return '<a href="#" class="show-btn" data-id="' + row.id +
                    '">' + element.value + '</a>';
            },
            name: 'name',
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
                return prepareTemplateRender('#skillActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.addSkillModal', function () {
    $('#addModal').appendTo('body').modal('show');
});

$(document).on('submit', '#addNewForm', function (e) {
    e.preventDefault();
    if (!checkSummerNoteEmpty('#description',
        'Description field is required.')) {
        return true;
    }
    processingBtn('#addNewForm', '#btnSave', 'loading');
    $.ajax({
        url: skillSaveUrl,
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
    let skillId = $(event.currentTarget).data('id');
    renderData(skillId);
});

window.renderData = function (id) {
    $.ajax({
        url: skillUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let element = document.createElement('textarea');
                element.innerHTML = result.data.name;
                $('#skillId').val(result.data.id);
                $('#editName').val(element.value);
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
        'Description field is required.')) {
        return true;
    }
    processingBtn('#editForm', '#btnEditSave', 'loading');
    const id = $('#skillId').val();
    $.ajax({
        url: skillUrl + id,
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
    let skillId = $(event.currentTarget).data('id');
    $.ajax({
        url: skillUrl + skillId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showName').html('');
                $('#showDescription').html('');
                $('#showName').append(result.data.name);
                let element = document.createElement('textarea');
                element.innerHTML = (!isEmpty(result.data.description))
                    ? result.data.description
                    : 'N/A';
                $('#showDescription').html(element.value);
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let skillId = $(event.currentTarget).data('id');
    deleteItem(skillUrl + skillId, tableName, 'Skill');
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
