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
	protected $db;
	protected $qrlogin_table;

	public function __construct(\phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $qrlogin_table)
	{
		$this->config = $config;
		$this->auth = $auth;
		$this->user = $user;
		$this->db = $db;
		$this->qrlogin_table = $qrlogin_table;
	}

	function get_field_session($field, $sql_where)
	{
		$sql	 = 'SELECT ' . $field . ' FROM ' . $this->qrlogin_table . $sql_where;
		$result	 = $this->db->sql_query($sql);
		$row	 = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row[$field];
	}

	public function ajax()
	{
		$sid = md5('qrlogin' . $this->user->session_id);
		$sql_where = ' WHERE ' . $this->db->sql_build_array('SELECT', ['sid' => $sid]);

		$poll_lifetime = $this->config['qrlogin_poll_lifetime'];

		// waiting for login - max $poll_lifetime s
		while (!$uid = $this->get_field_session('uid', $sql_where))
		{
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

		// received uid for login - Session creation
		$res = $this->user->session_create($uid, false, false, true);

		// set login status for qrLogin post to 200 or 403 - Forbidden
		$sql = 'UPDATE ' . $this->qrlogin_table . ' SET ' . $this->db->sql_build_array('UPDATE', ['result' => ($res ? 200 : 403)]) . $sql_where;
		$this->db->sql_query($sql);

		// answer to ajax with '1' for reload page if OK
		return new Response($res ? '1' : '', 200);
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

		// if error login - 403 Forbidden
		if (empty($login) || $login['status'] != LOGIN_SUCCESS || $this->user->data['user_id'] == ANONYMOUS)
		{
			return new Response('', 403);
		}

		$sid = md5('qrlogin' . urldecode($postdata['sessionid']));
		$sql_where = ' WHERE ' . $this->db->sql_build_array('SELECT', ['sid' => $sid]);
		$sql_del = 'DELETE FROM ' . $this->qrlogin_table . $sql_where;
		$sql_ins = 'INSERT INTO ' . $this->qrlogin_table . ' ' . $this->db->sql_build_array('INSERT', ['sid' => $sid, 'uid' => $this->user->data['user_id']]);

		// remove queue from db
		$this->db->sql_query($sql_del);

		// insert queue into db
		$this->db->sql_query($sql_ins);

		// waiting for answer - max qrlogin_post_timeout s
		$post_timeout = $this->config['qrlogin_post_timeout'];
		while ((!$ans = $this->get_field_session('result', $sql_where)) && ($post_timeout-- > 0))
		{
			sleep(1);
		}

		// if not exists answer ! 408 Request Timeout
		$ans = $ans ? $ans : 408;

		// remove queue from db
		$this->db->sql_query($sql_del);

		return new Response('', $ans);
	}
}
