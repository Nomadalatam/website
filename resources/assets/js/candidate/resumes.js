'use strict';

let tableName = '#resumesTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[2, 'asc']],
    ajax: {
        url: resumesUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '10%',
            'orderable': false,
            'searchable': false,
        },
        {
            'targets': [1],
            'orderable': false,
            'searchable': false,
        },
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
            'searchable': false,
        },
        {
            'targets': [4],
            'visible': false,
        },
    ],
    columns: [
        {
            data: function (row) {
                let url = downloadresumesUrl + '/' + row.media[0].id;

                return '<a href="' + url +
                    '" class="btn btn-primary"><i class="fas fa-download"></i> Download</a>';
            }, name: 'file',
        },
        {
            data: function (row) {

                return row.media[0].name;
            },
            name: 'username',
        },
        { data: 'user.full_name', name: 'user.first_name' },
        {
            data: function (row) {
                let data = [{ 'id': row.media[0].id }];
                return prepareTemplateRender(
                    '#resumesActionTemplate',
                    data);
            }, name: 'id',
        },
        { data: 'user.full_name', name: 'user.last_name' },
    ],
});

$(document).on('click', '.delete-btn', function (event) {
    let resumeId = $(event.currentTarget).data('id');
    deleteItem(deleteresumesUrl + resumeId, tableName, 'Resume');
});
