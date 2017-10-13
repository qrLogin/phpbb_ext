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
		'QRLOGIN_LOGIN_TIMEOUT'						=> 'Таймаут ожидания входа',
		'QRLOGIN_LOGIN_TIMEOUT_EXPLAIN'             => 'Время ожидания входа с телефона. Установите значение  в «0», что бы не останавливать ожидание.',
		'QRLOGIN_TIMEOUT'							=> 'Период опроса сервера',
		'QRLOGIN_TIMEOUT_EXPLAIN'                   => 'Таймаут между запросами к серверу. Установите «0» для опроса без задержек.',
		'QRLOGIN_POLL_LIFETIME'						=> 'Длительность опросов на сервере',
		'QRLOGIN_POLL_LIFETIME_EXPLAIN'             => 'Длительность опросов на сервере. Установите «0» для коротких опросов.',
		'QRLOGIN_POST_TIMEOUT'						=> 'Таймаут ожидания ответа программе в телефоне',
		'QRLOGIN_POST_TIMEOUT_EXPLAIN'              => 'Время ожидания ответа телефону.',
		'QRLOGIN_QRCODE_SIZE'                       => 'Размер кода',
		'QRLOGIN_QRCODE_SIZE_EXPLAIN'               => 'Задайте размер кода в пикселах (рекомендуемый 96).',
		'QRLOGIN_QRCODE_FORE_COLOR'                 => 'Цвет кода',
		'QRLOGIN_QRCODE_BACK_COLOR'                 => 'Цвет фона',
		'QRLOGIN_QRCODE_COLOR_EXPLAIN'              => 'Задавая цвета для кода, выбирайте контрастные сочетания. Предпочтительно темные на светлом фоне.',
		'ACP_QRLOGIN_SETTING_SAVED'                 => 'Настройки qrLogin успешно сохранены!',
		'ACP_QRLOGIN_SETTING_LOG'                   => '<strong>Настройки qrLogin изменены</strong>',
	)
);
