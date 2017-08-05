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
		'QRLOGIN_SETTING'							=> 'qrLogin settings',
		'QRLOGIN_QRCODE_HEADER'						=> 'Settings qrcode',
		'QRLOGIN_DEL_HTTP'                          => 'Delete http, https & www from identifier',
		'QRLOGIN_DEL_HTTP_EXPLAIN'					=> 'We recommend using this option. Then, as the identifier for qrLogin, only the domain and path to your forum are used.',
		'QRLOGIN_QRCODE_PIXEL_PER_POINT'			=> 'Size of qrcode',
		'QRLOGIN_QRCODE_PIXEL_PER_POINT_EXPLAIN'	=> 'Size in pixel per point (recommended 2)',
		'QRLOGIN_QRCODE_FORE_COLOR'					=> 'Foreground color',
		'QRLOGIN_QRCODE_FORE_COLOR_EXPLAIN'			=> '',
		'QRLOGIN_QRCODE_BACK_COLOR'					=> 'Background color',
		'QRLOGIN_QRCODE_BACK_COLOR_EXPLAIN'			=> 'When specifying colors for the code, choose contrast combinations. Preferably dark on a light background.',
		'QRLOGIN_VIEW_HEADER'                       => 'Where to show qrcode',
		'QRLOGIN_NAVBAR_VIEW'                       => 'in Navigation bar',
		'QRLOGIN_NAVBAR_VIEW_EXPLAIN'               => 'If you select this option, the code will be shown in the navigation bar on the right side - near the "Registration", in the form of a drop-down box.',
		'QRLOGIN_FIXED_VIEW'                        => 'At fixed position on the screen',
		'QRLOGIN_FIXED_VIEW_EXPLAIN'                => 'If you select this option, the code will be displayed at a fixed location on the screen.',
		'QRLOGIN_FIXED_SETTINGS'                    => 'Location and view of the box with qrcode',
		'QRLOGIN_FIXED_SETTINGS_EXPLAIN'            => 'Set the parameters that determine the location on the screen. The syntax "fixed". For example, the bottom right corner, without fillets: "rigth: 0%; bottom: 0%; padding: 5px" ...',
		'QRLOGIN_FIXED_COLOR'                       => 'Color for box',
		'QRLOGIN_FIXED_COLOR_EXPLAIN'               => 'Color for fixed box with qrcode',
		'QRLOGIN_HEADER_VIEW'                       => 'in Forum header',
		'QRLOGIN_HEADER_VIEW_EXPLAIN'               => 'If you select this option, the qrcode will be shown in the forum header, in standard styles - left of the search box.',
		'QRLOGIN_HEADER_TOP_PADDING'                => 'Padding the top of the qrcode',
		'QRLOGIN_HEADER_TOP_PADDING_EXPLAIN'        => 'Specify an indent from the top of the screen to display the qrcode in the forum header.',
		'QRLOGIN_VIEW_FOOTER'                       => 'If you are not satisfied with any of the options for displaying QRCODE, then you can ban them all and insert the variable <strong> {QRCODE_LOGIN} </ strong> into any place of any template of your Style.',
		'ACP_QRLOGIN_SETTING_SAVED'                 => 'The qrLogin settings have been successfully saved!',
	)
);
