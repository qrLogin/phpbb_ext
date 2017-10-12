if(typeof qrLogin_TimeOut == "undefined"){ var qrLogin_TimeOut = 1000; }
if(typeof qrlogin_login_TimeOut == "undefined"){ var qrlogin_login_TimeOut = 3*60*1000;}
var qrlogin_text = 'QRLOGIN\nL:V1\n' + qrlogin_forum_url + '\n' + qrlogin_session_id;
var qrloginAjaxRun = 0;
function qrlogin_if_logged(){ 
    if (document.getElementById("qrlogin_dropdown").style["display"] != "none") {
        qrlogin_set_dots();
        $.ajax({
            url: "./qrlogin_ajax",
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
    $('[id="qrlogin_dropdown"]').hide();
}
function qrlogin_start_scan() {
  	if (qrloginAjaxRun === 0){
  	    qrloginAjaxRun = 1;
      	setTimeout(qrlogin_if_logged, qrLogin_TimeOut);
  	}
}
var qrlogin_dots = "";
function qrlogin_set_dots() {
	qrlogin_dots += "."; 
	if (qrlogin_dots.length > 10) { qrlogin_dots = ""; }
    try { document.getElementById("qrlogin_dots").innerHTML = qrlogin_dots; } catch(e) {}
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
