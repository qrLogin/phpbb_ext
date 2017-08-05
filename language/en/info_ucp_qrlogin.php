<?php

/**
 *
 * qrLogin extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 qrLogin <http://qrLogin.info>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
/**
 * DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge(
	$lang, array(
		'UCP_QRLOGIN'			=> 'qrLogin',
		'UCP_QRLOGIN_SETTINGS'	=> 'qrLogin Settings',
		'SCAN_FOR_QRLOGIN'		=> 'Scan for save account qrLogin',
		'SCAN_DESCRIPTION'		=> 'Since we do not know your password, after scanning, you will have to enter the password on the phone.',
		'ABOUT_QRLOGIN'		    => 'About qrLogin',
		'QRLOGIN_DESCRIPTION'	=> 'qrLogin is an authentication system based on the reading of the qr code by the mobile phone and the transfer of authentication data via the http / https protocol to the application or to a web resource.',
	)
);
