'use strict';

$(document).ready(function () {
    $('#filter_status').select2({
        width: '100%',
    });

    $('#immediateAvailable').select2({
        width: '100%',
    });

    $('#jobSkills').select2({
        width: '100%',
    });
});

$(document).on('click', '.delete-btn', function (event) {
    let candidateId = $(event.currentTarget).data('id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to delete this "Candidate" ?',
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
            window.livewire.emit('deleteCandidate', candidateId);
        });
});

document.addEventListener('delete', function () {
    swal({
        title: 'Deleted!',
        text: 'candidate has been deleted.',
        type: 'success',
        confirmButtonColor: '#EB6E80',
        timer: 2000,
    });
});

$(document).on('change', '.isActive', function (event) {
    let candidateId = $(event.currentTarget).data('id');
    $.ajax({
        url: candidateUrl + '/' + candidateId + '/' + 'change-status',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                return true;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('change', '.is-candidate-email-verified', function (event) {
    if ($(this).is(':checked')) {
        let candidateId = $(event.currentTarget).data('id');
        changeEmailVerified(candidateId);
        $(this).attr('disabled', true);
    } else {
        return false;
    }
});

window.changeEmailVerified = function (id) {
    $.ajax({
        url: candidateUrl + '/' + id + '/verify-email',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                return true;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$(document).on('click', '.send-email-verification', function (event) {
    let candidateId = $(event.currentTarget).attr('data-id');
    $.ajax({
        url: candidateUrl + '/' + candidateId + '/resend-email-verification',
        type: 'post',
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                return true;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$('#candidateFilters').on('click', function () {
    $('#candidateFiltersForm').toggleClass('d-block d-none');
});

$('#action_dropdown').click(function () {
    $('#candidateFiltersForm').removeClass('d-block').addClass('d-none');
});

$(document).ready(function () {
    $('#filter_status').on('change', function (e) {
        var data = $('#filter_status').select2('val');
        window.livewire.emit('changeFilter', 'status', data);
    });

    $('#immediateAvailable').on('change', function (e) {
        var data = $('#immediateAvailable').select2('val');
        window.livewire.emit('changeFilter', 'immediateAvailable', data);
    });

    $('#jobSkills').on('change', function (e) {
        var data = $('#jobSkills').select2('val');
        window.livewire.emit('changeFilter', 'jobSkills', data);
    });
});

$(document).on('click', '#reset-filter', function () {
    $('#jobSkills,#immediateAvailable,#filter_status').val('').change();
});

$(document).on('click', function (event) {
    if ($(event.target).
        closest('#candidateFilters,#candidateFiltersForm').length === 0) {
        $('#candidateFiltersForm').removeClass('d-block').addClass('d-none');
    }
});
