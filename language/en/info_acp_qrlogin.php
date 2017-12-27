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
		'ACP_QRLOGIN_SETTING_SAVED'                 => 'The qrLogin settings have been successfully saved!',
		'ACP_QRLOGIN_SETTING_LOG'                   => '<strong>qrLogin settings updated</strong>',
	)
);
