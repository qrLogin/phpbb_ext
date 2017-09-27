if(typeof qrLogin_TimeOut == "undefined"){ var qrLogin_TimeOut = 1000; }
if(typeof qrlogin_login_TimeOut == "undefined"){ var qrlogin_login_TimeOut = 3*60*1000;}
var qrlogin_text = 'QRLOGIN\nL:V1\n' + qrlogin_forum_url + '\n' + qrlogin_session_id;
function qrlogin_if_logged(){ 
    if (document.getElementById("qrlogin_dropdown").style["display"] != "none") {
        $.ajax({
            url: "./qrlogin_ajax",
            success: function(data) {
                if(data) window.location.reload(true);
                else setTimeout(qrlogin_if_logged, qrLogin_TimeOut); 
            },
            error: function(errorThrown) { qrlogin_stop_scan(); },
        });
    }
}
function qrlogin_stop_scan() {
    $('[id="qrlogin_dropdown"]').hide();
}
function qrlogin_start_scan() {
  	setTimeout(qrlogin_if_logged, qrLogin_TimeOut);
  	if (qrlogin_login_TimeOut === 0) return;
	setTimeout(function(){ qrlogin_stop_scan(); }, qrlogin_login_TimeOut);
}
function qrlogin_onclick(){
	if (document.getElementById("qrlogin_dropdown").style["display"] != "none") return;
	qrlogin_start_scan();
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
    qrl_qrcode.href = "qrlogin://" + qrlogin_text.replace(/\n/g, "%0A");
});
