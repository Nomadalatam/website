'use strict';

// open edit user profile model
$(document).on('click', '.editProfileModal', function (event) {
    renderProfileData();
});

window.renderProfileData = function () {
    $.ajax({
        url: profileUrl,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let user = result.data;
                let candidate = result.data.candidate;
                $('#editUserId').val(user.id);
                $('#firstName').val(user.first_name);
                $('#lastName').val(user.last_name);
                $('#editEmail').val(user.email);
                $('#editphoneNumber').val(user.phone);
                if (isEmpty(candidate.candidate_url)) {
                    $('#editpreviewImage').
                        attr('src', defaultImageUrl);
                } else {
                    $('#editpreviewImage').
                        attr('src', candidate.candidate_url);
                }
                $('#editProfileModal').appendTo('body').modal('show');
            }
        },
    });
};

$(document).on('change', '#editprofile', function () {
    if (isValidFile($(this), '#validationErrorsBox')) {
        validatePhoto(this, '#editpreviewImage');
    }
});

window.validatePhoto = function (input, selector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                if ((image.height / image.width) !== 1) {
                    $('#validationErrorsBox').
                        removeClass('d-none');
                    $('#validationErrorsBox').
                        html('Image aspect ratio should be 1:1').
                        show();
                    $('#btnPrEditSave').prop('disabled', true);
                    return false;
                }
                $(selector).attr('src', e.target.result);
                $('#btnPrEditSave').prop('disabled', false);
                displayPreview = true;
            };
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
            $(selector).show();
        }
    }
};

$(document).on('submit', '#editProfileForm', function (event) {
    event.preventDefault();
    let loadingButton = jQuery(this).find('#btnPrEditSave');
    loadingButton.button('loading');
    $.ajax({
        url: profileUpdateUrl,
        type: 'post',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            displaySuccessMessage(result.message);
            $('#editProfileModal').modal('hide');
            location.reload();
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            loadingButton.button('reset');
        },
    });
});

$(document).on('submit', '#changePasswordForm', function (event) {
    event.preventDefault();
    let isValidate = validatePassword();
    if (!isValidate) {
        return false;
    }
    let loadingButton = jQuery(this).find('#btnPrPasswordEditSave');
    loadingButton.button('loading');
    $.ajax({
        url: changePasswordUrl,
        type: 'post',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                $('#changePasswordModal').modal('hide');
                displaySuccessMessage(result.message);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            loadingButton.button('reset');
        },
    });
});

function validatePassword () {
    let currentPassword = $('#pfCurrentPassword').val().trim();
    let password = $('#pfNewPassword').val().trim();
    let confirmPassword = $('#pfNewConfirmPassword').val().trim();

    if (currentPassword == '' || password == '' || confirmPassword == '') {
        $('#editPasswordValidationErrorsBox').
            show().
            html('Please fill all the required fields.');
        return false;
    }
    return true;
}

$(document).on('submit', '#changeLanguageForm', function (event) {
    event.preventDefault();
    let loadingButton = jQuery(this).find('#btnLanguageChange');
    loadingButton.button('loading');
    $.ajax({
        url: updateLanguageURL,
        type: 'post',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            $('#changePasswordModal').modal('hide');
            displaySuccessMessage(result.message);
            setTimeout(function () {
                location.reload();
            }, 1500);
        },
        error: function (result) {
            manageAjaxErrors(result, 'editProfileValidationErrorsBox');
        },
        complete: function () {
            loadingButton.button('reset');
        },
    });
});

$('#editProfileModal').on('hidden.bs.modal', function () {
    resetModalForm('#editProfileForm', '#validationErrorsBox');
});

$('#changePasswordModal').on('hidden.bs.modal', function () {
    resetModalForm('#changePasswordForm', '#editPasswordValidationErrorsBox');
});
$('.changePasswordModal').on('click', function () {
    $('#changePasswordModal').appendTo('body').modal('show');
});

$('.changeLanguageModal').on('click', function () {
    $('#changeLanguageModal').appendTo('body').modal('show');
});
$('#changeLanguageModal').on('hidden.bs.modal', function () {
    resetModalForm('#changeLanguageForm', '#editProfileValidationErrorsBox');
});

// $('#language').select2({
//     width: '100%'
// });
