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

class account extends Aruna_Controller
{
	protected $csrf;

	protected $offset;

	protected $num_per_page;
	
	public function __construct() 
	{
		parent::__construct();

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		// Create variable array CSRF to get CSRF token name and CSRF Hash
		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('Account');

		// Register file JS
		register_js([
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha256-Kg2zTcFO9LXOc7IwcBx1YeUBJmekycsnTsq2RuFHSZU=" crossorigin="anonymous"></script>',
			'<script>$(document).ready(function() { $(".placeholder_date").mask("00/00/0000", {placeholder: "__/__/____"}); $(".placeholder_phone_number").mask("0000-0000-0000", {"translation": {0: {pattern: /[0-9*]/}}}); });</script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select a.*, a.id as uid, ui.* from ml_accounts as a left join ml_user_information as ui on ui.user_id = a.id where a.id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $this->session->userdata('id')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$selected_0 = $row['gender'] == 0 ? 'selected' : '';
		$selected_1 = $row['gender'] == 1 ? 'selected' : '';
		$selected_2 = $row['gender'] == 2 ? 'selected' : '';

		$this->form_validation->set_rules('fullname', 'Fullname', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');
		$this->form_validation->set_rules('gender', 'Gender', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				$update_account = [
					'fullname' 	=> $this->input->post('fullname')
				];

				$update_user_information = [
					'birthdate'		=> $this->input->post('birthdate'),
					'gender'		=> $this->input->post('gender'),
					'phone_number'	=> $this->input->post('phone_number'),
					'about'			=> $this->input->post('about')
				];

				$this->db->sql_update($update_account, 'ml_accounts', ['id' => $row['uid']]);
				$this->db->sql_update($update_user_information, 'ml_user_information', ['user_id' => $row['uid']]);

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
		}

		$data['row'] = $row;
		$data['selected_0'] = $selected_0;
		$data['selected_1'] = $selected_1;
		$data['selected_2'] = $selected_2;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('index', $data);		
	}

	public function password()
	{
		set_title('Password');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select id, password from ml_accounts where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $this->session->userdata('id')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required|min_length[8]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				$error = NULL;

				if ( ! password_verify($this->input->post('old_password'), $row['password']))
				{
					$error = 'The old password you entered is incorrect';
				}

				if ($this->input->post('new_password') != $this->input->post('password_conf'))
				{
					$error = 'The confirmation password does not match the new password';
				}

				if ( ! strlen($error))
				{
					// Hashing password for security reason
					$password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);

					$update_password = ['password'	=> $password];

					$this->db->sql_update($update_password, 'ml_accounts', ['id' => $row['id']]);

					echo json_encode(['status' => 'success', 'msg' => 'Success']);
					exit;
				}
				else
				{
					echo json_encode(['status' => 'failed', 'msg' => $error]);
					exit;
				}
			}
		}

		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('password', $data);
	}

	public function avatar()
	{
		set_title('Avatar');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select user_id, avatar from ml_user_information where user_id = :user_id");
		$bindParam = $this->db->sql_bindParam(['user_id' => $this->session->userdata('id')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			$data = $this->input->post('avatar', false);

			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);

 			$temp_file_path = tempnam(sys_get_temp_dir(), 'contents'); // might not work on some systems, specify your temp path if system temp dir is not writeable
 			file_put_contents($temp_file_path, base64_decode($data));
 			$image_info = getimagesize($temp_file_path);
			
			$initExtFile = $_FILES['userfile']['name'];
			$getExtFile = substr($initExtFile, strrpos($initExtFile, '.')+1);

			$_FILES['avatar']['name']		= uniqid().'.'.$getExtFile;
			$_FILES['avatar']['tmp_name']	= $temp_file_path;
			$_FILES['avatar']['size']		= filesize($temp_file_path);
			$_FILES['avatar']['type']		= $_FILES['userfile']['type'];

			$dir = date("Ym", time());
			$s_folder = './contents/userfiles/avatars/'.$dir.'/';

			// For database only without dot and slash at the front folder
			$x_folder = 'contents/userfiles/avatars/'.$dir.'/';

			if ( ! is_dir($s_folder)) 
			{
				mkdir($s_folder, 0777);
			}
			
			$config['upload_path']		= $s_folder;
			$config['allowed_types']	= 'jpg|jpeg|png';
			$config['overwrite']		= TRUE;
			$config['remove_spaces']	= TRUE;
			$config['encrypt_name']		= TRUE;
			$config['max_size']			= 8000;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('avatar', TRUE))
			{
				$error = array('error' => $this->upload->display_errors('<span>', '</span>'));

				foreach ($error as $key => $value) 
				{
					$errors = $value;
				}

				echo json_encode(['status' => 'failed', 'msg' => $errors.$_FILES['userfile']['type']]);
				exit;
			}
			else
			{
				if ($row['avatar'] || file_exists($row['avatar']))
				{
					unlink($row['avatar']);
				}

				$data = ['avatar' => $x_folder.$this->upload->data('file_name')];
				$this->db->sql_update($data, 'ml_user_information', ['user_id' => $row['user_id']]);

				echo json_encode(['status' => 'success', 'msg' => 'Success', 'getImg' => base_url($x_folder.$this->upload->data('file_name'))]);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('avatar', $data);
	}
}

?>