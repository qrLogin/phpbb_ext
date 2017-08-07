function ifchanged(){
    $.get('./qrlogin_ajax', function(data){
		window.location.reload(true);
    });
}

$(document).ready(function(){
    ifchanged();
    setInterval('ifchanged()', 500);
});
