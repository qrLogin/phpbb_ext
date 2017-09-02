if(typeof qrLogin_TimeOut == "undefined"){ var qrLogin_TimeOut = 1000; }
if(typeof qrlogin_login_TimeOut == "undefined"){ var qrlogin_login_TimeOut = 3*60*1000;}
function qrlogin_if_login(){
    $.get('./qrlogin_ajax', function(){	window.location.reload(true); });
}

var qrlogin_timer_dropdown;
var qrlogin_timeout_dropdown;
function qrlogin_if_login_dropdown(){
    qrlogin_if_login();
    if (document.getElementById("qrlogin_dropdown").style["display"] == "block") return;
    clearInterval(qrlogin_timer_dropdown);
    clearTimeout(qrlogin_timeout_dropdown);
}
function qrlogin_onclick(){
	if (document.getElementById("qrlogin_dropdown").style["display"] == "block") return;
	qrlogin_timer_dropdown = setInterval(qrlogin_if_login_dropdown, qrLogin_TimeOut);
    if (qrlogin_login_TimeOut === 0) return;
    qrlogin_timeout_dropdown = setTimeout(function(){ $('[id="qrlogin_dropdown"]').hide(); }, qrlogin_login_TimeOut);
}

$(document).ready(function(){
    qrlogin_if_login();
    if(!document.getElementById('qrlogin_qrcode')) return;
    var qrlogin_timer = setInterval(qrlogin_if_login, qrLogin_TimeOut);
    if (qrlogin_login_TimeOut === 0) return;
    setTimeout(function() {
        clearInterval(qrlogin_timer);
      	$('[id="qrlogin_qrcode"]').hide();
    }, qrlogin_login_TimeOut);
});
