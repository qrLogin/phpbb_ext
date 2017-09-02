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

		// get qrcode settings
		$pixelPerPoint = $this->config['qrlogin_qrcode_pixel_per_point'];
		$fore_color = hexdec(ltrim($this->config['qrlogin_qrcode_fore_color'], '#'));
		$back_color = hexdec(ltrim( $this->config['qrlogin_qrcode_back_color'], '#'));
		// string for qrcode
		$qrtext = "QRLOGIN\nL:V1\n" . $forum_url . "\n" . $this->user->session_id;
		if (class_exists('QRcode'))
		{
			// temp file for qrcode
			$tmpfile = 'qr_temp' . mt_rand(0, 100000);
			// generate svg qrcode
			\QRcode::svg($qrtext, $tmpfile, 1, $pixelPerPoint, 1, false, $back_color, $fore_color);
			// get qrcode from file
			$qrcode = file_get_contents($tmpfile);
			// delete temp file
			unlink($tmpfile);
		}
		else
		{
			$qrcode = '<img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=' . urlencode($qrtext) . '" border="0">';
		}
		global $helper;
		$qrlink = "qrlogin://" . str_replace("\n", "%0A", $qrtext) . "qrlogin://" . urlencode(generate_board_url() . '/' . $this->user->page['page']);

		$this->template->assign_vars(array(
			'QRCODE_LOGIN'                  => $qrcode,
			'QRLOGIN_NAVBAR_VIEW'           => $this->config['qrlogin_navbar_view'],
			'QRLOGIN_FIXED_VIEW'            => $this->config['qrlogin_fixed_view'],
			'QRLOGIN_FIXED_SETTINGS'        => $this->config['qrlogin_fixed_settings'],
			'QRLOGIN_FIXED_COLOR'           => $this->config['qrlogin_fixed_color'],
			'QRLOGIN_HEADER_VIEW'           => $this->config['qrlogin_header_view'],
			'QRLOGIN_HEADER_TOP_PADDING'    => $this->config['qrlogin_header_top_padding'],
			'S_SHMOP'						=> (extension_loaded( 'sysvmsg' ) || extension_loaded( 'sysvshm' ) || extension_loaded( 'shmop' )) ? 1 : 0,
			'S_QRLOGIN_LINK'				=> $qrlink,
			'QRLOGIN_TIMEOUT'               => $this->config['qrlogin_timeout'],
			'QRLOGIN_LOGIN_TIMEOUT'         => $this->config['qrlogin_login_timeout'],
		));
	}
}
