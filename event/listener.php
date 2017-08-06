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

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\config\config       $config
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	* @param \phpbb\language\language	$language
	* @param string					    $root_path
	* @param string					    $php_ext
	*/
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		$root_path,
		$php_ext
	)
	{
		$this->config       = $config;
		$this->template 	= $template;
		$this->user 		= $user;
		$this->language		= $language;
		$this->root_path 	= $root_path;
		$this->php_ext 		= $php_ext;

		set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).DIRECTORY_SEPARATOR.'../qrl');
		include_once "qrllib.php";

		//$this->language->add_lang('qrlogin', 'qrlogin/qrlogin');
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

		// get qrcode settings
		$pixelPerPoint = $this->config['qrlogin_qrcode_pixel_per_point'];
		$fore_color = hexdec(ltrim($this->config['qrlogin_qrcode_fore_color'], '#'));
		$back_color = hexdec(ltrim( $this->config['qrlogin_qrcode_back_color'], '#'));
		// svg qrcode for login
		$qrcode = qrLogin_code("QRLOGIN\nL:V1\n" . $forum_url . "\n" . $this->user->session_id, $pixelPerPoint, $fore_color, $back_color);

		$this->template->assign_vars(array(
			'QRCODE_LOGIN'                  => $qrcode,
			'QRLOGIN_NAVBAR_VIEW'           => $this->config['qrlogin_navbar_view'],
			'QRLOGIN_FIXED_VIEW'            => $this->config['qrlogin_fixed_view'],
			'QRLOGIN_FIXED_SETTINGS'        => $this->config['qrlogin_fixed_settings'],
			'QRLOGIN_FIXED_COLOR'           => $this->config['qrlogin_fixed_color'],
			'QRLOGIN_HEADER_VIEW'           => $this->config['qrlogin_header_view'],
			'QRLOGIN_HEADER_TOP_PADDING'    => $this->config['qrlogin_header_top_padding'],
		));
	}
}
