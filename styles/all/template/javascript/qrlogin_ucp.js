var qrcode;
var qrl_qrcode;
function qrlogin_set_qrcode(pass){
    var qrlogin_text = "QRLOGIN\nNU:V1\n" + qrlogin_forum_url + "\n/qrlogin\n" + qrlogin_username + "\n" + pass + "\n2";
    qrcode.makeCode(qrlogin_text);
    qrl_qrcode.href = "qrlogin://" + qrlogin_text.replace(/\n/g, "%0A");
    qrl_qrcode.title = qrlogin_title;
    if( pass === '') {
        jQuery('[name="qrlogin_description"]').show();
        jQuery('[name="qrlogin_description_pass"]').hide();
    } else {
        jQuery('[name="qrlogin_description"]').hide();
        jQuery('[name="qrlogin_description_pass"]').show();
    }
}
function qrlogin_get_qrcode(){
    var psw = jQuery('[name="cur_password"]').val();
    qrlogin_set_qrcode(psw);
}
$(document).ready(function(){
    qrl_qrcode = document.getElementById("qrl_qrcode");
    if (qrl_qrcode === null) return;
    qrcode = new QRCode( qrl_qrcode, {
        width: qrlogin_size, height: qrlogin_size,
        colorDark: qrlogin_fore_color, colorLight: qrlogin_back_color,
        correctLevel: QRCode.CorrectLevel.M
        //  ,useSVG: true
    });
    qrlogin_set_qrcode("");
});
