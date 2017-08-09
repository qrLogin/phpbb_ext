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

	private function get_key($data)
	{
		return hexdec(hash("crc32", 'qrlogin' . $data));
	}

	private function read_key($key)
	{
		try
		{
			if (!$shm_id = shmop_open($key, "w", 0644, 0))
			{
				return;
			}
			else
			{
				$key_data = shmop_read($shm_id, 0, shmop_size($shm_id));
				if (!shmop_delete($shm_id))
				{
					error_log("can`t delete SHMOD.", 0);
				}
				shmop_close($shm_id);
				return $key_data;
			}
		}
		catch (Exception $e)
		{
			error_log('Exception SHMOD read_key: ' . $e->getMessage(), 0);
			return;
		}
	}

	private function write_key($key, $data)
	{
		if (!$shm_id = shmop_open($key, "c", 0644, strlen($data)))
		{
			error_log("key not available! " . $key, 0);
			return false;
		}

		if (shmop_write($shm_id, $data, 0) != strlen($data))
		{
			error_log("Can`t write all data", 0);
			shmop_delete($shm_id);
			shmop_close($shm_id);
			return false;
		}

		shmop_close($shm_id);
		return true;
	}

	public function ajax()
	{
		// set KEYs
		$key_req = $this->get_key($this->user->session_id);
		$key_ans = $this->get_key(hash('md5', $this->user->session_id));

		// read key data
		if (!$keydata = $this->read_key($key_req))
		{
			// key not exists
			return new Response('', 400);
		}

		// get login data
		$logindata = json_decode($keydata, true);

		// do Login user
		$login = $this->auth->login(urldecode($logindata['login']), urldecode($logindata['password']), false);

		$res = 403;
		if ((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $this->user->data['user_id'] != ANONYMOUS)
		{
			// set response to OK for refresh page in ajax
			$res = 200;
		}

		$this->write_key($key_ans, $res);
		return new Response('', $res);
	}

	public function post()
	{
		// get JSON from POST
		$postdata = json_decode(file_get_contents('php://input'), true);

		// if data not correct
		if (($postdata['objectName'] != 'qrLogin') || empty($postdata['sessionid']) || empty($postdata['login']) || empty($postdata['password']))
		{
			return new Response('', 400);
		}

		// set KEYs
		$key_req = $this->get_key(urldecode($postdata['sessionid']));
		$key_ans = $this->get_key(hash('md5', urldecode($postdata['sessionid'])));

		// delete from JSON
		unset($postdata['objectName'], $postdata['sessionid']);

		// save login data to file req
		if (!$this->write_key($key_req, json_encode($postdata)))
		{
			return new Response('', 400);
		};

		// waiting for answer - max 50*100ms = 5s
		$t = 0;
		while ((!($ans = $this->read_key($key_ans))) && ($t < 50))
		{
			$t++;
			usleep(100000);
		}
		// if not exists answer !
		if (!$ans)
		{
			$ans = 403;
		}

		// if key with data exists (((
		$this->read_key($key_req);

		return new Response('', $ans);
	}
}
