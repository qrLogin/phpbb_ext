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

	public function ajax()
	{
		// set file name
		$fn = "./cache/qrl_" . $this->user->session_id;
		// file not exists
		if (!file_exists($fn))
		{
			return new Response('', 400);
		}

		// get login data
		$logindata = preg_split("/=/", file_get_contents($fn));
		// delete file
		file_put_contents($fn, 0);
		unlink($fn);

		// set file name for answer
		$fn = $fn . 'ans';

		// set user for Session
		$username = $logindata[0];
		$password = $logindata[1];
		$autologin = false;
		// do Login user
		$login = $this->auth->login($username, $password, $autologin);

		$res = 403;
		if ((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $this->user->data['user_id'] != ANONYMOUS)
		{
			// set response to OK for refresh page in ajax
			$res = 200;
		}

		file_put_contents($fn, $res);
		return new Response('', $res);
	}

	public function post()
	{
		// get JSON from POST
		$postdata = json_decode(file_get_contents('php://input'), true);

		// if data not correct
		if ($postdata['objectName'] != 'qrLogin')
		{
			return new Response('', 400);
		}

		$sessionid = urldecode($postdata['sessionid']);
		$username = urldecode($postdata['login']);
		$password = urldecode($postdata['password']);

		// if data not correct
		if (empty($sessionid) or empty($username) or empty($password))
		{
			return new Response('', 400);
		}

		// save login to file with name 'qrl_sessionid'
		$fn = "./cache/qrl_" . $sessionid;
		file_put_contents($fn, $username . '=' . $password);

		// waiting for answer - max 50*100ms = 5s
		$fna = $fn . 'ans';
		$t = 0;
		while ((!file_exists($fna)) && ($t < 50))
		{
			$t++;
			usleep(100000);
		}

		// if file with data exists (((
		if (file_exists($fn))
		{
			file_put_contents($fn, 0);
			unlink($fn);
		}

		$ans = 403;
		// exists answer !
		if (file_exists($fna))
		{
			$ans = file_get_contents($fna);
			unlink($fna);
		}
		return new Response('', $ans);
	}
}
