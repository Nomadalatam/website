'use strict';

$(document).ready(function () {

    $(document).on('click', '.save-draft', function (e) {
        e.preventDefault();
        submitForm('#applyJobForm', 'draft');
    });

    $(document).on('click', '.apply-job', function (e) {
        e.preventDefault();
        submitForm('#applyJobForm', 'apply');
    });

    window.submitForm = function (formId, applicationType) {
        var data = new FormData($(document).find(formId)[0]);
        data.append('application_type', applicationType);
        $.ajax({
            url: applyJobUrl,
            type: 'post',
            data: data,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result.success) {
                    console.log(result);
                    displaySuccessMessage(result.message);
                    window.location = jobDetailsUrl + '/' + result.data;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    };
});
