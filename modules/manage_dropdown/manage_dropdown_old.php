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

		// Check active page
		check_active_page('manage_dropdown');

		// Only role page with role user
		check_role_page('manage_dropdown');

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('List of Dropdown Menu');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('page_id', 'Page', 'required');
		$this->form_validation->set_rules('menu_id', 'Menu', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
						'page_id' 	=> $this->input->post('page_id'),
						'page_name' => $this->_getDetailPage($this->input->post('page_id'), 'name')
					];

					$this->db->sql_insert($data_dropdown_parent, 'ml_dropdown_parent');

					$get_dropdown_parent_id = $this->db->insert_id();

					$data_dropdown_menu = [
						'dropdown_id' 		=> $get_dropdown_parent_id,
						'menu_name' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_link' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_position' 	=> 0
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}
				else
				{
					$data_dropdown_menu = [
						'dropdown_id' 		=> $row['id'],
						'menu_name' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_link' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_position' 	=> 0
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}

				echo json_encode(['status' => 'success', 'msg' => 'New menu added!']);
				exit;
			}
		}

		$data['pages'] = $this->_getListPages();
		$data['menus'] = $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('index', $data);
	}

	public function addpost()
	{
		set_title('Add New Dropdown');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('menu_type', 'Menu Type', 'required');
		$this->form_validation->set_rules('page_id', 'Page', 'required');

		if ($this->input->post('menu_type') == 'page')
		{
			$this->form_validation->set_rules('menu_id', 'Menu', 'required');
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
						'page_id' 	=> $this->input->post('page_id'),
						'page_name' => $this->_getDetailPage($this->input->post('page_id'), 'name')
					];

					$this->db->sql_insert($data_dropdown_parent, 'ml_dropdown_parent');

					$get_dropdown_parent_id = $this->db->insert_id();

					$data_dropdown_menu = [
						'dropdown_id' 		=> $get_dropdown_parent_id,
						'menu_type' 		=> $this->input->post('menu_type'),
						'menu_name' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_link' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_position' 	=> 0
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}
				else
				{
					$data_dropdown_menu = [
						'dropdown_id' 		=> $row['id'],
						'menu_type' 		=> $this->input->post('menu_type'),
						'menu_name' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_link' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
						'menu_position' 	=> 0
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_menu');
				}

				echo json_encode(['status' => 'success', 'msg' => 'New menu added!']);
				exit;
			}
		}

		$data['pages'] = $this->_getListPages();
		$data['menus'] = $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('addpost', $data);
	}

	public function addpost_test()
	{
		set_title('Add New Dropdown');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_dropdown_parent where page_id = :page_id");
		$bindParam = $this->db->sql_bindParam(['page_id' => 20], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$res_menu = $this->db->sql_prepare("select * from ml_dropdown_test where dropdown_id = :dropdown_id");
		$bindParam_menu = $this->db->sql_bindParam(['dropdown_id' => $row['id']], $res_menu);
		$row_menu = $this->db->sql_fetch_single($bindParam_menu);

		$get_vars = json_decode($row_menu['menu_vars'], true);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			/*
			$res2 = $this->db->sql_prepare("select * from ml_dropdown_parent where page_id = :page_id");
			$bindParam2 = $this->db->sql_bindParam(['page_id' => 20], $res2);
			$row2 = $this->db->sql_fetch_single($bindParam2);
			*/
			
			if ( ! $this->db->sql_counts($bindParam))
			{
				$data_dropdown_parent = [
					'page_id' 	=> 20,
					'page_name' => $this->_getDetailPage(20, 'name')
				];

				$this->db->sql_insert($data_dropdown_parent, 'ml_dropdown_parent');

				$get_dropdown_parent_id = $this->db->insert_id();

				$data_dropdown_menu_vars = [
					'menu_type' 		=> $this->input->post('get_menu_type'),
					'menu_name' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
					'menu_link' 		=> $this->_getDetailPage($this->input->post('menu_id'), 'name'),
					'menu_icon' 		=> ''
				];

				$data_dropdown_menu = [
					'dropdown_id' 		=> $row['id'],
					'menu_vars' 		=> json_encode($data_dropdown_menu_vars)
				];
				
				$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_test');
			}
			else
			{
				/*
				$res_menu2 = $this->db->sql_prepare("select * from ml_dropdown_test where dropdown_id = :dropdown_id");
				$bindParam_menu2 = $this->db->sql_bindParam(['dropdown_id' => $row['id']], $res_menu2);
				$row_menu2 = $this->db->sql_fetch_single($bindParam_menu2);
				*/
				
				if ( ! $this->db->sql_counts($bindParam_menu))
				{
					$data_dropdown_menu = [
						'dropdown_id' 		=> $row['id'],
						'menu_vars' 		=> $this->input->post('menu_vars')
					];
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_test');
				}
				else
				{
					$get_vars2 = json_decode($this->input->post('menu_vars'), true);

					$get_total1 = count(json_decode($this->input->post('menu_vars'), true));
					$get_total2 = count(json_decode($row_menu['menu_vars'], true));

					if ($get_total1 > $get_total2)
					{
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
								$configs['allowed_types']	= 'jpg|jpeg|png|gif';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 2000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('menu_icon_file'))
								{
									if ($_FILES['menu_icon_file']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$get_vars2[$i]['menu_icon'] = false;
								}
								else 
								{
									// log_message('debug', $get_vars2[$i]['menu_icon']);

									if (isset($get_vars2[$i]['menu_icon']) && ! empty($get_vars2[$i]['menu_icon']) && file_exists($get_vars2[$i]['menu_icon']))
									{
										unlink($get_vars2[$i]['menu_icon']);
									}

									$get_vars2[$i]['menu_icon'] = $x_folder.$upload->data('file_name');
								}

								// $this->db->sql_update(['menu_vars' => json_encode($get_vars2)], 'ml_dropdown_test', ['id' => $row_menu['id']]);
							}
						}

						$data_dropdown_menu = [
							'dropdown_id' 		=> $row['id'],
							'menu_vars'			=> json_encode($get_vars2)
						];

						$this->db->sql_update($data_dropdown_menu, 'ml_dropdown_test', ['id' => $row_menu['id']]);
					}
					elseif ($get_total1 < $get_total2)
					{
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
								$configs['allowed_types']	= 'jpg|jpeg|png|gif';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 2000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('menu_icon_file'))
								{
									if ($_FILES['menu_icon_file']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$get_vars[$i]['menu_icon'] = false;
								}
								else 
								{
									// log_message('debug', $get_vars2[$i]['menu_icon']);

									if (isset($get_vars[$i]['menu_icon']) && file_exists($get_vars[$i]['menu_icon']))
									{
										unlink($get_vars[$i]['menu_icon']);
									}

									$get_vars[$i]['menu_icon'] = $x_folder.$upload->data('file_name');
								}

								// $this->db->sql_update(['menu_vars' => json_encode($get_vars2)], 'ml_dropdown_test', ['id' => $row_menu['id']]);
							}
						}

						$data_dropdown_menu = [
							'dropdown_id' 		=> $row['id'],
							'menu_vars'			=> json_encode($get_vars)
						];

						$this->db->sql_update($data_dropdown_menu, 'ml_dropdown_test', ['id' => $row_menu['id']]);
					}
				}
			}

			/*
			$res_menu2 = $this->db->sql_prepare("select * from ml_dropdown_test where dropdown_id = :dropdown_id");
			$bindParam_menu2 = $this->db->sql_bindParam(['dropdown_id' => $row['id']], $res_menu2);
			$row_menu2 = $this->db->sql_fetch_single($bindParam_menu2);
			*/

			/*
			if ($next_update == 0)
			{
				$get_total = count(json_decode($this->input->post('menu_vars'), true));

				for ($i = 0; $i < $get_total; $i++) 
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
						$configs['allowed_types']	= 'jpg|jpeg|png|gif';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 2000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('menu_icon_file'))
						{
							if ($_FILES['menu_icon_file']['error'] != 4)
							{
								echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$get_vars2[$i]['menu_icon'] = false;
						}
						else 
						{
							// log_message('debug', $get_vars2[$i]['menu_icon']);

							if (isset($get_vars2[$i]['menu_icon']) && file_exists($get_vars2[$i]['menu_icon']))
							{
								unlink($get_vars2[$i]['menu_icon']);
							}

							$get_vars2[$i]['menu_icon'] = $x_folder.$upload->data('file_name');
						}

						$this->db->sql_update(['menu_vars' => json_encode($get_vars2)], 'ml_dropdown_test', ['id' => $row_menu['id']]);
					}
				}
			}
			*/

			echo json_encode(['status' => 'success', 'msg' => $get_total1.' - '.$get_total2]);
			exit;
		}

		$data['pages'] = $this->_getListPages();
		$data['menus'] = $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('addpost_test', $data);
	}

	public function editpost($id)
	{
		set_title('Edit Post');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name from ml_event_category where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->form_validation->set_rules('category', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_code = str_replace(" ", "", strtolower($this->input->post('category')));
				$get_code = str_replace("&", "-", $get_code);
				$get_code = str_replace("/", "-", $get_code);

				$data = [
					'name' => $this->input->post('category'),
					'code' => $get_code,
				];
				
				$this->db->sql_update($data, 'ml_event_category', ['id' => $id]);

				echo json_encode(['status' => 'success', 'url' => site_url('manage_dropdown/category')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editcategory', $data);
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
			$output[] = ['status' => 'failed', 'msg' => 'No data'];
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
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getListDropdownMenu()
	{
		$res = $this->db->sql_select("select * from ml_dropdown_menu order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getListDropdownMenuTest()
	{
		$res = $this->db->sql_select("select * from ml_dropdown_test where id = 2 order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
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

		$check = $this->db->num_rows("ml_dropdown_menu", "", ['id' => $id]);

		if ($check)
		{
			$this->db->sql_delete("ml_dropdown_menu", ['id' => $id]);
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

	public function asd()
	{
		$res_menu = $this->db->sql_prepare("select * from ml_dropdown_test where dropdown_id = :dropdown_id");
		$bindParam_menu = $this->db->sql_bindParam(['dropdown_id' => 4], $res_menu);
		$row_menu = $this->db->sql_fetch_single($bindParam_menu);

		$get_vars = json_decode($row_menu['menu_vars'], true);

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($get_vars[0]['menu_icon'], JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}
}

?>