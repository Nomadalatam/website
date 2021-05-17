'use strict';

let tableName = '#salaryCurrenciesTbl';
$(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: salaryCurrencyUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '25%',
        },
        {
            'targets': [1, 2],
            'orderable': false,
            'className': 'text-center',
            'width': '8%',
        },
    ],
    columns: [
        {
            data: function (row) {
                return row.currency_name;
            },
            name: 'currency_name',
        },
        {
            data: function (row) {
                return row.currency_code;
            },
            name: 'currency_code',
        },
        {
            data: function (row) {
                return row.currency_icon;
            },
            name: 'currency_icon',
        },
    ],
});
