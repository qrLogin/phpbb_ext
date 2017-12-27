var qrloginAjaxRun = false;
function qrlogin_if_logged(){ 
    if (document.getElementById("qrlogin_dropdown").style["display"] != "none") {
        var d = document.getElementById("qrlogin_dots");
        d.innerHTML = (d.innerHTML.length > 10) ? "." : d.innerHTML + ".";
        $.ajax({
            url: qrlogin_ajax_url,
            method: "POST",
            data: { qrlogin_sid: qrlogin_sid },
            success: function(data) {
                qrloginAjaxRun = false;
                if(data) window.location.reload(true);
                else qrlogin_start_scan(); 
            },
            error: function(errorThrown) {
                qrloginAjaxRun = false;
                qrlogin_stop_scan();
            }
        });
    } else qrloginAjaxRun = false;
}
function qrlogin_stop_scan() {
    document.getElementById("qrlogin_dropdown").style["display"] = "none";
}
function qrlogin_start_scan() {
  	if (qrloginAjaxRun) return;
    qrloginAjaxRun = true;
    setTimeout(qrlogin_if_logged, 2000);
}
var qrlogin_timeout_id = null;
function qrlogin_onclick() {
	if (document.getElementById("qrlogin_dropdown").style["display"] != "none") return;
	qrlogin_start_scan();
    document.getElementById("qrlogin_dots").innerHTML = "";
    clearTimeout(qrlogin_timeout_id);
    qrlogin_timeout_id = setTimeout(function(){ qrlogin_stop_scan(); }, 60000);
}
function randomString(length) {
    var result = '';
    for (var i = length; i > 0; --i) result += Math.floor(Math.random() * 36).toString(36);
    return result;
}
$(document).ready(function() {
    qrlogin_sid += '=' + randomString(10);
    var qrtxt = 'QRLOGIN\nL:V1\n' + qrlogin_forum_url + '\n' + qrlogin_sid;
    var e = document.getElementById("qrl_qrcode");
    new QRCode( e, {
        text: qrtxt,
        width: 128, height: 128, colorDark: "#000064", colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
    });
    e.title = qrlogin_title;
    if ( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) )
        e.href = "qrlogin://" + qrtxt.replace(/\n/g, "%0A") + "qrlogin://" + window.location.href;
});
