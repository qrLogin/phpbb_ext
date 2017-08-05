<?php
/**
*
* @package phpBB Extension - qrlogin
* @copyright (c) 2017 qrlogin - http://qrlogin.info
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('ucp');

// set file name
$fn = "./temp/qrl_" . $user->session_id;
// file not exists
if(!file_exists($fn)) exit;

// get login data
$logindata = preg_split("/=/", file_get_contents($fn));
// delete file
file_put_contents($fn, 0);
unlink($fn);

// set file name for answer
$fn = $fn . 'ans';

// set user for Session	
$username = $logindata[0];
$password = $logindata[1];
$autologin = false;
// do Login user
$login = $auth->login($username, $password, $autologin);

if((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $user->data['user_id'] != ANONYMOUS)
{
	echo '!';
	file_put_contents($fn, 200);
}
else
{
	file_put_contents($fn, 403);
}
