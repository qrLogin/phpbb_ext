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
// 			'S_SHMOP'						=> (extension_loaded( 'sysvmsg' ) || extension_loaded( 'sysvshm' ) || extension_loaded( 'shmop' )) ? 1 : 0,
			'QRLOGIN_FORUM_URL'             => $forum_url,
			'QRLOGIN_USERNAME'              => $this->user->data['username'],
			'QRLOGIN_SESSION_ID'            => $this->user->session_id,
			'QRLOGIN_SIZE'				    => $this->config['qrlogin_qrcode_size'],
			'QRLOGIN_FORE_COLOR'		    => $this->config['qrlogin_qrcode_fore_color'],
			'QRLOGIN_BACK_COLOR'		    => $this->config['qrlogin_qrcode_back_color'],
			'QRLOGIN_TIMEOUT'               => $this->config['qrlogin_timeout'],
			'QRLOGIN_LOGIN_TIMEOUT'         => $this->config['qrlogin_login_timeout'],
		));
	}
}
