'use strict';

let tableName = '#reportedJobsTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: reportedJobsUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '20%',
        },
        {
            'targets': [2],
            'width': '13%',
        },

        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
        {
            'targets': [4],
            'visible': false,
        },
    ],
    columns: [
        {
            data: function (row) {
                return '<a href="' + frontJobDetail + '/' + row.job.job_id +
                    '" target="_blank">' +
                    row.job.job_title + '</a>';
            },
            name: 'job.job_title',
        },
        {
            data: function (row) {
                return '<a href="' + frontCandidateDetail + '/' + row.user.candidate.unique_id +
                    '" target="_blank">' +
                    row.user.full_name + '</a>';
            },
            name: 'user.first_name',
        },
        {
            data: function (row) {
                return row;
            },
            render: function (row) {
                if (row.created_at === null) {
                    return 'N/A';
                }

                return moment(row.created_at).format('Do MMM, Y');
            },
            name: 'created_at',

        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#reportedJobActionTemplate',
                    data);
            }, name: 'id',
        },
        {
            data: 'user.last_name',
            name: 'user.last_name',
        },
    ],
});

$(document).on('click', '.delete-btn', function (event) {
    let reportedJobId = $(event.currentTarget).data('id');
    deleteItem(reportedJobsUrl + reportedJobId, tableName, 'Reported Job');
});

$(document).on('click', '.view-note', function (event) {
    let reportedJobId = $(event.currentTarget).data('id');
    $.ajax({
        url: reportedJobsUrl + reportedJobId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showNote').html('');
                if (!isEmpty(result.data.note) ? $('#showNote').
                    append(result.data.note) : $('#showNote').append('N/A'))
                    $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
