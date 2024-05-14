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

class manage_dropdown extends Aruna_Controller
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

		page_function()->check_active_page();

		page_function()->check_access_page();

		auth_function()->do_auth();
	}

	public function index()
	{
		set_title('List of Dropdown Menu');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('dropdown_type', 'Dropdown Type', 'required');
		$this->form_validation->set_rules('page_name', 'Page', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$res = $this->db->sql_prepare("select * from ml_dropdown_parent where page_id = :page_id");
				$bindParam = $this->db->sql_bindParam(['page_id' => $this->input->post('page_id')], $res);
				$row = $this->db->sql_fetch_single($bindParam);
				
				if ( ! $this->db->sql_counts($bindParam))
				{
					$get_page_name = str_replace(" ", "", strtolower($this->input->post('page_name')));
					$get_page_name = str_replace("&", "", $get_page_name);
					$get_page_name = str_replace("/", "", $get_page_name);

					$data_dropdown_parent = [
						'page_id' 		=> $this->input->post('page_id'),
						'dropdown_type' => $this->input->post('dropdown_type'),
						'page_id' 		=> 0,
						'page_name' 	=> $get_page_name,
						// 'page_name' 	=> $this->_getDetailPage($this->input->post('page_id'), 'name')
					];

					$this->db->sql_insert($data_dropdown_parent, 'ml_dropdown_parent');

					$getLatestID = $this->db->insert_id();

					$data_dropdown_menu = [
						'dropdown_id' 		=> $getLatestID,
						'menu_vars' 		=> '[]'
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}
				else
				{
					echo json_encode(['status' => 'failed', 'message' => $this->_getDetailPage($this->input->post('page_id'), 'name').' already added']);
					exit;
				}

				echo json_encode(['status' => 'success', 'message' => 'Success']);
				exit;
			}
		}

		$data['menus'] = $this->_getListMenus();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('index', $data);
	}

	public function addpost()
	{
		set_title('Add Dropdown');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('dropdown_type', 'Dropdown Type', 'required');
		$this->form_validation->set_rules('page_id', 'Page', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$res = $this->db->sql_prepare("select * from ml_dropdown_parent where page_id = :page_id");
				$bindParam = $this->db->sql_bindParam(['page_id' => $this->input->post('page_id')], $res);
				$row = $this->db->sql_fetch_single($bindParam);
				
				if ( ! $this->db->sql_counts($bindParam))
				{
					$data_dropdown_parent = [
						'page_id' 		=> $this->input->post('page_id'),
						'dropdown_type' => $this->input->post('dropdown_type'),
						'page_name' 	=> $this->_getDetailPage($this->input->post('page_id'), 'name')
					];

					$this->db->sql_insert($data_dropdown_parent, 'ml_dropdown_parent');

					$getLatestID = $this->db->insert_id();

					$data_dropdown_menu = [
						'dropdown_id' 		=> $getLatestID,
						'menu_vars' 		=> ''
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}
				else
				{
					echo json_encode(['status' => 'failed', 'message' => $this->_getDetailPage($this->input->post('page_id'), 'name').' already added']);
					exit;
				}

				echo json_encode(['status' => 'success', 'url' => site_url('manage_dropdown/editpost/'.$getLatestID)]);
				exit;
			}
		}

		$data['menus'] = $this->_getListMenus();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('addpost', $data);
	}

	public function editpost($id)
	{
		set_title('Edit Dropdown');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_dropdown_parent where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$res_menu = $this->db->sql_prepare("select * from ml_dropdown_menu where dropdown_id = :dropdown_id");
		$bindParam_menu = $this->db->sql_bindParam(['dropdown_id' => $row['id']], $res_menu);
		$row_menu = $this->db->sql_fetch_single($bindParam_menu);

		$get_vars = json_decode($row_menu['menu_vars'], true);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{						
			$is_upload 	= 0;
			$get_total1 = count(json_decode($this->input->post('menu_vars'), true));
			
			if ( ! empty($row_menu['menu_vars']))
			{
				$get_total2 = count(json_decode($row_menu['menu_vars'], true));
			}
			else
			{
				$get_total2 = 0;
			}

			if ($get_total1 > $get_total2)
			{
				$get_vars = json_decode($this->input->post('menu_vars'), true);
			}
			elseif ($get_total1 == $get_total2)
			{
				$get_vars = json_decode($row_menu['menu_vars'], true);
			}
			else
			{
				$get_vars = json_decode($this->input->post('menu_vars'), true);
			}

			for ($i = 0; $i < $get_total1; $i++) 
			{ 
				if ( ! empty($_FILES['menu_icon_'.$i]['name']))
				{
					// Image For Menu Icon
					$_FILES['menu_icon_file']['name'] 		= $_FILES['menu_icon_'.$i]['name'];
					$_FILES['menu_icon_file']['type'] 		= $_FILES['menu_icon_'.$i]['type'];
					$_FILES['menu_icon_file']['tmp_name'] 	= $_FILES['menu_icon_'.$i]['tmp_name'];
					$_FILES['menu_icon_file']['error'] 		= $_FILES['menu_icon_'.$i]['error'];
					$_FILES['menu_icon_file']['size'] 		= $_FILES['menu_icon_'.$i]['size'];

					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/menu_icon/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/menu_icon/'.$dir.'/';

					if ( ! is_dir($s_folder)) 
					{
						mkdir($s_folder, 0777);
					}

					$configs['upload_path']		= $s_folder;
					$configs['allowed_types']	= 'jpg|jpeg|png|gif|svg';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 2000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('menu_icon_file'))
					{
						if ($_FILES['menu_icon_file']['error'] != 4)
						{
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$get_vars[$i]['menu_icon'] = false;
					}
					else 
					{
						if ( ! empty($get_vars[$i]['menu_icon']) && file_exists($get_vars[$i]['menu_icon']))
						{
							unlink($get_vars[$i]['menu_icon']);
						}

						$get_vars[$i]['menu_icon'] = $x_folder.$upload->data('file_name');
					}

					$is_upload = 1;
				}
			}

			if ($is_upload == 0)
			{
				$init_value = $this->input->post('menu_vars');
			}
			else
			{
				$init_value = ($get_total1 > $get_total2) ? json_encode($get_vars) : (($get_total1 == $get_total2) ? json_encode($get_vars) : $this->input->post('menu_vars'));
			}

			$data_dropdown_menu = [
				'dropdown_id' 		=> $row['id'],
				'menu_vars'			=> $init_value
			];

			$this->db->sql_update($data_dropdown_menu, 'ml_dropdown_menu', ['id' => $row_menu['id']]);

			echo json_encode(['status' => 'success', 'message' => 'Success']);
			exit;
		}

		$data['id']		= $id;
		$data['menus'] 	= $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editpost', $data);
	}

	public function getListPages()
	{
		$res = $this->db->sql_prepare("select * from ml_modules where type = :type order by id desc");
		$bindParam = $this->db->sql_bindParam(['type' => 'page'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function _getListPages()
	{
		$res = $this->db->sql_prepare("select * from ml_modules where type = :type order by id desc");
		$bindParam = $this->db->sql_bindParam(['type' => 'page'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$output[] = $row;
		}

		return $output;
	}

	public function _getListMenus()
	{
		$res = $this->db->sql_prepare("select * from ml_header_menu where hmenu_type = :hmenu_type order by id desc");
		$bindParam = $this->db->sql_bindParam(['hmenu_type' => 'main'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$get_vars = json_decode($row['hmenu_vars'], true);

		return $get_vars;
	}

	public function _getDetailPage($id, $column)
	{
		$res = $this->db->sql_prepare("select * from ml_modules where type = :type and id = :id order by id desc");
		$bindParam = $this->db->sql_bindParam(['type' => 'page', 'id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$column] = isset($row[$column]) ? $row[$column] : NULL;

		return $row[$column];
	}

	public function getListDropdown()
	{
		$res = $this->db->sql_select("select * from ml_dropdown_parent order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$row['capitalize_page_name'] = ucfirst($row['page_name']);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getListDropdownMenu($dropdown_id)
	{
		$res = $this->db->sql_prepare("select * from ml_dropdown_menu where dropdown_id = :dropdown_id order by id desc");
		$bindParam = $this->db->sql_bindParam(['dropdown_id' => $dropdown_id], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			if ($row['menu_vars'] != null)
			{
				$output[] = json_decode($row['menu_vars'], TRUE);
			}
			else
			{
				$output[] = [];
			}
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = [];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output[0], JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deletedropdown($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_dropdown_parent", "", ['id' => $id]);

		if ($check)
		{
			$res_menu = $this->db->sql_prepare("select * from ml_dropdown_menu where dropdown_id = :dropdown_id");
			$bindParam_menu = $this->db->sql_bindParam(['dropdown_id' => $id], $res_menu);
			$row_menu = $this->db->sql_fetch_single($bindParam_menu);

			if ($this->db->sql_counts($bindParam_menu))
			{
				$get_vars = json_decode($row_menu['menu_vars'], true);

				foreach ($get_vars as $key => $value) 
				{
					if (file_exists($value['menu_icon']))
					{
						unlink($value['menu_icon']);
					}
				}

				$this->db->sql_delete("ml_dropdown_menu", ['dropdown_id' => $id]);
			}

			$this->db->sql_delete("ml_dropdown_parent", ['id' => $id]);

			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}

	public function deletedropdown_menu($index, $id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_dropdown_menu", "", ['dropdown_id' => $id]);

		if ($check)
		{
			$res_menu = $this->db->sql_prepare("select * from ml_dropdown_menu where dropdown_id = :dropdown_id");
			$bindParam_menu = $this->db->sql_bindParam(['dropdown_id' => $id], $res_menu);
			$row_menu = $this->db->sql_fetch_single($bindParam_menu);

			$get_vars = json_decode($row_menu['menu_vars'], true);

			if (isset($get_vars[$index]))
			{
				if (file_exists($get_vars[$index]['menu_icon']))
				{
					unlink($get_vars[$index]['menu_icon']);
				}			
			}
			
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}
}

?>