'use strict';

$(document).on('click', '.delete-btn', function (event) {
    let reportedCandidateId = $(event.currentTarget).data('id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "Reported Candidate" ?',
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
            window.livewire.emit('deleteReportedCandidate',
                reportedCandidateId);
        });
});

document.addEventListener('delete', function () {
    swal({
        title: 'Deleted!',
        text: 'reported candidate has been deleted.',
        type: 'success',
        confirmButtonColor: '#EB6E80',
        timer: 2000,
    });
});

$(document).on('click', '.view-note', function (event) {
    let reportedCandidateId = $(event.currentTarget).data('id');
    $.ajax({
        url: reportedCandidatesUrl + '/' + reportedCandidateId,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showNote,#showName,#showReportedBy,#showReportedOn,#showImage').
                    html('');
                if (!isEmpty(result.data.note) ? $('#showNote').
                    append(result.data.note) : $('#showNote').append('N/A'))
                    $('#showName').
                        append(result.data.candidate.user.first_name);
                $('#showReportedBy').append(result.data.user.first_name);
                $('#showReportedOn').append(result.data.date);
                $('#showImage').
                    append('<img src="' + result.data.candidate.candidate_url +
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
    $('#filter_by_reported_date').select2();
});

$(document).ready(function () {
    $('#filter_by_reported_date').on('change', function (e) {
        var data = $('#filter_by_reported_date').select2('val');
        window.livewire.emit('changeFilter', 'filterByReportedDate', data);
    });
});
