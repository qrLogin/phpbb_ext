<?php

/**
 *
 * qrlogin extension for phpBB.
 *
 * @copyright (c) 2017 qrlogin <http://qrlogin.info>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace qrlogin\qrlogin\ucp;

class ucp_qrlogin_module
{

	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).DIRECTORY_SEPARATOR.'../qrl');
		include_once "qrllib.php";

		global $user, $template, $config;

		// Set desired template
		$this->tpl_name   = 'ucp_qrlogin_body';
		$this->page_title = 'UCP_QRLOGIN_SETTINGS';

		$forum_url = generate_board_url();
		// delete protocol from forum url
		if ($config['qrlogin_del_http'])
		{
			$forum_url = str_replace(array('http://', 'https://', 'www.'), array('', '', ''), $forum_url);
		}

		// get qrcode settings
		$pixelPerPoint = $config['qrlogin_qrcode_pixel_per_point'];
		$fore_color = hexdec(ltrim($config['qrlogin_qrcode_fore_color'], '#'));
		$back_color = hexdec(ltrim($config['qrlogin_qrcode_back_color'], '#'));

		// svg qrcode for register account
		$qrcode = qrLogin_code("QRLOGIN\nNU:V1\n" .  $forum_url . "\n/ext/qrlogin/qrlogin/qrl_post.php\n" . $user->data['username'] . "\n\n2", $pixelPerPoint, $fore_color, $back_color);

		$template->assign_vars(array(
			'QRCODE_REGISTER'   => $qrcode
		));
	}
}
