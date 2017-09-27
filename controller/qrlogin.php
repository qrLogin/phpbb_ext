<?php
/**
*
* @package phpBB Extension - qrLogin
* @copyright (c) 2017 qrLogin - http://qrlogin.info
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
				shmop_delete($shm_id);
				shmop_close($shm_id);
				return $key_data;
			}
		}
		catch (Exception $e)
		{
			return;
		}
	}

	private function write_key($key, $data)
	{
		if (!$shm_id = shmop_open($key, "c", 0644, strlen($data)))
		{
			return false;
		}
		if (shmop_write($shm_id, $data, 0) != strlen($data))
		{
			shmop_delete($shm_id);
			shmop_close($shm_id);
			return false;
		}
		shmop_close($shm_id);
		return true;
	}

	private function file_get_contents_and_delete($key)
	{
		$fname = $key;
		if (!file_exists($fname))
		{
			return;
		};
		$content = file_get_contents($fname);
		file_put_contents($fname, 0);
		unlink($fname);
		return $content;
	}

	function set_login_user($keydata)
	{
		// Session creation
		if ($this->user->session_create($keydata, false, false, true)) 
		{
			// set response to OK
			return 200;
		}
		// if error Session creation - 403 Forbidden
		return 403;
	}

	function response_ajax($res)
	{
		if ($res == 200)
		{
			return new Response('1', 200);
		}
		return new Response('', 200);
	}

	public function ajax()
	{
		// set KEYs
		$key_req = $this->get_key($this->user->session_id);
		$key_ans = $this->get_key(hash('md5', $this->user->session_id));

		$poll_lifetime = $this->config['qrlogin_poll_lifetime'];
		do
		{
			if ( extension_loaded( 'sysvmsg' ))
			{
				if ( msg_queue_exists ( $key_req ))
				{
					// create queue
					$queue = msg_get_queue( $key_req );
					// read data
					if (msg_receive( $queue, 1, $msg_type, 1024, $keydata, true, MSG_IPC_NOWAIT))
					{
						$res = $this->set_login_user( $keydata );

						msg_send( $queue, 2, $res );

						return $this->response_ajax($res);
					}
				}
			}
			else if ( extension_loaded( 'sysvshm' ))
			{
				if ($shm = shm_attach ( $this->get_key( 'qrlogin' )))
				{
					if ( shm_has_var ( $shm , $key_req ))
					{
						// read data
						$keydata = shm_get_var ( $shm , $key_req );
						shm_remove_var ( $shm , $key_req );

						$res = $this->set_login_user($keydata);

						shm_put_var($shm, $key_ans, $res);

						return $this->response_ajax($res);
					}
				}            
			}
			else if ( extension_loaded( 'shmop' ))
			{
				// read key data
				if ($keydata = $this->read_key($key_req))
				{
					$res = $this->set_login_user($keydata);

					$this->write_key($key_ans, $res);

					return $this->response_ajax($res);
				}
			}
			else
			{
				// read key data
				if ($keydata = $this->file_get_contents_and_delete($key_req))
				{
					$res = $this->set_login_user($keydata);

					file_put_contents($key_ans, $res);

					return $this->response_ajax($res);
				}
			}

			if (--$poll_lifetime < 0)
			{
				return new Response('', 200);
			}
			sleep(1);
			if (connection_aborted())
			{
				return new Response('', 200);
			}
		}
		while (true);
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

		// do Login user
		$login = $this->auth->login(urldecode($postdata['login']), urldecode($postdata['password']), false);

		if (empty($login) || $login['status'] != LOGIN_SUCCESS || $this->user->data['user_id'] == ANONYMOUS)
		{
			// if error login - 403 Forbidden
			return new Response('', 403);
		}

		$keydata = $this->user->data['user_id'];

		// set KEYs
		$key_req = $this->get_key(urldecode($postdata['sessionid']));
		$key_ans = $this->get_key(hash('md5', urldecode($postdata['sessionid'])));

		// if not answer - 408 Request Timeout
		$ans = 408;
		$post_timeout = $this->config['qrlogin_post_timeout'];
		if (extension_loaded( 'sysvmsg' ))
		{
			// create queue
			$queue = msg_get_queue($key_req);
			// send login data
			if (!msg_send($queue, 1, $keydata))
			{
				return new Response('', 400);
			}
			// waiting for answer - max qrlogin_post_timeout s
			while (!msg_receive ($queue, 2, $msg_type, 16, $ans, true, MSG_IPC_NOWAIT) && ($post_timeout-- > 0))
			{
				sleep(1);
			}
			// remove queue
			msg_remove_queue($queue);
		}
		else if ( extension_loaded( 'sysvshm' ))
		{
			if (!$shm = shm_attach ( $this->get_key('qrlogin') ))
			{
				return new Response('', 400);
			}
			// save login data
			if (!shm_put_var($shm, $key_req, $keydata))
			{
				return new Response('', 400);
			}
			// waiting for answer - max qrlogin_post_timeout s
			while ((!shm_has_var ( $shm , $key_ans )) && ($post_timeout-- > 0))
			{
				sleep(1);
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
			if ( !$this->write_key($key_req, $keydata) )
			{
				return new Response('', 400);
			};
			// waiting for answer - max qrlogin_post_timeout s
			while ((!$ans = $this->read_key($key_ans)) && ($post_timeout-- > 0))
			{
				sleep(1);
			}
			// if key with data exists (((
			$this->read_key($key_req);
		}
		else
		{
			// save login data
			file_put_contents($key_req, $keydata);
			// waiting for answer - max qrlogin_post_timeout s
			while ((!$ans = $this->file_get_contents_and_delete($key_ans)) && ($post_timeout-- > 0))
			{
				sleep(1);
			}
			// if key with data exists (((
			$this->file_get_contents_and_delete($key_req);
		}

		return new Response('', $ans);
	}
}
