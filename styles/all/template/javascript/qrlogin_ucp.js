$(document).ready(function(){
    var e = document.getElementById("qrl_qrcode");
    new QRCode( e, {
        text: qrlogin_txt,
        width: 128, height: 128, colorDark: "#000064", colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
    });
    e.title = qrlogin_title;
    if ( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) )
        e.href = "qrlogin://" + qrlogin_txt.replace(/\n/g, "%0A");
});
