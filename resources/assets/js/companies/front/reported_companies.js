'use strict';

$(document).on('click', '.delete-btn', function (event) {
    let reportedCompanyId = $(event.currentTarget).data('id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "Reported Employer" ?',
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
        },
        function () {
            window.livewire.emit('deleteReportedEmployee', reportedCompanyId);
        });
});

document.addEventListener('delete', function () {
    swal({
        title: 'Deleted!',
        text: 'Reported Employer has been deleted.',
        type: 'success',
        confirmButtonColor: '#6777ef',
        timer: 2000,
    });
});

$(document).on('click', '.view-note', function (event) {
    let reportedCompanyId = $(event.currentTarget).data('id');
    $.ajax({
        url: reportedCompaniesUrl + '/' + reportedCompanyId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showNote,#showName,#showReportedBy,#showReportedOn,#showImage').
                    html('');
                if (!isEmpty(result.data.note) ? $('#showNote').
                    append(result.data.note) : $('#showNote').append('N/A'))
                    $('#showName').append(result.data.company.user.first_name);
                $('#showReportedBy').append(result.data.user.first_name);
                $('#showReportedOn').append(result.data.date);
                $('#showImage').
                    append('<img src="' + result.data.company.company_url +
                        '" class="img-responsive users-avatar-img employee-img mr-2" />');
                $('#showModal').appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).ready(function () {
    $('#filter_reported_date').select2();
});

$(document).ready(function () {
    $('#filter_reported_date').on('change', function (e) {
        var data = $('#filter_reported_date').select2('val');
        window.livewire.emit('changeFilter', 'filterReportedDate', data);
    });
});
