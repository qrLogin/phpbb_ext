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
		global $phpbb_container, $template, $request, $config, $user;

		// for compatible with 3.1 version phpBB
		$lang_module = ($config['version'] < 3.2) ? 'user' : 'language';

		$this->tpl_name = 'acp_qrlogin_body';
		$this->page_title = $phpbb_container->get($lang_module)->lang('QRLOGIN_SETTINGS');

		add_form_key('qrlogin_settings');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('qrlogin_settings'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('qrlogin_del_http', $request->variable('qrlogin_del_http', 1));

			$phpbb_container->get('log')->add('admin', $user->data['user_id'], $user->ip, 'ACP_QRLOGIN_SETTING_LOG');

			trigger_error($phpbb_container->get($lang_module)->lang('ACP_QRLOGIN_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'qrlogin_del_http' => $config['qrlogin_del_http'],
			'U_ACTION' => $this->u_action,
		));
	}
}
