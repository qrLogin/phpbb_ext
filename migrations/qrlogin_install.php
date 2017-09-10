<?php

/**
 *
 * qrlogin extension for phpBB.
 *
 * @copyright (c) 2017 qrlogin <http://qrlogin.info>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace qrlogin\qrlogin\migrations;

class qrlogin_install extends \phpbb\db\migration\migration
{
	public function update_data()
	{

		return array(
			// Add the config variable we want to be able to set
			array('config.add', array('qrlogin_del_http', 1)),
			array('config.add', array('qrlogin_timeout', 10)),
			array('config.add', array('qrlogin_post_timeout', 10)),
			array('config.add', array('qrlogin_login_timeout', 3)),
			array('config.add', array('qrlogin_qrcode_pixel_per_point', 2)),
			array('config.add', array('qrlogin_qrcode_fore_color', '#00008B')),
			array('config.add', array('qrlogin_qrcode_back_color', '#FFFFFF')),
			array('config.add', array('qrlogin_navbar_view', 1)),
			array('config.add', array('qrlogin_fixed_view', 1)),
			array('config.add', array('qrlogin_fixed_settings', 'left: 0%; bottom: 0%; padding: 5px; border-radius: 10px')),
			array('config.add', array('qrlogin_fixed_color', '#FFFFFF')),
			array('config.add', array('qrlogin_header_view', 1)),
			array('config.add', array('qrlogin_header_top_padding', 10)),

			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_QRLOGIN'
			)),
			array('module.add', array(
				'acp',
				'ACP_QRLOGIN',
				array(
					'module_basename'	=> '\qrlogin\qrlogin\acp\acp_qrlogin_module',
					'settings'				=> array('settings'),
				),
			)),

			// Add UCP module
			array('module.add', array(
				'ucp',
				'',
				'UCP_QRLOGIN'
			)),
			array('module.add', array(
				'ucp',
				'UCP_QRLOGIN',
				array(
					'module_basename'	 => '\qrlogin\qrlogin\ucp\ucp_qrlogin_module',
					'modes'				 => array('settings'),
				),
			)),
		);
	}
}
