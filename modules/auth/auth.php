<?php

	/*
	 *	Aruna Development Project
	 *	IS NOT FREE SOFTWARE
	 *	Codename: Aruna Personal Site
	 *	Source: Based on Sosiaku Social Networking Software
	 *	Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *	Created and developed by Andhika Adhitia N
	 */

defined('MODULEPATH') OR exit('No direct script access allowed');

class auth extends Aruna_Controller
{
	protected $csrf;

	protected $auth_function;
	
	public function __construct() 
	{
		parent::__construct();

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->auth_function = auth_function();
	}

	public function index()
	{
		redirect('auth/login');
	}

	public function login()
	{
		$this->auth_function->has_auth();

		load_extend_view('default', ['header_auth_page', 'footer_auth_page']);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{				
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{				
				$res = $this->db->sql_prepare("select id, username, password from ml_accounts where email = :email limit 1");
				$bindParam = $this->db->sql_bindParam(['email' => $this->input->post('email')], $res);
				$row = $this->db->sql_fetch_single($bindParam);

				$get_password = isset($row['password']) ? $row['password'] : '';

				if (password_verify($this->input->post('password'), $get_password))
				{
					$generate_token = random_string('alnum', 32);
					$set_session = ['id' => $row['id'], 'username' => $row['username'], 'token' => $generate_token];

					$this->session->set_userdata($set_session);
					$this->db->sql_update(['token' => $generate_token], 'ml_accounts', ['id' => $row['id']]);

					$auto_redirect_link = $this->session->userdata('redirect_to') ? site_url($this->session->userdata('redirect_to')) : site_url('dashboard');

					echo json_encode(['status' => 'success', 'url' => $auto_redirect_link]);
					exit;
				}
				else
				{
					echo json_encode(['status' => 'failed', 'message' => 'The email address or password you entered is incorrect, please try again']);
					exit;
				}
			}
		}

		$data['session']	= $this->session;
		$data['csrf_name'] 	= $this->csrf['name'];
		$data['csrf_hash'] 	= $this->csrf['hash'];

		return view('login', $data);
	}

	public function logout()
	{
		load_extend_view('default', ['header_auth_page', 'footer_auth_page']);

		if ($this->session->userdata('id') && $this->session->userdata('username') && $this->session->userdata('token'))
		{
			$this->db->sql_update(['token' => ''], 'ml_accounts', ['id' => $this->session->userdata('id')]);
			$this->session->unset_userdata(['id', 'client_id', 'username', 'token']);
			
			redirect('auth/login');
		}

		if ( ! $this->session->userdata('id') && ! $this->session->userdata('client_id') && ! $this->session->userdata('username') && ! $this->session->userdata('token'))
		{
			redirect('auth/login');
		}
	}

	public function forgotpassword()
	{
		$this->auth_function->has_auth();

		load_extend_view('default', ['header_auth_page', 'footer_auth_page']);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$res_email = $this->db->sql_prepare("select id, email from ml_accounts where email = :email");
				$bindParam_email = $this->db->sql_bindParam(['email' => $this->input->post('email')], $res_email);
				$row_email = $this->db->sql_fetch_single($bindParam_email);

				if ( ! $this->db->sql_counts($bindParam_email))
				{
					echo json_encode(['status' => 'failed', 'message' => 'Email not found in any account']);
					exit;
				}
				else
				{
					$res_smtp = $this->db->sql_prepare("select * from ml_smtp where id = :id");
					$bindParam_smtp = $this->db->sql_bindParam(['id' => 1], $res_smtp);
					$row_smtp = $this->db->sql_fetch_single($bindParam_smtp);

					$config['protocol']		= 'smtp';
					$config['smtp_host']	= $row_smtp['smtp_host'];
					$config['smtp_user']	= $row_smtp['smtp_user'];
					$config['smtp_pass']	= $row_smtp['smtp_pass'];
					$config['smtp_port']	= $row_smtp['smtp_port'];
					$config['mailtype']		= 'html';
					$config['charset']		= 'utf-8';
					$config['priority']		= 1;
					$config['wordwrap']		= true;

					$this->email->initialize($config);

					$get_main_url = explode(".", $_SERVER['HTTP_HOST']);
					$from_email = ($get_main_url[1] == 'localhost') ? 'aruna-dev.com' : 'aruna-dev.com';

					// Generate random and duration code
					$get_random_code = random_string('alnum', 14);
					$get_duration_code = time()+60*5; // Set duration for 5 minutes

					// Update recovery code
					$this->db->sql_update(['recovery_code' => $get_random_code, 'recovery_code_duration' => $get_duration_code], 'ml_accounts', ['id' => $row_email['id']]);

					// Start to send email with SMTP Servive
					$this->email->from('noreply@'.$from_email, get_csite('site_name'));
					$this->email->to($this->input->post('email'));
					$this->email->subject('Recovery Account');
					$this->email->message('Click the link below to reset your password, and your password will expire in 5 minutes, after 5 minutes you will not be able to access the link <br/><br/> '.site_url('auth/recoveryaccount?code='.$get_random_code));
					$this->email->send();

					// echo json_encode(['status' => 'fail', 'message' => 'You cannot use this feature, because this feature is still in development mode']);
					echo json_encode(['status' => 'success', 'message' => 'The password reset link has been sent to your email, please check your inbox or email spam folder']);
					exit;
				}
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('forgotpassword', $data);
	}

