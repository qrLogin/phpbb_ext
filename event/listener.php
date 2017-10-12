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

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config       $config
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->config       = $config;
		$this->template 	= $template;
		$this->user 		= $user;
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
		$forum_url = generate_board_url();
		// delete protocol from forum url
		if ($this->config['qrlogin_del_http'])
		{
			$forum_url = str_replace(array('http://', 'https://', 'www.'), array('', '', ''), $forum_url);
		}

		$this->template->assign_vars(array(
			'A_QRLOGIN_FORUM_URL'       => addslashes($forum_url),
			'A_QRLOGIN_USERNAME'        => addslashes($this->user->data['username']),
			'A_QRLOGIN_SESSION_ID'      => addslashes($this->user->session_id),
			'QRLOGIN_SIZE'              => (int) $this->config['qrlogin_qrcode_size'],
			'A_QRLOGIN_FORE_COLOR'      => addslashes($this->config['qrlogin_qrcode_fore_color']),
			'A_QRLOGIN_BACK_COLOR'      => addslashes($this->config['qrlogin_qrcode_back_color']),
			'QRLOGIN_TIMEOUT'           => (int) $this->config['qrlogin_timeout'],
			'QRLOGIN_LOGIN_TIMEOUT'     => (int) $this->config['qrlogin_login_timeout'],
		));
	}
}
