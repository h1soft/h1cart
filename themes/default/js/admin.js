
function open_popup(url)
{
    var w = 880;
    var h = 570;
    var l = Math.floor((screen.width - w) / 2);
    var t = Math.floor((screen.height - h) / 2);
    var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}

function H_CHECK_ALL(_name) {
    $("input[name='" + _name + "']").each(function() {
        console.log(this.checked);
        if (this.checked) {
            $(this).prop("checked", false);
        } else {
            $(this).prop("checked", true);
        }
    });

}

function goBack(url) {
    location.href = url;
}


function H_Confirm(message) {
    if (!message) {
        message = 'Are you sure?'
    }
    if (confirm(message)) {
        return true;
    }
    return false;
}

function str_repeat(input, multiplier) {
    //  discuss at: http://phpjs.org/functions/str_repeat/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Ian Carter (http://euona.com/)
    //   example 1: str_repeat('-=', 10);
    //   returns 1: '-=-=-=-=-=-=-=-=-=-='

    var y = '';
    while (true) {
        if (multiplier & 1) {
            y += input;
        }
        multiplier >>= 1;
        if (multiplier) {
            input += input;
        } else {
            break;
        }
    }
    return y;
}