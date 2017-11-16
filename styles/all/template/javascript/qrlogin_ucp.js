$(document).ready(function(){
    var qrl_qrcode = document.getElementById("qrl_qrcode");
    new QRCode( qrl_qrcode, {
        text: qrlogin_txt,
        width: qrlogin_size, height: qrlogin_size,
        colorDark: qrlogin_fore_color, colorLight: qrlogin_back_color,
        correctLevel: QRCode.CorrectLevel.M
    });
    qrl_qrcode.title = qrlogin_title;
    if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
        qrl_qrcode.href = "qrlogin://" + qrlogin_txt.replace(/\n/g, "%0A");
    }
});
