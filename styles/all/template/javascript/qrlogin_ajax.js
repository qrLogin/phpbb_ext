if(typeof qrLogin_TimeOut == "undefined"){ var qrLogin_TimeOut = 1000; }
if(typeof qrlogin_login_TimeOut == "undefined"){ var qrlogin_login_TimeOut = 3*60*1000;}
function randomString(length) {
    var result = '';
    for (var i = length; i > 0; --i) result += Math.floor(Math.random() * 36).toString(36);
    return result;
}
var qrlogin_session = randomString(20);
var qrlogin_text = 'QRLOGIN\nL:V1\n' + qrlogin_forum_url + '\n' + qrlogin_session;
var qrloginAjaxRun = 0;
function qrlogin_if_logged(){ 
    if (document.getElementById("qrlogin_dropdown").style["display"] != "none") {
        qrlogin_set_dots();
        $.ajax({
            url: qrlogin_ajax_url,
            method: "POST",
            data: { qrlogin_sid: qrlogin_session },
            success: function(data) {
                qrloginAjaxRun = 0;
                if(data) window.location.reload(true);
                else qrlogin_start_scan(); 
            },
            error: function(errorThrown) {
                qrloginAjaxRun = 0;
                qrlogin_stop_scan();
            }
        });
    } else qrloginAjaxRun = 0;
}
function qrlogin_stop_scan() {
    document.getElementById("qrlogin_dropdown").style["display"] = "none";
}
function qrlogin_start_scan() {
  	if (qrloginAjaxRun === 0){
  	    qrloginAjaxRun = 1;
      	setTimeout(qrlogin_if_logged, qrLogin_TimeOut);
  	}
}
function qrlogin_set_dots() {
    var d = document.getElementById("qrlogin_dots");
    d.innerHTML = (d.innerHTML.length > 10) ? "." : d.innerHTML + ".";
}
function qrlogin_onclick(){
	if (document.getElementById("qrlogin_dropdown").style["display"] != "none") return;
	qrlogin_start_scan();
    if (qrlogin_login_TimeOut === 0) return;
    setTimeout(function(){ qrlogin_stop_scan(); }, qrlogin_login_TimeOut);
}
$(document).ready(function(){
    var qrl_qrcode = document.getElementById("qrl_qrcode");
    if (qrl_qrcode === null) return;
    var qrcode = new QRCode( qrl_qrcode, {
        text: qrlogin_text, width: qrlogin_size, height: qrlogin_size,
        colorDark: qrlogin_fore_color, colorLight: qrlogin_back_color,
        correctLevel: QRCode.CorrectLevel.M
    });
    qrl_qrcode.title = qrlogin_title;
    if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
        qrl_qrcode.href = "qrlogin://" + qrlogin_text.replace(/\n/g, "%0A");
    }
});
