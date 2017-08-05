<?php
/**
*
* @package phpBB Extension - qrlogin
* @copyright (c) 2017 qrlogin - http://qrlogin.info
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

// set error in answer - default !!
var_dump(http_response_code(400));

// get JSON from POST
$postdata = \json_decode(file_get_contents('php://input'), true);

// if data not correct
if ($postdata['objectName'] != 'qrLogin')
{
	exit;
}

$sessionid = urldecode($postdata['sessionid']);
$username = urldecode($postdata['login']);
$password = urldecode($postdata['password']);

// if data not correct
if (empty($sessionid) or empty($username) or empty($password))
{
	exit;
}

// save login to file with name 'qrl_sessionid'
$fn = "./temp/qrl_" . $sessionid;
file_put_contents($fn, $username . '=' . $password);

// waiting for answer - max 50*100ms = 5s
$fna = $fn . 'ans';
$t = 0;
while ((!file_exists($fna)) && ($t < 50))
{
	$t++;
	usleep(100000);
}

// exists answer !
if (file_exists($fna))
{
	var_dump(http_response_code(file_get_contents($fna)));
	unlink($fna);
}

// if file with data exists (((
if (file_exists($fn))
{
	file_put_contents($fn, 0);
	unlink($fn);
}
