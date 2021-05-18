'use strict';

let tableName = '#blogTbl';
$(tableName).DataTable({
    scrollX: false,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
        url: blogUrl,
    },
    columnDefs: [
        {
            'targets': [0],
            'width': '20%',
        },
        {
            'targets': [1],
            render: function (data) {
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
                element.innerHTML = row.title;
                let showUrl = blogUrl + '/' + row.id;
                return '<a href="' + showUrl + '" class="show-btn" data-id="' +
                    row.id +
                    '">' + element.value + '</a>';
            },
            name: 'title',
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
                let url = blogUrl + '/' + row.id;
                let data = [
                    {
                        'id': row.id,
                        'url': url + '/edit',
                    }];
                return prepareTemplateRender('#blogActionTemplate',
                    data);
            }, name: 'id',
        },
    ],
});

$(document).on('click', '.btnDeletePost', function (event) {
    let postId = $(this).attr('data-id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "post" ?',
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#EB6E80',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
        },
        function () {
            window.livewire.emit('deletePost', postId);
    });
});

document.addEventListener("delete", function(){
    swal({
        title: 'Deleted!',
            text: 'post has been deleted.',
            type: 'success',
            confirmButtonColor: '#EB6E80',
            timer: 2000,
        });
});

let loadStretchy;
$(document).ready(function () {
    loadStretchy = () => {

        if ($('.cd-stretchy-nav').length > 0) {
            let stretchyNavs = $('.section-body .cd-stretchy-nav');
            stretchyNavs.each(function () {
                let stretchyNav = $(this),
                    stretchyNavTrigger = stretchyNav.find('.cd-nav-trigger');

                stretchyNavTrigger.on('click', function (event) {
                    event.preventDefault();
                    if (stretchyNav.hasClass('nav-is-visible')) {
                        stretchyNav.removeClass('nav-is-visible');
                    } else {
                        stretchyNavs.removeClass('nav-is-visible');
                        stretchyNav.addClass('nav-is-visible');
                    }
                });
            });

            $(document).on('click', function (event) {
                (!$(event.target).is('.cd-nav-trigger') &&
                    !$(event.target).is('.cd-nav-trigger span')) &&
                stretchyNavs.removeClass('nav-is-visible');
            });
        }
    };

    loadStretchy();
});

let filterCategoryId = null;

document.addEventListener('livewire:load', function (event) {
    window.livewire.hook('afterDomUpdate', () => {
        $('#filterCategory').select2({
            width: '100%',
        });
        $('#filterCategory').val(filterCategoryId).trigger('change.select2');
        setTimeout(function () {
            loadStretchy();
        }, 1500);

        if ($(document).find('.cd-stretchy-nav').length > 0) {
            let stretchyNavs = $(document).find('.cd-stretchy-nav');

            stretchyNavs.each(function () {
                let stretchyNav = $(this),
                    stretchyNavTrigger = stretchyNav.find('.cd-nav-trigger');

                stretchyNavTrigger.on('click', function (event) {
                    event.preventDefault();
                    if (stretchyNav.hasClass('nav-is-visible')) {
                        stretchyNav.removeClass('nav-is-visible');
                    } else {
                        stretchyNavs.removeClass('nav-is-visible');
                        stretchyNav.addClass('nav-is-visible');
                    }
                });
            });

            $(document).on('click', function (event) {
                (!$(event.target).is('.cd-nav-trigger') &&
                    !$(event.target).is('.cd-nav-trigger span')) &&
                stretchyNavs.removeClass('nav-is-visible');
            });
        }
    });
});

$(document).on('change', '#filterCategory', function () {
    filterCategoryId = $(this).val();
    window.livewire.emit('filterPost', $(this).val());
});

$(document).ready(function () {
    $('#filterCategory').select2({
        width: '100%',
    });
});
