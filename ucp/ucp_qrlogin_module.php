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
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		// Set desired template
		$this->tpl_name   = 'ucp_qrlogin_body';
		$this->page_title = 'UCP_QRLOGIN_SETTINGS';
	}
}
