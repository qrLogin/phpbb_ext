<?php

/**
 *
 * qrlogin extension for phpBB.
 *
 * @copyright (c) 2017 qrlogin <http://qrlogin.info>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace qrlogin\qrlogin\acp;

class acp_qrlogin_info
{

	function module()
	{
		return array(
			'filename' => '\qrlogin\qrlogin\acp\acp_qrlogin_module',
			'title'	=> 'ACP_QRLOGIN',
			'modes'	=> array(
				'settings' => array(
					'title' => 'SETTINGS',
					'auth'  => 'ext_qrlogin/qrlogin && acl_a_board',
					'cat'   => array('ACP_QRLOGIN')
				),
			),
		);
	}
}
