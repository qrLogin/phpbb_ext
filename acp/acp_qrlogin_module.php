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

class acp_qrlogin_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container, $template, $request, $config;

		$this->tpl_name = 'acp_qrlogin_body';
		$this->page_title	= $phpbb_container->get('language')->lang('QRLOGIN_SETTING');

		add_form_key('qrlogin_settings'); 

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('qrlogin_settings'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('qrlogin_del_http', $request->variable('qrlogin_del_http', 1));
			$config->set('qrlogin_timeout', $request->variable('qrlogin_timeout', 10));
			$config->set('qrlogin_qrcode_pixel_per_point', $request->variable('qrlogin_qrcode_pixel_per_point', 2));
			$config->set('qrlogin_qrcode_fore_color', $request->variable('qrlogin_qrcode_fore_color', '#00008B'));
			$config->set('qrlogin_qrcode_back_color', $request->variable('qrlogin_qrcode_back_color', '#FFFFFF'));
			$config->set('qrlogin_navbar_view', $request->variable('qrlogin_navbar_view', 1));
			$config->set('qrlogin_fixed_view', $request->variable('qrlogin_fixed_view', 0));
			$config->set('qrlogin_fixed_settings', $request->variable('qrlogin_fixed_settings', 'left: 0%; bottom: 0%; padding: 5px; border-radius: 0px 10px 0px 0px'));
			$config->set('qrlogin_fixed_color', $request->variable('qrlogin_fixed_color', '#FFFFFF'));
			$config->set('qrlogin_header_view', $request->variable('qrlogin_header_view', 0));
			$config->set('qrlogin_header_top_padding', $request->variable('qrlogin_header_top_padding', 0));

			trigger_error($phpbb_container->get('language')->lang('ACP_QRLOGIN_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'qrlogin_del_http' => $config['qrlogin_del_http'],
			'qrlogin_timeout' => $config['qrlogin_timeout'],
			'qrlogin_qrcode_pixel_per_point' => $config['qrlogin_qrcode_pixel_per_point'],
			'qrlogin_qrcode_fore_color' => $config['qrlogin_qrcode_fore_color'],
			'qrlogin_qrcode_back_color' => $config['qrlogin_qrcode_back_color'],
			'qrlogin_navbar_view' => $config['qrlogin_navbar_view'],
			'qrlogin_fixed_view' => $config['qrlogin_fixed_view'],
			'qrlogin_fixed_settings' => $config['qrlogin_fixed_settings'],
			'qrlogin_fixed_color' => $config['qrlogin_fixed_color'],
			'qrlogin_header_view' => $config['qrlogin_header_view'],
			'qrlogin_header_top_padding' => $config['qrlogin_header_top_padding'],
			'S_SHMOP' => extension_loaded('shmop') ? 1 : 0,
			'S_QRCODE_CLASS' => class_exists('QRcode') ? 1 : 0,
			'U_ACTION' => $this->u_action,
		));
	}
}
