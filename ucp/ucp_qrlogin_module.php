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
		// temp file for qrcode
		$tmpfile = 'qr_temp' . mt_rand(0, 100000);
		// string for qrcode for register account
		$qrdata = "QRLOGIN\nNU:V1\n" .  $forum_url . "\n/qrlogin\n" . $user->data['username'] . "\n\n2";
		// generate svg qrcode
		\QRcode::svg($qrdata, $tmpfile, 1, $pixelPerPoint, 1, false, $back_color, $fore_color);
		// get qrcode from file
		$qrcode = file_get_contents($tmpfile);
		// delete temp file
		unlink($tmpfile);

		$template->assign_vars(array(
			'QRCODE_REGISTER'   => $qrcode
		));
	}
}
