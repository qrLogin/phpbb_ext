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
			array('config.add', array('qrlogin_timeout', 1)),
			array('config.add', array('qrlogin_poll_lifetime', 20)),
			array('config.add', array('qrlogin_post_timeout', 10)),
			array('config.add', array('qrlogin_login_timeout', 3)),
			array('config.add', array('qrlogin_qrcode_size', 128)),
			array('config.add', array('qrlogin_qrcode_fore_color', '#000064')),
			array('config.add', array('qrlogin_qrcode_back_color', '#FFFFFF')),

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
					'module_basename'   => '\qrlogin\qrlogin\acp\acp_qrlogin_module',
					'modes'             => array('settings'),
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

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'qrlogin'	=> array(
					'COLUMNS'		=> array(
						'sid'		=> array('CHAR:32', ''),
						'uid'       => array('UINT:10', 0),
						'result'    => array('UINT:4', 0),
					),
					'PRIMARY_KEY'	=> 'sid',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'qrlogin',
			),
		);
	}

}
