var qrcode;
var qrl_qrcode;
function qrlogin_get_qrcode(){
    var cur_pass = document.getElementById("cur_password").value;
    var qrlogin_text = "QRLOGIN\nNU:V1\n" + qrlogin_forum_url + "\n" + qrlogin_post_url + "\n" + qrlogin_username + "\n" + cur_pass + "\n2";
    qrcode.makeCode(qrlogin_text);
    if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
        qrl_qrcode.href = "qrlogin://" + qrlogin_text.replace(/\n/g, "%0A");
    }
    qrl_qrcode.title = qrlogin_title;
    document.getElementById("qrlogin_description").style["display"] = ( cur_pass === "") ? "block" : "none";
    document.getElementById("qrlogin_description_pass").style["display"] = ( cur_pass === "") ? "none" : "block";
}
$(document).ready(function(){
    qrl_qrcode = document.getElementById("qrl_qrcode");
    if (qrl_qrcode === null) return;
    qrcode = new QRCode( qrl_qrcode, {
        width: qrlogin_size, height: qrlogin_size,
        colorDark: qrlogin_fore_color, colorLight: qrlogin_back_color,
        correctLevel: QRCode.CorrectLevel.M
    });
    qrlogin_get_qrcode("");
});
