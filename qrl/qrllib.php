<?php

include "qrlib.php";    
//include "phpqrcode.php";    


function qrLogin_code($qrdata, $pixelPerPoint = 2, $fore_color = 0x00008B, $back_color = 0xFFFFFF)
{
    // temp file for qrcode
    $tmpfile = 'qr_temp' . mt_rand(0, 100000);
    // generate qrcode
	QRcode::svg($qrdata, $tmpfile, 1, $pixelPerPoint, 1, false, $back_color, $fore_color);
	// get qrcode from file
    $_QRcode = file_get_contents($tmpfile);
    // delete temp file
    unlink($tmpfile); 
    
    return $_QRcode;
}

