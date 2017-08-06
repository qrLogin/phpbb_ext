function ifchanged(){
    $.get('./ext/qrlogin/qrlogin/qrl_ajax.php', function(data){
		window.location.reload(true);
    });
}

$(document).ready(function(){
    ifchanged();
    setInterval('ifchanged()', 500);
});
