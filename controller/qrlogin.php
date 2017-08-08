<?php
/**
*
* @package phpBB Extension - qrLogin
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace qrlogin\qrlogin\controller;

use Symfony\Component\HttpFoundation\Response;

class qrlogin
{
	protected $auth;
	protected $user;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\user $user)
	{
		$this->auth = $auth;
		$this->user = $user;
	}

	private function get_file_name($data)
	{
		return  './ext/qrlogin/qrlogin/temp/' . hash('md5', 'qrlogin' . $data);
	}

	private function file_get_contents_and_delete($fname)
	{
		$content = file_get_contents($fname);
		file_put_contents($fname, 0);
		unlink($fname);
		return $content;
	}

	public function ajax()
	{
		// set file names
		$fname_req = $this->get_file_name($this->user->session_id);
		$fname_ans = $this->get_file_name($fname_req);

		// file not exists
		if (!file_exists($fname_req))
		{
			return new Response('', 400);
		}

		// get login data
		$post = $this->file_get_contents_and_delete($fname_req);
		$postdata = json_decode($post, true);

		// if data not correct
		if (($postdata['objectName'] != 'qrLogin') || (urldecode($postdata['sessionid']) != $this->user->session_id))
		{
			return new Response('', 400);
		}

		// do Login user
		$login = $this->auth->login(urldecode($postdata['login']), urldecode($postdata['password']), false);

		$res = 403;
		if ((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $this->user->data['user_id'] != ANONYMOUS)
		{
			// set response to OK for refresh page in ajax
			$res = 200;
		}

		file_put_contents($fname_ans, $res);
		return new Response('', $res);
	}

	public function post()
	{
		// get JSON from POST
		$post = file_get_contents('php://input');
		$postdata = json_decode($post, true);

		// if data not correct
		if (($postdata['objectName'] != 'qrLogin') || empty(urldecode($postdata['sessionid'])) || empty(urldecode($postdata['login'])) || empty(urldecode($postdata['password'])))
		{
			return new Response('', 400);
		}

		// set file names
		$fname_req = $this->get_file_name(urldecode($postdata['sessionid']));
		$fname_ans = $this->get_file_name($fname_req);
	
		// save login data to file req
		file_put_contents($fname_req, $post);

		// waiting for answer - max 50*100ms = 5s
		$t = 0;
		while ((!file_exists($fname_ans)) && ($t < 50))
		{
			$t++;
			usleep(100000);
		}

		// if file with data exists (((
		if (file_exists($fname_req))
		{
			$this->file_get_contents_and_delete($fname_req);
		}

		$ans = 403;
		// exists answer !
		if (file_exists($fname_ans))
		{
			$ans = $this->file_get_contents_and_delete($fname_ans);
		}
		return new Response('', $ans);
	}
}
