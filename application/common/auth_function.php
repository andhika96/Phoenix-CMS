<?php

/*
 *  Aruna Development Project
 *  IS NOT FREE SOFTWARE
 *  Codename: Ardev Phoenix
 *	Website: https://www.aruna-dev.com
 *	Build Year: February 2024
 *  Created and developed by Andhika Adhitia N
 */

defined('APPPATH') OR exit('No direct script access allowed');

class Aruna_Auth_Function
{
	protected $table_prefix = 'ml_';

	protected $config_site;

	protected $extension = [];

	protected $exclude_url_to_login = ['/auth/login', '/auth/signup', '/auth/logout', '/auth/forgotpassword', 'auth/recoveryaccount'];

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();

		$this->extension = load_ext('url');

		$this->config_site = config_site_function();
	}

	public function do_auth()
	{
		if ( ! empty($this->check_login_session('id')) && 
			 ! empty($this->check_login_session('username')) && 
			 ! empty($this->check_login_session('token')))
		{
			if ($this->config_site->get_config_multiple_device() == FALSE && 
				$this->check_token($this->check_login_session('id'), $this->check_login_session('username')) == FALSE)
			{
				// Unset session id
				$this->unset_user_session('id');

				// Unset session username
				$this->unset_user_session('username');

				// Unset session token
				$this->unset_user_session('token');

				// if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != 'auth/login')
				// {
				// 	// Set temporary session redirect_to only exist 5 minutes
				// 	$this->session->set_tempdata('redirect_to', urlencode(site_url(ltrim($_SERVER['REQUEST_URI'], '/'))), 300);

				// 	// Redirect to login page
				// 	redirect('auth/login?redirect_to='.urlencode(site_url(ltrim($_SERVER['REQUEST_URI'], '/'))));
				// }
				// elseif ($_SERVER['REQUEST_URI'] != 'auth/login')
				// {
				// 	// Redirect to login page
				// 	redirect('auth/login');
				// }	

				if ( ! in_array($_SERVER['REQUEST_URI'], $this->exclude_url_to_login))		
				{
					// Set temporary session redirect_to only exist 5 minutes
					$this->Aruna->session->set_tempdata('redirect_to', ltrim($_SERVER['REQUEST_URI'], '/'), 300);

					if ( ! $this->Aruna->input->is_ajax_request())
					{
						// Redirect to login page
						redirect('auth/login');

						// redirect('auth/login?redirect_to='.urlencode(site_url(ltrim($_SERVER['REQUEST_URI'], '/'))));
					}
					else
					{
						echo json_encode(['status' => 'failed', 'popup_notice' => TRUE, 'message' => 'Sorry, you cannot continue the action, because you have logged out, please log in again to continue the action', 'url' => site_url('auth/login')]);
						exit;
					}
				}
			}
			else
			{
				// Unset session redirect_to after login
				$this->Aruna->session->unset_userdata('redirect_to');
			}
		}
		else
		{
			if ( ! in_array($_SERVER['REQUEST_URI'], $this->exclude_url_to_login))
			{
				// Set temporary session redirect_to only exist 5 minutes
				$this->Aruna->session->set_tempdata('redirect_to', ltrim($_SERVER['REQUEST_URI'], '/'), 300);

				if ( ! $this->Aruna->input->is_ajax_request())
				{
					// Redirect to login page
					redirect('auth/login');

					// redirect('auth/login?redirect_to='.urlencode(site_url(ltrim($_SERVER['REQUEST_URI'], '/'))));
				}
				else
				{
					echo json_encode(['status' => 'failed', 'popup_notice' => TRUE, 'message' => 'Sorry, you cannot continue the action, because you have logged out, please log in again to continue the action', 'url' => site_url('auth/login')]);
					exit;
				}
			}
		}
	}

	public function has_auth(string $default_url_redirect_after_login = 'dashboard', string $default_url_redirect_to_login = 'auth/login')
	{
		if ( ! empty($this->check_login_session('id')) && 
			 ! empty($this->check_login_session('username')) && 
			 ! empty($this->check_login_session('token')))
		{
			// Redirect to destination page after login
			redirect($default_url_redirect_after_login);
		}
		elseif ( ! in_array($_SERVER['REQUEST_URI'], $this->exclude_url_to_login))
		{
			// Redirect to login page
			redirect($default_url_redirect_to_login);
		}
	}

	public function check_token(int $userid = 0, string $username = '')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT id, username, token FROM ".$this->table_prefix."accounts WHERE id = :id AND username = :username");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $userid, 'username' => $username], $res);
		$row = $this->Aruna->db->sql_fetch_single($bindParam);

		if ($row['token'] == $this->check_login_session('token'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function check_login_session(string $session_key)
	{
		$get_session['id'] 			= isset($_SESSION['id']) ? $_SESSION['id'] : 0;
		$get_session['username'] 	= isset($_SESSION['username']) ? $_SESSION['username'] : '';
		$get_session['token'] 		= isset($_SESSION['token']) ? $_SESSION['token'] : '';

		$get_session[$session_key] 	= isset($get_session[$session_key]) ? $get_session[$session_key] : '';

		return $get_session[$session_key];
	}

	public function unset_user_session(string $session_key)
	{
		if (isset($_SESSION[$session_key]))
		{
			unset($_SESSION[$session_key]);
		}
	}
}

?>