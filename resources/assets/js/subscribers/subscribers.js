'use strict';

let tableName = '#subscribersTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: subscriberUrl,
    },
    columnDefs: [
        {
            'targets': [1],
            'orderable': false,
            'className': 'text-center',
            'width': '5%',
        },
    ],
    columns: [
        {
            data: 'email',
            name: 'email',
        },
        {
            data: function (row) {
                let data = [{ 'id': row.id }];
                return prepareTemplateRender('#subscriberActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.delete-btn', function (event) {
    let subscriberId = $(event.currentTarget).data('id');
    deleteItem(subscriberUrl + '/' + subscriberId, tableName, 'Subscriber');
});

