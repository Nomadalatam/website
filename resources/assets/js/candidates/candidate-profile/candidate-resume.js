'use strict';
$(document).ready(function () {
    $(document).on('click', '.uploadResumeModal', function () {
        $('#uploadModal').appendTo('body').modal('show');
    });

    $(document).on('submit', '#addNewForm', function (e) {
        e.preventDefault();
        processingBtn('#addNewForm', '#btnSave', 'loading');
        $.ajax({
            url: resumeUploadUrl,
            type: 'post',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#uploadModal').modal('hide');
                    location.reload();
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                processingBtn('#addNewForm', '#btnSave');
            },
        });
    });

    $(document).on('change', '#customFile', function () {
        let extension = isValidDocument($(this), '#validationErrorsBox');
        if (!isEmpty(extension) && extension != false) {
            $('#validationErrorsBox').html('').hide();
        }
    });

    window.isValidDocument = function (
        inputSelector, validationMessageSelector) {
        let ext = $(inputSelector).val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['jpg', 'jpeg', 'pdf', 'doc', 'docx']) ==
            -1) {
            $(inputSelector).val('');
            $(validationMessageSelector).removeClass('d-none').
                html(
                    'The document must be a file of type: jpeg, jpg, pdf, doc, docx.').
                show();
            return false;
        }
        return ext;
    };

    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).
            siblings('.custom-file-label').
            addClass('selected').
            html(fileName);
    });

    $(document).on('click', '.delete-resume', function (event) {
        let resumeId = $(event.currentTarget).data('id');
        swal({
                title: 'Delete !',
                text: 'Are you sure want to delete this "Resume" ?',
                type: 'warning',
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
            },
            function () {
                $.ajax({
                    url: resumeUploadUrl + '/' + resumeId,
                    type: 'DELETE',
                    success: function (result) {
                        if (result.success) {
                            setTimeout(location.reload(), 1000);
                        }
                        swal({
                            title: 'Deleted!',
                            text: 'Resume has been deleted.',
                            type: 'success',
                            timer: 2000,
                        });
                    },
                    error: function (data) {
                        swal({
                            title: '',
                            text: data.responseJSON.message,
                            type: 'error',
                            timer: 5000,
                        });
                    },
                });
            },
        );
    });
});

$('#uploadModal').on('hidden.bs.modal', function () {
    $('#customFile').
        siblings('.custom-file-label').
        addClass('selected').
        html('Choose file');
    resetModalForm('#addNewForm', '#validationErrorsBox');
});
