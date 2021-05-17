$(document).ready(function () {
    'use strict';

    new AutoNumeric('#toSalary', {
        maximumValue: 200000,
        currencySymbol: '',
        digitGroupSeparator: '\,',
        decimalPlaces: 1,
        currencySymbolPlacement:
        AutoNumeric.options.currencySymbolPlacement.suffix,
    });

    new AutoNumeric('#fromSalary', {
        maximumValue: 90000,
        currencySymbol: '',
        digitGroupSeparator: '\,',
        decimalPlaces: 1,
        currencySymbolPlacement:
        AutoNumeric.options.currencySymbolPlacement.suffix,
    });

    $('#toSalary').on('keyup', function () {
        let fromSalary = parseInt(
            Math.trunc(removeCommas($('#fromSalary').val())));
        let toSalary = parseInt(Math.trunc(removeCommas($('#toSalary').val())));
        if (toSalary < fromSalary) {
            $('#toSalary').focus();
            $('#salaryToErrorMsg').
                text(
                    'Please enter Salary Range To greater than Salary Range From.');
            $('.actions [href=\'#next\']').
                css({ 'opacity': '0.7', 'pointer-events': 'none' });
            $('#saveJob').attr('disabled', true);
        } else {
            $('#salaryToErrorMsg').text('');
            $('.actions [href=\'#next\']').
                css({ 'opacity': '1', 'pointer-events': 'inherit' });
            $('#saveJob').attr('disabled', false);
        }
    });

    $('#toSalary').on('wheel', function (e) {
        $(this).trigger('keyup');
    });

    $('#fromSalary').on('keyup', function () {
        let fromSalary = parseInt(
            Math.trunc(removeCommas($('#fromSalary').val())));
        let toSalary = parseInt(Math.trunc(removeCommas($('#toSalary').val())));
        if (toSalary < fromSalary) {
            $('#fromSalary').focus();
            $('#salaryToErrorMsg').
                text(
                    'Please enter Salary Range To greater than Salary Range From.');
            $('.actions [href=\'#next\']').
                css({ 'opacity': '0.7', 'pointer-events': 'none' });
            $('#saveJob').attr('disabled', true);
        } else {
            $('#salaryToErrorMsg').text('');
            $('.actions [href=\'#next\']').
                css({ 'opacity': '1', 'pointer-events': 'inherit' });
            $('#saveJob').attr('disabled', false);
        }
    });

    $('#fromSalary').on('wheel', function (e) {
        $(this).trigger('keyup');
    });

    $('#jobTypeId,#careerLevelsId,#jobShiftId,#currencyId,#countryId,#stateId,#cityId').
        select2({
            width: '100%',
        });
    $('#salaryPeriodsId,#functionalAreaId,#requiredDegreeLevelId,#preferenceId,#jobCategoryId').
        select2({
            width: '100%',
        });
    $('#SkillId').select2({
        width: '100%',
        placeholder: 'Select Job Skill',
    });
    $('#tagId').select2({
        width: '100%',
        placeholder: 'Select Job Tag',
    });
    if (!$('#companyId').hasClass('.select2-hidden-accessible') &&
        $('#companyId').is('select')) {
        $('#companyId').select2({
            width: '100%',
            placeholder: 'Select Company',
        });
    }

    var date = new Date();
    date.setDate(date.getDate() + 1);
    $('.expiryDatepicker').datetimepicker(DatetimepickerDefaults({
        format: 'YYYY-MM-DD',
        useCurrent: false,
        sideBySide: true,
        minDate: new Date(),
    }));

    $('#createJobForm, #editJobForm').on('submit', function (e) {
        $('#saveJob,#draftJob').attr('disabled', true);
        if (!checkSummerNoteEmpty('#details',
            'Job Description field is required.', 1)) {
            e.preventDefault();
            $('#saveJob,#draftJob').attr('disabled', false);
            return false;
        }
        if ($('#salaryToErrorMsg').text() !== '') {
            $('#toSalary').focus();
            $('#saveJob,#draftJob').attr('disabled', false);
            return false;
        }
    });

    $('#details').summernote({
        minHeight: 200,
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    $('#editDetails').summernote({
        minHeight: 200,
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]],
    });

    $('#countryId').on('change', function () {
        $.ajax({
            url: jobStateUrl,
            type: 'get',
            dataType: 'json',
            data: { postal: $(this).val() },
            success: function (data) {
                $('#stateId').empty();
                $('#stateId').
                    append(
                        $('<option value=""></option>').text('Select State'));
                $.each(data.data, function (i, v) {
                    $('#stateId').
                        append($('<option></option>').attr('value', i).text(v));
                });
            },
        });
    });

    $('#stateId').on('change', function () {
        $.ajax({
            url: jobCityUrl,
            type: 'get',
            dataType: 'json',
            data: {
                state: $(this).val(),
                country: $('#countryId').val(),
            },
            success: function (data) {
                $('#cityId').empty();
                $.each(data.data, function (i, v) {
                    $('#cityId').
                        append($('<option></option>').attr('value', i).text(v));
                });
            },
        });
    });

    window.autoNumeric = function (formId, validationBox) {
        $(formId)[0].reset();
        $('select.select2Selector').each(function (index, element) {
            let drpSelector = '#' + $(this).attr('id');
            $(drpSelector).val('');
            $(drpSelector).trigger('change');
        });
        $(validationBox).hide();
    };
});
