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
		'ACP_QRLOGIN'                               => 'qrLogin',
		'QRLOGIN_SETTINGS'                          => 'qrLogin настройки',
		'GOTO_SITE_QRLOGIN'                         => 'Перейти на сайт qrlogin.info',
		'QRLOGIN_DEL_HTTP'							=> 'Удалять http, https и www из идентификатора',
		'QRLOGIN_DEL_HTTP_EXPLAIN'                  => 'Рекомендуем использовать эту опцию. Тогда в качестве идентификатора для программы qrLogin будет использоваться только домен и путь к Вашему форуму.',
		'ACP_QRLOGIN_SETTING_SAVED'                 => 'Настройки qrLogin успешно сохранены!',
		'ACP_QRLOGIN_SETTING_LOG'                   => '<strong>Настройки qrLogin изменены</strong>',
	)
);
