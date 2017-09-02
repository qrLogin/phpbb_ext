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
	protected $config;
	protected $auth;
	protected $user;

	public function __construct(\phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\user $user)
	{
		$this->config = $config;
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
			if (!$shm_id = @shmop_open($key, "w", 0644, 0))
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

	function do_login_user( $keydata )
	{
		// get login data
		$logindata = json_decode($keydata, true);

		// do Login user
		$login = $this->auth->login(urldecode($logindata['login']), urldecode($logindata['password']), false);

		if ((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $this->user->data['user_id'] != ANONYMOUS)
		{
			// set response to OK for refresh page in ajax
			return 200;
		}
		// if error login - 403 Forbidden
		return 403;
	}

	public function ajax()
	{
		// set error in answer - default !!
		http_response_code(400);

		// set KEYs
		$key_req = $this->get_key($this->user->session_id);
		$key_ans = $this->get_key(hash('md5', $this->user->session_id));

		if ( extension_loaded( 'sysvmsg' ) )
		{
			if ( !msg_queue_exists ( $key_req ))
			{
				exit;
			}
			// create queue
			$queue = msg_get_queue($key_req);
			// read data
			if (!msg_receive ($queue, 1, $msg_type, 1024, $keydata, true, MSG_IPC_NOWAIT))
			{
				exit;
			}
			// error_log("keydata msg " . $keydata, 0);

			$res = $this->do_login_user($keydata);

			msg_send($queue, 2, $res);
		}
		else if ( extension_loaded( 'sysvshm' ) )
		{
			if (!$shm = shm_attach ( $this->get_key('qrlogin') ))
			{
				exit;
			}
			if ( !shm_has_var ( $shm , $key_req ))
			{
				exit;
			}
			// read data
			$keydata = shm_get_var ( $shm , $key_req );
			shm_remove_var ( $shm , $key_req );

			$res = $this->do_login_user($keydata);

			shm_put_var($shm, $key_ans, $res);
		}
		else if ( extension_loaded( 'shmop' ) )
		{
			// read key data
			if ( !$keydata = $this->read_key($key_req) )
			{
				exit;
			}
			// error_log("keydata shmob " . $keydata, 0);

			$res = $this->do_login_user($keydata);

			$this->write_key($key_ans, $res);
		}

		http_response_code($res);
		exit;
	}

	public function post()
	{
		// set error in answer - default !!
		http_response_code(400);

		// get JSON from POST
		$postdata = json_decode(file_get_contents('php://input'), true);

		// if data not correct
		if (($postdata['objectName'] != 'qrLogin') || empty($postdata['sessionid']) || empty($postdata['login']) || empty($postdata['password']))
		{
			exit;
		}

		// set KEYs
		$key_req = $this->get_key(urldecode($postdata['sessionid']));
		$key_ans = $this->get_key(hash('md5', urldecode($postdata['sessionid'])));

		// delete from JSON
		unset($postdata['objectName'], $postdata['sessionid']);
		$post_timeout = $this->config['qrlogin_post_timeout'];
		if (extension_loaded( 'sysvmsg' ))
		{
			// create queue
			$queue = msg_get_queue($key_req);
			// send login data
			if (!msg_send($queue, 1, json_encode($postdata)))
			{
				exit;
			}
			// waiting for answer - max qrlogin_post_timeout s
			while (!msg_receive ($queue, 2, $msg_type, 16, $ans, true, MSG_IPC_NOWAIT) && ($post_timeout > 0))
			{
				$post_timeout -= 0.1;
				usleep(100000);
			}
			// remove queue
			msg_remove_queue($queue);
		}
		else if ( extension_loaded( 'sysvshm' ) )
		{
			if (!$shm = shm_attach ( $this->get_key('qrlogin') ))
			{
				exit;
			}
			// save login data
			if (!shm_put_var($shm, $key_req, json_encode($postdata)))
			{
				exit;
			}
			// waiting for answer - max qrlogin_post_timeout s
			while ((!shm_has_var ( $shm , $key_ans )) && ($post_timeout > 0))
			{
				$post_timeout -= 0.1;
				usleep(100000);
			}
			// read answer
			if ( shm_has_var ( $shm , $key_ans ) )
			{
				$ans = shm_get_var ( $shm , $key_ans );
				shm_remove_var ( $shm , $key_ans );
			}
			// if key with data exists (((
			if ( shm_has_var ( $shm , $key_req ) )
			{
				shm_remove_var ( $shm , $key_req );
			}
		}
		else if (extension_loaded( 'shmop' ))
		{
			// save login data
			if ( !$this->write_key($key_req, json_encode($postdata)) )
			{
				exit;
			};
			// waiting for answer - max qrlogin_post_timeout s
			while ((!$ans = $this->read_key($key_ans)) && ($post_timeout > 0))
			{
				$post_timeout -= 0.1;
				usleep(100000);
			}
			// if key with data exists (((
			$this->read_key($key_req);
		}
		// if not exists answer ! 408 Request Timeout
		if (!$ans)
		{
			$ans = 408;
		}

		http_response_code($ans);
		exit;
	}
}
