'use strict';

$(document).ready(function () {
    $('#favouriteJobsId').on('change', function () {
        filterJobId = $(this).val();
        window.livewire.emit('changeFilter', 'filterFavouriteJobs',
            $(this).val());
    });
});

let filterJobId = null;
document.addEventListener('livewire:load', function (event) {
    window.livewire.hook('afterDomUpdate', () => {
        $('#favouriteJobsId').select2({
            width: '100%',
        });
        $('#favouriteJobsId').val(filterJobId).trigger('change.select2');
        setTimeout(function () { $('.alert').fadeOut('fast'); }, 4000);
    });
});

$(document).on('click', '.removeJob', function (event) {
    let jobId = $(event.currentTarget).attr('data-id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to remove "Favourite Job" ?',
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
            window.livewire.emit('removeJob', jobId);
        });
});

document.addEventListener('deleted', function () {
    swal({
        title: 'Deleted!',
        text: 'Favourite job has been deleted.',
        type: 'success',
        timer: 2000,
    });
});

$(document).ready(function () {
    $('#favouriteJobsId').
        select2({
            width: '100%',
        });
});
