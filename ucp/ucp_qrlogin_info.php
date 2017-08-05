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

class ucp_qrlogin_info
{

	function module()
	{
		return array(
			'filename' => '\qrlogin\qrlogin\ucp\ucp_qrlogin_module',
			'title'	=> 'UCP_QRLOGIN',
			'modes'	=> array(
				'settings' => array(
					'title' => 'UCP_QRLOGIN_SETTINGS',
					'auth'  => 'ext_qrlogin/qrlogin',
					'cat'   => array('UCP_QRLOGIN')
				),
			),
		);
	}
}
