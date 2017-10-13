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
// ’ « » “ ” …
//

$lang = array_merge(
	$lang, array(
		'ACP_QRLOGIN'								=> 'qrLogin',
		'QRLOGIN_SETTINGS'							=> 'qrLogin settings',
		'GOTO_SITE_QRLOGIN'                         => 'Go to site qrlogin.info',
		'QRLOGIN_DEL_HTTP'                          => 'Delete http, https &amp; www from identifier',
		'QRLOGIN_DEL_HTTP_EXPLAIN'					=> 'We recommend using this option. Then, as the identifier for qrLogin, only the domain and path to your forum are used.',
		'QRLOGIN_TIMEOUT'							=> 'Server polling timeout',
		'QRLOGIN_TIMEOUT_EXPLAIN'                   => 'Timeout between requests to the server. Set "0" to polling without delay.',
		'QRLOGIN_POST_TIMEOUT'						=> 'Timeout for wait answer to phone',
		'QRLOGIN_POST_TIMEOUT_EXPLAIN'              => 'Timeout for answer to phone.',
		'QRLOGIN_LOGIN_TIMEOUT'						=> 'Timeout for wait logging',
		'QRLOGIN_LOGIN_TIMEOUT_EXPLAIN'             => 'Timeout for logging from qrLogin. Set "0" to not stop waiting.',
		'QRLOGIN_POLL_LIFETIME'						=> 'Server polling duration',
		'QRLOGIN_POLL_LIFETIME_EXPLAIN'             => 'Duration of polls on the server. Set "0" for short polling.',
		'QRLOGIN_QRCODE_SIZE'                       => 'Size of qrcode',
		'QRLOGIN_QRCODE_SIZE_EXPLAIN'               => 'Size in pixels (recommended 96).',
		'QRLOGIN_QRCODE_FORE_COLOR'					=> 'Foreground color',
		'QRLOGIN_QRCODE_BACK_COLOR'					=> 'Background color',
		'QRLOGIN_QRCODE_COLOR_EXPLAIN'              => 'When specifying colors for the code, choose contrast combinations. Preferably dark on a light background.',
		'ACP_QRLOGIN_SETTING_SAVED'                 => 'The qrLogin settings have been successfully saved!',
		'ACP_QRLOGIN_SETTING_LOG'                   => '<strong>qrLogin settings updated</strong>',
	)
);
