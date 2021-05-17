'use strict';

document.addEventListener('livewire:load', function (event) {
    window.livewire.hook('afterDomUpdate', () => {
        setTimeout(function () { $('.alert').fadeOut('fast'); }, 4000);
    });
});

$(document).on('click', '.favorite-companies-delete', function (event) {
    let jobId = $(event.currentTarget).attr('data-id');
    swal({
            title: 'Delete !',
            text: 'Are you sure want to remove "Favourite Company" ?',
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
            window.livewire.emit('removeFavouriteCompany', jobId);
        });
});

document.addEventListener('deleted', function () {
    swal({
        title: 'Deleted!',
        text: 'Favourite company has been deleted.',
        type: 'success',
        timer: 2000,
    });
});
