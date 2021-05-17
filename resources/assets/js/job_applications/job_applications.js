'use strict';

let tableName = '#jobApplicationsTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: jobApplicationsUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'className': 'text-center',
            'width': '15%',
        },
        {
            'targets': [2],
            'className': 'text-right',
            'width': '15%',
        },
        {
            'targets': [3],
            'className': 'text-center',
            'width': '13%',
            'orderable': false,
        },
        {
            'targets': [4],
            'className': 'text-center',
            'width': '15%',
            'orderable': false,
        },
        {
            'targets': [5],
            'className': 'text-center',
            'width': '12%',
            'orderable': false,
        },
    ],
    columns: [
        {
            data: function (row) {
                let showLink = candidateDetailsUrl + '/' +
                    row.candidate.unique_id;
                return '<a href="' + showLink + '">' +
                    row.candidate.user.full_name + '</a>';
            },
            name: 'candidate.user.first_name',
        },
        {
            data: function (row) {
                return row.job.currency.currency_icon + '&nbsp;' +
                    currency(row.expected_salary).format();
            },
            name: 'expected_salary',
        },
        {
            data: function (row) {
                return moment(row.created_at, 'YYYY-MM-DD').
                    format('Do MMM, YYYY');
            },
            name: 'created_at',
        },
        {
            data: function (row) {
                if (!row.hasResumeAvailable) {
                    let downloadLink = downloadDocumentUrl + '/' + row.id;
                    return '<a href="' + downloadLink + '">' + 'Download' +
                        '</a>';
                }

                return 'N/A';
            },
            name: 'candidate.user.last_name',
        },
        {
            data: function (row) {
                const statusColor = {
                    '0': 'warning',
                    '1': 'primary',
                    '2': 'danger',
                    '3': 'info',
                    '4': 'success',
                };
                return '<span class="badge badge-' + statusColor[row.status] +
                    '">' + statusArray[row.status] + '</span>';
            },
            name: 'status',
        },
        {
            data: function (row) {
                let isCompleted = false;
                let isShortlisted = false;
                if (row.status == 3) {
                    isCompleted = true;
                }
                if (row.status == 4) {
                    isShortlisted = true;
                }
                let data = [
                    {
                        'statusId': row.status,
                        'id': row.id,
                        'isCompleted': isCompleted,
                        'isShortlisted': isShortlisted,
                    },
                ];
                return prepareTemplateRender('#jobApplicationActionTemplate',
                    data);
            },
            name: 'id',
        },

    ],
});

$(document).on('click', '.action-delete', function (event) {
    let jobApplicationId = $(event.currentTarget).data('id');
    deleteItem(jobApplicationDeleteUrl + '/' + jobApplicationId, tableName,
        'Job Application');
});

$(document).on('click', '.short-list', function (event) {
    let jobApplicationId = $(event.currentTarget).data('id');
    let applicationStatus = 4;
    changeStatus(jobApplicationId, applicationStatus);
});

$(document).on('click', '.action-completed', function (event) {
    let jobApplicationId = $(event.currentTarget).data('id');
    let applicationStatus = 3;
    changeStatus(jobApplicationId, applicationStatus);
});

$(document).on('click', '.action-decline', function (event) {
    let jobApplicationId = $(event.currentTarget).data('id');
    let applicationStatus = 2;
    changeStatus(jobApplicationId, applicationStatus);
});

window.changeStatus = function (id, applicationStatus) {
    console.log(jobApplicationStatusUrl + id + '/status/' + applicationStatus);
    $.ajax({
        url: jobApplicationStatusUrl + id + '/status/' + applicationStatus,
        method: 'get',
        cache: false,
        success: function (result) {
            if (result.success) {
                $(tableName).DataTable().ajax.reload(null, false);
            }
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};
