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
		'UCP_QRLOGIN_SETTINGS'	=> 'qrLogin настройки',
		'SCAN_FOR_QRLOGIN'		=> 'Отсканируйте для записи аккаунта в qrLogin',
		'SCAN_DESCRIPTION'		=> 'Поскольку мы не знаем Ваш пароль, то после сканирования, Вам придется ввести пароль на телефоне.<br/><br/>Или Вы можете ввести текущий пароль в поле снизу и обновить QRCODE.',
		'SCAN_DESCRIPTION_PASS'	=> 'В qrcode включен пароль, который Вы ввели. Если Вы ошиблись, то телефон запомнит не правильный пароль и при входе возникнет ошибка.',
		'SCAN_PASSWORD_EXPLAIN'	=> 'Если вы не хотите вводить пароль на телефоне, то вы должны указать текущий пароль.',
		'SHOW_QRCODE'			=> 'Обновить QRCODE',
		'ABOUT_QRLOGIN'		    => 'О программе qrLogin',
		'QRLOGIN_DESCRIPTION'	=> 'qrLogin - система аутентификации, основанная на считывании qr-кода мобильным телефоном и передаче данных аутентификации по протоколу http/https в приложение или на веб-ресурс.',
	)
);