	public function recoveryaccount()
	{
		$this->auth_function->has_auth();

		load_extend_view('default', ['header_auth_page', 'footer_auth_page']);

		$res = $this->db->sql_prepare("select * from ml_accounts where recovery_code = :recovery_code");
		$bindParam = $this->db->sql_bindParam(['recovery_code' => $this->input->get('code')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$recovery_code = isset($row['recovery_code']) ? $row['recovery_code'] : '';
	
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required|min_length[8]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				$error = NULL;

				$res_duration2 = $this->db->sql_prepare("select id from ml_accounts where recovery_code_duration < ".time()." and recovery_code = :recovery_code limit 1");
				$bindParam_duration2 = $this->db->sql_bindParam(['recovery_code' => $this->input->get('code')], $res_duration2);

				if ($this->db->sql_counts($bindParam_duration2))
				{
					$error = 'Your code for reset password is expired';
				}

				if ($this->input->post('password') != $this->input->post('password_conf'))
				{
					$error = 'The confirmation password does not match the new password';
				}

				if ( ! strlen((string) $error))
				{
					// Hashing password for security reason
					$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

					$update_password = ['password' => $password];

					$this->db->sql_update($update_password, 'ml_accounts', ['id' => $row['id']]);
					
					$this->db->sql_update(['recovery_code' => '', 'recovery_code_duration' => ''], 'ml_accounts', ['id' => $row['id']]);

					echo json_encode(['status' => 'success', 'url' => site_url('auth/login')]);
					exit;
				}
				else
				{
					echo json_encode(['status' => 'failed', 'message' => $error]);
					exit;
				}
			}
		}

		$res_duration = $this->db->sql_prepare("select id from ml_accounts where recovery_code_duration < ".time()." and recovery_code = :recovery_code limit 1");
		$bindParam_duration = $this->db->sql_bindParam(['recovery_code' => $this->input->get('code')], $res_duration);

		if ( ! $recovery_code)
		{
			$get_status_code = 2;
		}
		elseif ($this->db->sql_counts($bindParam_duration)) 
		{
			$get_status_code = 1;
			
			$this->db->sql_update(['recovery_code' => '', 'recovery_code_duration' => ''], 'ml_accounts', ['id' => $row['id']]);
		}
		else
		{
			$get_status_code = 0;
		}

		$data['get_status_code'] = $get_status_code;
		$data['input']	   = $this->input;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('recoveryaccount', $data);
	}

	public function signup()
	{
		$this->auth_function->has_auth();

		load_extend_view('default', ['header_auth_page', 'footer_auth_page']);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|valid_email|is_unique[default.ml_accounts.email]',
								['is_unique' => 'This %s already exists.']);
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[16]|alpha_dash|is_unique[default.ml_accounts.username]',
								['is_unique' => 'This %s already exists.']);

		$this->form_validation->set_rules('fullname', 'Fullname', 'required|min_length[4]|max_length[34]|regex_match[/^[A-Za-z0-9 ]+$/]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('agreecheck', 'TOS', 'required', 
								['required' => 'Please agree with our TOS if you want to signup']);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->error_array()]);
				exit;
			}
			else
			{
				// Hashing password for security reason
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
				// Get data from POST inserted to array
				$data = [
					'uuid'		=> $this->uuid->v4(),
					'email'		=> $this->input->post('email'),
					'username'	=> $this->input->post('username'),
					'fullname'	=> $this->input->post('fullname'),
					'password'	=> $password,
					'status'	=> 1,
					'roles'		=> 1,
					'role_code'	=> 'general_member',
					'created'	=> time()
				];

				// Insert data to database
				$this->db->sql_insert($data, 'ml_accounts');
				
				// Get Last ID
				$id = $this->db->insert_id();

				// Get the first ID to be an admin account when not registered when installing CMS.
				if ($id == 1)
				{
					$update_data = ['roles' => 99, 'role_code' => 'administrator'];
					$this->db->sql_update($update_data, 'ml_accounts', ['id' => $id]);
				}

				// Create user information
				$create_user_info = ['user_id' => $id];
				$this->db->sql_insert($create_user_info, 'ml_user_information');

				// Automaticaly login to dashboard afte successfuly signup
				$res = $this->db->sql_prepare("select id, username from ml_accounts where id = :id");
				$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
				$row = $this->db->sql_fetch_single($bindParam);

				$generate_token = random_string('alnum', 32);
				$set_session	= ['id' => $row['id'], 'client_id' => 0, 'username' => $row['username'], 'token' => $generate_token];

				$this->session->set_userdata($set_session);
				$this->db->sql_update(['token' => $generate_token], 'ml_accounts', ['id' => $row['id']]);

				echo json_encode(['status' => 'success', 'url' => base_url('dashboard')]);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		$data['checkbox']  = $this->form_validation->set_checkbox('remember_me', '1');

		return view('signup', $data);
	}
}

?>