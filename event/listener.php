<?php
/**
*
* @package phpBB Extension - qrlogin
* @copyright (c) 2017 qrlogin - http://qrlogin.info
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace qrlogin\qrlogin\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $template;
	protected $user;
	protected $helper;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\controller\helper $helper
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after'	=> 'get_qrcode',
			'core.user_setup'           => 'load_language_on_setup',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'qrlogin/qrlogin',
			'lang_set' => 'qrlogin',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function get_qrcode($event)
	{
		// delete protocol from forum url
		$forum_url = ($this->config['qrlogin_del_http']) ? str_replace(array('http://', 'https://', 'www.'), array('', '', ''), generate_board_url()) : generate_board_url();

		$this->template->assign_vars(array(
			'A_QRLOGIN_FORUM_URL'       => addslashes($forum_url),
			'A_QRLOGIN_AJAX_URL'        => addslashes($this->helper->route('qrlogin_qrlogin_ajax', array(), false, false, UrlGeneratorInterface::ABSOLUTE_URL)),
			'A_QRLOGIN_POST_URL'        => addslashes("/" . $this->helper->route('qrlogin_qrlogin_post', array(), false, false, UrlGeneratorInterface::RELATIVE_PATH)),
			'A_QRLOGIN_SID'             => addslashes(generate_link_hash('qrLogin' . $this->user->session_id) . '=' . $this->user->session_id),
			'QRLOGIN_SIZE'              => (int) $this->config['qrlogin_qrcode_size'],
			'A_QRLOGIN_FORE_COLOR'      => addslashes($this->config['qrlogin_qrcode_fore_color']),
			'A_QRLOGIN_BACK_COLOR'      => addslashes($this->config['qrlogin_qrcode_back_color']),
			'QRLOGIN_TIMEOUT'           => (int) $this->config['qrlogin_timeout'],
			'QRLOGIN_LOGIN_TIMEOUT'     => (int) $this->config['qrlogin_login_timeout'],
		));
	}
}
