'use strict';

let tableName = '#inquiresTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[2, 'desc']],
    ajax: {
        url: inquiresUrl,
    },
    columnDefs: [
        {
            'targets': [3],
            'orderable': false,
            'className': 'text-center',
            'width': '10%',
        },
        {
            'targets': [0],
            'width': '28%',
        },
        {
            'targets': [2],
            'width': '15%',
        },
    ],
    columns: [
        {
            data: function (row) {
                let element = document.createElement('textarea');
                element.innerHTML = row.name;
                return element.value;
            },
            name: 'name',
        },
        {
            data: 'subject',
            name: 'subject',
        },
        {
            data: function data (row) {
                return moment(row.created_at, 'YYYY-MM-DD').
                    format('Do MMM, YYYY');
            },
            name: 'created_at',
        },
        {
            data: function (row) {
                const viewUrl = inquiresUrl + row.id;
                let data = [
                    {
                        'id': row.id,
                        'url': viewUrl,
                    }];
                return prepareTemplateRender('#inquiresActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});
$(document).on('click', '.delete-btn', function (event) {
    let inquiryId = $(event.currentTarget).data('id');
    deleteItem(inquiresUrl + inquiryId, tableName, 'Inquiry');
});
