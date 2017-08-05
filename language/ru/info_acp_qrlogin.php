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
		'QRLOGIN_SETTING'                           => 'qrLogin настройки',
        'QRLOGIN_QRCODE_HEADER'                     => 'Параметры QRCODE',
        'QRLOGIN_DEL_HTTP'                          => 'Удалять http, https и www из идентификатора',
        'QRLOGIN_DEL_HTTP_EXPLAIN'                  => 'Рекомендуем использовать эту опцию. Тогда в качестве идентификатора для программы qrLogin будет использоваться только домен и путь к Вашему форуму.',
        'QRLOGIN_QRCODE_PIXEL_PER_POINT'            => 'Размер кода',
        'QRLOGIN_QRCODE_PIXEL_PER_POINT_EXPLAIN'    => 'Задайте размер кода в пикселах на точку (рекомендуемый 2)',
        'QRLOGIN_QRCODE_FORE_COLOR'                 => 'Цвет кода',
        'QRLOGIN_QRCODE_FORE_COLOR_EXPLAIN'         => '',
        'QRLOGIN_QRCODE_BACK_COLOR'                 => 'Цвет фона',
        'QRLOGIN_QRCODE_BACK_COLOR_EXPLAIN'         => 'Задавая цвета для кода, выбирайте контрастные сочетания. Предпочтительно темные на светлом фоне.',
        'QRLOGIN_VIEW_HEADER'                       => 'Где показывать',
        'QRLOGIN_NAVBAR_VIEW'                       => 'Меню навигации',
        'QRLOGIN_NAVBAR_VIEW_EXPLAIN'               => 'Если выбрать эту опцию, код будет показан в меню навигации справа - возле "Регистрации", в виде выпадающего окошка.',
        'QRLOGIN_FIXED_VIEW'                        => 'Фиксированная позиция на экране',
        'QRLOGIN_FIXED_VIEW_EXPLAIN'                => 'Если выбрать эту опцию, код будет показан в фиксированном месте экрана.',
        'QRLOGIN_FIXED_SETTINGS'                    => 'Расположение и вид отображения кода',
        'QRLOGIN_FIXED_SETTINGS_EXPLAIN'            => 'Задайте параметры, определяющие расположение на экране. Синтаксис "fixed". Например, правый нижний угол, без скруглений:"rigth: 0%; bottom: 0%; padding: 5px"...',
        'QRLOGIN_FIXED_COLOR'                       => 'Цвет окошка',
        'QRLOGIN_FIXED_COLOR_EXPLAIN'               => 'Цвет окошка для фиксированного отображения кода',
        'QRLOGIN_HEADER_VIEW'                       => 'Показать в заголовка форума',
        'QRLOGIN_HEADER_VIEW_EXPLAIN'               => 'Если выбрать эту опцию, код будет показан в заголовке форума, в стандартных темах - левее блока поиска.',
        'QRLOGIN_HEADER_TOP_PADDING'                => 'Отступ сверху над кодом',
        'QRLOGIN_HEADER_TOP_PADDING_EXPLAIN'        => 'Задайте отступ от верха экрана для показа кода в заголовке форума.',
        'QRLOGIN_VIEW_FOOTER'                       => 'Если Вас не устраивает ни один из вариантов показа QRCODE, то Вы можете запретить их все и вставить в любое место любого шаблон Вашей темы переменную <strong>{QRCODE_LOGIN}</strong>.',
        'ACP_QRLOGIN_SETTING_SAVED'                 => 'Настройки qrLogin успешно сохранены!',
	)
);
