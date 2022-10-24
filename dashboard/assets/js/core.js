function CallAjax(URL, Data, Type, CallBack, isFormData) {
    var obj = {
        url: URL,
        data: Data,
        type: Type,
        error: function () {
            if (CallBack) {
                CallBack("Error! Please Try Again");
            }
        },
        success: function (d) {
            if (CallBack) {
                CallBack(d || '');
            }
        }
    };
    if (isFormData) {
        obj['contentType'] = false;
        obj['processData'] = false;
    }
    $.ajax(obj);
}

function returnMsg(divId, TextMsg, divClass) {
    $('#' + divId).removeClass('error').addClass(divClass).html(TextMsg).css('display', 'block');
    setTimeout(function () {
        $('#' + divId).removeClass(divClass).html('').css('display', 'none');
    }, 5000);
    hideloader();
}


$(document).ready(function () {
    $('.toggle-password').click(function () {
        var x = $(".myPwdInput");
        if (x.attr('type') == 'text') {
            x.attr('type', 'password');
            $('.pwdIcon').removeClass('ft-eye').addClass('ft-eye-off');
        } else {
            x.attr('type', 'text');
            $('.pwdIcon').removeClass('ft-eye-off').addClass('ft-eye');
        }
    });
});

function showModal(id) {
    $("#" + id).modal('show');
}

function hideModal(id) {
    $("#" + id).modal('hide');
}

function validatePercentage(obj) {
    var v = $(obj).val();
    if (v >= 1 && v <= 100) {
        $(obj).removeClass('error');
    } else {
        $(obj).addClass('error');
    }
    return true;
}

/*Not in use*/

function notificatonShow(message, statusClass) {
    $('#notificationDiv').html('<div class="uk-notify-message uk-notify-message-' + statusClass + '" style="opacity: 1; margin-top: 0px; margin-bottom: 10px;">' +
        '        <a class="uk-close"></a>' +
        '        <div>' +
        '            <a href="javascript:void(0)" class="notify-action" onclick="notificatonHide()">Close</a> ' + message +
        '        </div>' +
        '    </div>').fadeIn(500);
    setTimeout(function () {
        notificatonHide();
    }, 2000)
}

function notificatonHide() {
    $('#notificationDiv').fadeOut('500');
}


function copyURL(Projectname, Projecturl) {
    var Project_name = $('#' + Projectname).val().replace(/[_\W]+/g, "_");
    return $('#' + Projecturl).val(Project_name.toLowerCase());
}

function validateURL(Projecturl) {
    return $('#' + Projecturl).val($('#' + Projecturl).val().replace(/[_\W]+/g, "_"));
}

function validateEmail(mail) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( mail );
}

function validatePwd(password) {
    $("#" + password).keypress(function (e) {
        var keyCode = e.keyCode || e.which;
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            toastMsg('Error', 'Only Alphabets and Numbers allowed.', 'error');
        }
        return isValid;
    });
}


function validateNum(phoneNoDiv) {
    $('#' + phoneNoDiv).keydown(function (event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || (event.keyCode == 65 && event.ctrlKey === true)
            || (event.keyCode >= 35 && event.keyCode <= 39)) {

        } else {
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
}

function validateNumByClass(phoneNoDiv) {
    $('.' + phoneNoDiv).keydown(function (event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || (event.keyCode == 65 && event.ctrlKey === true)
            || (event.keyCode >= 35 && event.keyCode <= 39)) {

        } else {
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
}


function showloader() {
    $('#loader').show();
    $('.content-body').css('opacity', '0.5')
}

function hideloader() {
    $('#loader').hide();
    $('.content-body').css('opacity', '1')
}

function toastMsg(heading, info, msgclass) {
    if (msgclass == 'success') {
        toastr.success(info, heading, {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 1500
        })
    } else if (msgclass == 'error') {
        toastr.error(info, heading, {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2000
        })
    } else {
        toastr.info(info, heading, {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2000
        });
    }
    $('.mybtn').removeAttr('disabled', 'disabled');
    hideloader();
}


function validateData(submitedData) {
    var flag = 0;
    var data = {};
    $.each(submitedData, function (i, v) {
        var inp = $('#' + i);
        var id = inp.attr('id');
        // var inpVal = inp.val();
        var inpVal = v;

        var inpLabel = inp.parent('.form-group').find('.label-control').text();
        if (inp.attr('errorText') == '' || inp.attr('errorText') == undefined) {
            inpLabel = 'Invalid ' + inp.parent('.form-group').find('.label-control').text();
        }
        inp.removeClass('error').removeClass('is-invalid').parent('div').find('.invalid-feedback').remove();
        var error = '<div class="invalid-feedback"> </div>';
        if (inp.attr('required')) {
            if (inpVal == '' || inpVal == undefined || inpVal == 'undefined' || inpVal == null || inpVal == 'null' || inpVal == 0) {
                  error = '<div class="invalid-feedback">This is invalid</div>';
                inp.addClass('error').addClass('is-invalid').parent('div').append(error);
                flag = 1;
                toastMsg('Error', inpLabel, 'error');
                return false;
            } else {
                data[id] = inpVal;
            }
        } else {
            data[id] = inpVal;
        }
    });
    if (flag == 0) {
        return data;
    } else {
        return false;
    }
}

// Numeric only control handler
jQuery.fn.ForceNumericOnly =
    function () {
        return this.each(function () {
            $(this).keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal
                return (
                    key == 8 ||
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
            });
        });
    };


$(document).ready(function () {
    var e = document.querySelectorAll('option');
    e.forEach(x => {
        if (x.textContent.length > 60)
            x.textContent = x.textContent.substring(0, 60) + '...';
    })
});