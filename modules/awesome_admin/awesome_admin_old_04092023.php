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

class awesome_admin extends Aruna_Controller
{
	protected $csrf;

	protected $offset;

	protected $num_per_page;
	
	public function __construct() 
	{
		parent::__construct();

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		// Only role admin is allowed
		has_access([99]);

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('Admin Panel');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		return view('index');
	}

	public function config()
	{
		set_title('Site Config');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_site_config where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => 1], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$offline_mode = $row['offline_mode'] ? 'checked' : FALSE;
		$signup_closed_0 = $row['signup_closed'] ? 'selected' : FALSE;
		$signup_closed_1 = $row['signup_closed'] ? 'selected' : FALSE;

		$row['get_site_thumbnail'] = ! empty($row['site_thumbnail']) ? base_url($row['site_thumbnail']) : base_url('assets/images/aruna_card_1200.jpg');

		$this->form_validation->set_rules('site_name', 'Site Name', 'required');
		$this->form_validation->set_rules('site_slogan', 'Site Slogan', 'required');
		$this->form_validation->set_rules('site_description', 'Site Description', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				if (isset($_FILES['thumbnail']))
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/photos/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/photos/'.$dir.'/';

					if ( ! is_dir($s_folder)) 
					{
						mkdir($s_folder, 0777);
					}

					$configs['upload_path']		= $s_folder;
					$configs['allowed_types']	= 'jpg|jpeg|png';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 8000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('thumbnail'))
					{
						if ($_FILES['thumbnail']['error'] != 4)
						{	
							echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$thumbnail = ( ! empty($row['site_thumbnail'])) ? $row['site_thumbnail'] : FALSE;
					}
					else 
					{
						if ( ! empty($row['site_thumbnail']))
						{
							unlink($row['site_thumbnail']);
						}

						$thumbnail = $x_folder.$upload->data('file_name');
					}
				}

				$_POST['offline_mode'] = isset($_POST['offline_mode']) ? 1 : 0;

				$update_data = [
					'site_name'			=>	$this->input->post('site_name'),
					'site_slogan'		=>	$this->input->post('site_slogan'),
					'site_description'	=>	$this->input->post('site_description'),
					'footer_message'	=>	$this->input->post('footer_message'),
					'signup_closed'		=>	$this->input->post('signup_closed'),
					'offline_mode'		=>	$_POST['offline_mode'],
					'offline_reason'	=>	$this->input->post('offline_reason'),
					'site_thumbnail'	=>	$thumbnail
				];

				if (isset($row['id']))
				{
					$this->db->sql_update($update_data, 'ml_site_config', ['id' => $row['id']]);
				}
				else 
				{
					$this->db->sql_insert($update_data, 'ml_site_config');
				}

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
		}

		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		$data['signup_closed_0'] = $signup_closed_0;
		$data['signup_closed_1'] = $signup_closed_1;
		$data['offline_mode'] = $offline_mode;

		return view('config', $data);
	}

	public function pages()
	{
		set_title('Pages');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules where type = 'page'");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					/*
					if (file_exists('modules/'.$file.'/'.$file.'.hook.php')) 
					{
						$module['hooking'] = 1;
					}
					else 
					{
						$module['hooking'] = 0;
					}
					*/

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode(PHP_EOL, $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);

							// if ($key == 'name') 
							// {
							// 	$key = 'flag';
							// }

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			foreach ($this_modules as $key => $module) 
			{
				if ($module['type'] == 'page')
				{
					$module_key 			= $key.'_actived';
					$module_slideshow 		= $key.'_slideshow';
					$module_coverimage 		= $key.'_coverimage';
					$module_widget 			= $key.'_widget';
					$module_position 		= $key.'_position';

					$actived 				= ( ! empty($this->input->post($module_key))) ? 1 : 0;
					$slideshow_actived 		= ( ! empty($this->input->post($module_slideshow))) ? 1 : 0;
					$coverimage_actived 	= ( ! empty($this->input->post($module_coverimage))) ? 1 : 0;
					$widget_actived 		= ( ! empty($this->input->post($module_widget))) ? 1 : 0;

					$current_modules[$key] 	= isset($current_modules[$key]) ? $current_modules[$key] : '';

					if (is_array($current_modules[$key]))
					{
						if ($slideshow_actived == 1 && $coverimage_actived == 1)
						{
							echo json_encode(['status' => 'failed', 'msg' => 'Cannot activate Cover Image and Slideshow at the same time']);
							exit;
						}

						$this->db->sql_update(['actived' => $actived, 'is_slideshow' => $slideshow_actived, 'is_coverimage' => $coverimage_actived, 'is_widget' => $widget_actived, 'position' => $this->input->post($module_position), 'type' => 'page'], 'ml_modules', ['name' => $key]);
					}
					else
					{
						$this->db->sql_insert(['name' => $key, 'type' => 'page', 'actived' => $actived, 'is_slideshow' => $slideshow_actived, 'is_coverimage' => $coverimage_actived, 'is_widget' => $widget_actived, 'position' => $this->input->post($module_position)], 'ml_modules');
					}
				}
			}

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}

		$data['pages'] = $this_modules;
		$data['current_modules'] = $current_modules;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('pages', $data);
	}

	public function menus()
	{
		set_title('Menu');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$current_modules = array();

		$res = $this->db->sql_select("select m.*, mp.parent_code, mp.roles from ml_modules as m left join ml_menu_parent as mp on mp.parent_code = m.name where m.type = 'menu' order by id");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn', 'home');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					/*
					if (file_exists('modules/'.$file.'/'.$file.'.hook.php')) 
					{
						$module['hooking'] = 1;
					}
					else 
					{
						$module['hooking'] = 0;
					}
					*/

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode(PHP_EOL, $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);
							
							// if ($key == 'name') 
							// {
							// 	$key = 'flag';
							// }

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			foreach ($this_modules as $key => $module) 
			{
				if ($module['type'] == 'menu')
				{
					$module_key 			= $key.'_actived';
					$actived 				= ( ! empty($this->input->post($module_key))) ? 1 : 0;
					$current_modules[$key] 	= isset($current_modules[$key]) ? $current_modules[$key] : '';

					if (is_array($current_modules[$key]))
					{
						$this->db->sql_update(['actived' => $actived, 'type' => 'menu'], 'ml_modules', ['name' => $key]);
					}
					else
					{
						$this->db->sql_insert(['name' => $key, 'type' => 'menu', 'actived' => $actived], 'ml_modules');
					}

					$this->db->sql_update(['roles' => $this->input->post('roles')[$key]], 'ml_menu_parent', ['parent_code' => $key]);

					$res_menu = $this->db->sql_prepare("select m.*, mp.id as mp_id, mp.parent_code from ml_menu as m left join ml_menu_parent as mp on mp.id = m.menu_parent_id where mp.parent_code = :parent_code and m.status = 0 order by id");
					$bindParam_menu = $this->db->sql_bindParam(['parent_code' => $key], $res_menu);
					while ($row_menu = $this->db->sql_fetch_single($bindParam_menu))
					{
						$this->db->sql_update(['roles' => $this->input->post('roles')[$key]], 'ml_menu', ['menu_parent_id' => $row_menu['mp_id']]);
					}
				}
			}

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}

		$data['menus'] = $this_modules;
		$data['current_modules'] = $current_modules;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('menus', $data);
	}

	public function modules()
	{
		set_title('Modules');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					if (file_exists('modules/'.$file.'/'.$file.'.hook.php')) 
					{
						$module['hooking'] = 1;
					}
					else 
					{
						$module['hooking'] = 0;
					}

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode(PHP_EOL, $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);
							
							// if ($key == 'name') 
							// {
							// 	$key = 'flag';
							// }

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			foreach ($this_modules as $key => $module) 
			{
				$module_key 			= $key.'_actived';
				$actived 				= ( ! empty($this->input->post($module_key))) ? 1 : 0;
				$current_modules[$key] 	= isset($current_modules[$key]) ? $current_modules[$key] : '';

				if (is_array($current_modules[$key]))
				{
					$this->db->sql_update(['actived' => $actived, 'type' => $module['type'], 'hooking' => $module['hooking']], 'ml_modules', ['name' => $key]);
				}
				else
				{
					$this->db->sql_insert(['name' => $key, 'type' => $module['type'], 'hooking' => $module['hooking'], 'actived' => $actived], 'ml_modules');
				}
			}
			
			$init_install 	= $this->check_install();
			$list_config 	= array();

			if ($init_install)
			{
				$list_install = ['active_slideshow', 'active_coverimage', 'active_widget'];

				foreach ($init_install as $module) 
				{
					$install_function = $module.'_install';
					$array_install = $install_function();

					foreach ($array_install as $key => $item) 
					{
						$list_config[$install_function][$key] = $item;
					}

				}

				foreach ($list_config as $key0 => $value0)
				{
					$get_real_module_name = str_replace("_install", "", $key0);

					foreach ($value0 as $key1 => $value1)
					{
						if (in_array($key1, $list_install))
						{
							$update_module = [$key1 => $value1];

							$this->db->sql_update([$key1 => $value1], 'ml_modules', ['name' => $get_real_module_name]);
						}
					}
				}
			}

			$menus 	= $this->check_menu();
			$list_menu 	= array();

			if ($menus)
			{
				foreach ($menus as $menu) 
				{
					$menu_function = $menu.'_menu';
					$array_menu = $menu_function();

					foreach ($array_menu as $key => $item) 
					{
						$list_menu[$menu_function][$key] = $item;
					}
				}

				foreach ($list_menu as $key0 => $value0)
				{
					$get_real_module_name = str_replace("_menu", "", $key0);

					foreach ($value0 as $key1 => $value1)
					{
						if ($value1['type'] == 'parent')
						{
							$res_parent = $this->db->sql_prepare("select * from ml_menu_parent where parent_name = :parent_name");
							$bindParam_parent = $this->db->sql_bindParam(['parent_name' => $value1['name']], $res_parent);

							if ($this->db->sql_counts($bindParam_parent))
							{
								$row_parent = $this->db->sql_fetch_single($bindParam_parent);

								// $value1['converted_name'] = strtolower($value1['name']);
								// $value1['converted_name'] = preg_replace("/\s+/", "_", $value1['converted_name']);

								if (isset($value1['new_name']) && ! empty($value1['new_name']))
								{
									$data_0 = 
									[
										'parent_name'	=> $value1['new_name']
									];

									$this->db->sql_update($data_0, 'ml_menu_parent', ['id' => $row_parent['id']]);
								}
								else
								{
									$data_0 = 
									[
										'parent_name' 	=> $value1['name'],
										'parent_code' 	=> $get_real_module_name,
										'icon'			=> $value1['icon'],
										'roles'			=> $value1['roles']
									];

									$this->db->sql_update($data_0, 'ml_menu_parent', ['id' => $row_parent['id']]);
								}
							}
							else
							{
								// $value1['converted_name'] = strtolower($value1['name']);
								// $value1['converted_name'] = preg_replace("/\s+/", "_", $value1['converted_name']);

								$data_0 = 
								[
									'parent_name' 	=> $value1['name'],
									'parent_code' 	=> $get_real_module_name,
									'icon'			=> $value1['icon'],
									'roles'			=> $value1['roles']
								];

								$this->db->sql_insert($data_0, 'ml_menu_parent');

								$parent_id = $this->db->insert_id();

								$res_parent = $this->db->sql_prepare("select id, parent_code, parent_name from ml_menu_parent where id = :id");
								$bindParam_parent = $this->db->sql_bindParam(['id' => $parent_id], $res_parent);
								$row_parent = $this->db->sql_fetch_single($bindParam_parent);
							}
						}
						
						if ($value1['type'] == 'child')
						{				
							$res_new_menu = $this->db->sql_prepare("select * from ml_menu where menu_name = :menu_name and menu_parent_id = :menu_parent_id");
							$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value1['name'], 'menu_parent_id' => $row_parent['id']], $res_new_menu);

							if ($this->db->sql_counts($bindParam_new_menu))
							{	
								$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

								if (isset($value1['new_name']) && ! empty($value1['new_name']))
								{
									$data_1 = 
									[
										'menu_name'			=> $value1['new_name']
									];

									$this->db->sql_update($data_1, 'ml_menu', ['id' => $row_new_menu['id']]);
								}
								else
								{
									$data_1 = 
									[
										'menu_parent_id'	=> $row_parent['id'],
										'menu_parent_name' 	=> $row_parent['parent_name'],
										'menu_parent_code' 	=> $row_parent['parent_code'],
										'menu_name'			=> $value1['name'],
										'url'				=> $value1['path'],
										'icon'				=> $value1['icon'],
										'roles'				=> $value1['roles']
									];

									$this->db->sql_update($data_1, 'ml_menu', ['id' => $row_new_menu['id']]);
								}
							}	
							else
							{
								if ( ! isset($value1['new_name']))
								{
									$data_1 = 
									[
										'menu_parent_id'	=> $row_parent['id'],
										'menu_parent_name' 	=> $row_parent['parent_name'],
										'menu_parent_code' 	=> $row_parent['parent_code'],
										'menu_name'			=> $value1['name'],
										'url'				=> $value1['path'],
										'icon'				=> $value1['icon'],
										'roles'				=> $value1['roles']
									];

									$this->db->sql_insert($data_1, 'ml_menu');
								}
							}		
						}

						if ($value1['type'] == 'single')
						{				
							$res_new_menu = $this->db->sql_prepare("select * from ml_menu where menu_name = :menu_name and menu_parent_id = :menu_parent_id");
							$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value1['name'], 'menu_parent_id' => $row_parent['id']], $res_new_menu);

							if ($this->db->sql_counts($bindParam_new_menu))
							{	
								$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

								if (isset($value1['new_name']) && ! empty($value1['new_name']))
								{
									$data_1 = 
									[
										'menu_name'			=> $value1['new_name']
									];

									$this->db->sql_update($data_1, 'ml_menu', ['id' => $row_new_menu['id']]);
								}
								else
								{
									$data_1 = 
									[
										'menu_parent_id'	=> $row_parent['id'],
										'menu_parent_name' 	=> '',
										'menu_parent_code' 	=> 'uncategorized_'.$row_parent['parent_code'],
										'menu_name'			=> $value1['name'],
										'url'				=> $value1['path'],
										'icon'				=> $value1['icon'],
										'roles'				=> $value1['roles']
									];

									$this->db->sql_update($data_1, 'ml_menu', ['id' => $row_new_menu['id']]);
								}
							}	
							else
							{
								if ( ! isset($value1['new_name']))
								{
									$data_1 = 
									[
										'menu_parent_id'	=> $row_parent['id'],
										'menu_parent_name' 	=> '',
										'menu_parent_code' 	=> 'uncategorized_'.$row_parent['parent_code'],
										'menu_name'			=> $value1['name'],
										'url'				=> $value1['path'],
										'icon'				=> $value1['icon'],
										'roles'				=> $value1['roles']
									];

									$this->db->sql_insert($data_1, 'ml_menu');
								}
							}		
						}
					}
				}
			}

			/*
			foreach ($this_modules as $key => $module) 
			{
				$module_key 			= $key.'_actived';
				$actived 				= ( ! empty($this->input->post($module_key))) ? 1 : 0;
				$current_modules[$key] 	= isset($current_modules[$key]) ? $current_modules[$key] : '';

				if (is_array($current_modules[$key]))
				{
					$this->db->sql_update(['actived' => $actived, 'type' => $module['type'], 'hooking' => $module['hooking']], 'ml_modules', ['name' => $key]);
				}
				else
				{
					$this->db->sql_insert(['name' => $key, 'type' => $module['type'], 'hooking' => $module['hooking'], 'actived' => $actived], 'ml_modules');
				}
			}
			*/

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}

		$data['modules'] = $this_modules;
		$data['current_modules'] = $current_modules;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('modules', $data);
	}

	public function users()
	{
		set_title('Users');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res_total = $this->db->sql_select("select count(id) as num from ml_accounts");
		$row_total = $this->db->sql_fetch_single($res_total);

		$res_role = $this->db->sql_select("select * from ml_roles order by id asc");

		$this->form_validation->set_rules('getSelected[]', 'Select User', 'required', ['required' => 'You did not select user the status to change']);
		// $this->form_validation->set_rules('changestatus', 'Change Status', 'required', ['required' => 'You did not select the status to change']);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				if ($this->input->post('changestatus') == '' && $this->input->post('changerole') == '')
				{
					echo json_encode(['status' => 'failed', 'msg' => 'You haven\'t selected the options yet']);
					exit;
				}
				else
				{
					if (is_array($this->input->post('getSelected')))
					{
						foreach ($this->input->post('getSelected') as $key) 
						{
							if ($this->input->post('changestatus') != '')
							{
								$this->db->sql_update(['status' => $this->input->post('changestatus')], 'ml_accounts', ['id' => $key]);
							}

							if ($this->input->post('changerole') != '')
							{
								$res_getrole = $this->db->sql_prepare("select code_name from ml_roles where id = :id");
								$bindParam_getrole = $this->db->sql_bindParam(['id' => $this->input->post('changerole')], $res_getrole);
								$row_getrole = $this->db->sql_fetch_single($bindParam_getrole);

								$this->db->sql_update(['roles' => $this->input->post('changerole'), 'role_code' => $row_getrole['code_name']], 'ml_accounts', ['id' => $key]);
							}
						}
					}

					echo json_encode(['status' => 'success', 'msg' => 'Success']);
					exit;
				}
			}
		}

		$data['row_total'] = $row_total;
		$data['res_role']  = $res_role;
		$data['db']		   = $this->db;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('users', $data);
	}

	public function roles()
	{
		set_title('Roles');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('role_name', 'Role Name', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$res = $this->db->sql_select("select max(id) as maxid from ml_roles");
				$row = $this->db->sql_fetch_single($res);

				$current_total = $this->db->num_rows('ml_roles');
				$total = $current_total-3;

				$id = $row['maxid']-$total;
				$role_code = strtolower($this->input->post('role_name'));
				$role_code = str_replace(" ", "_", $role_code);

				$new_data = ['id' => $id, 'name' => $this->input->post('role_name'), 'code_name' => $role_code];
				$this->db->sql_insert($new_data, 'ml_roles');

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('roles', $data);
	}

	public function editrole($id)
	{
		set_title('Edit Role');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name from ml_roles where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->form_validation->set_rules('role_name', 'Role Name', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$role_code = strtolower($this->input->post('role_name'));
				$role_code = str_replace(" ", "_", $role_code);

				$new_data = ['id' => $id, 'name' => $this->input->post('role_name'), 'code_name' => $role_code];
				
				$this->db->sql_update($new_data, 'ml_roles', ['id' => $id]);

				echo json_encode(['status' => 'success', 'msg' => 'Role updated!', 'url' => site_url('awesome_admin/roles')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editrole', $data);
	}

	public function smtp()
	{
		set_title('SMTP Settings');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_smtp where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => 1], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['id'] = isset($row['id']) ? $row['id'] : '';

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{
			$update_data = [
				'smtp_host'		=>	$this->input->post('smtp_host'),
				'smtp_user'		=>	$this->input->post('smtp_user'),
				'smtp_pass'		=>	$this->input->post('smtp_pass'),
				'smtp_port'		=>	$this->input->post('smtp_port'),
				'smtp_crypto'	=>	$this->input->post('smtp_crypto')
			];

			if ($row['id'])
			{
				$this->db->sql_update($update_data, 'ml_smtp', ['id' => $row['id']]);
			}
			else 
			{
				$this->db->sql_insert($update_data, 'ml_smtp');
			}

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}

		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('smtp', $data);
	}

	public function translate()
	{
		set_title('Translate');

		register_js(['<script src="'.base_url('assets/plugins/fontawesome/5.15.3/js/all.min.js').'"></script>']);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		return view('translate');
	}

	public function translated()
	{
		set_title('Translated');

		register_js(['<script src="'.base_url('assets/plugins/fontawesome/5.15.3/js/all.min.js').'"></script>']);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{			
			if (is_array($this->input->post('lang')))
			{
				foreach ($this->input->post('lang') as $key) 
				{
					$this->db->sql_update(['lang_to' => $key['to']], 'ml_language', ['id' => $key['id']]);
				}

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
			else
			{
				echo json_encode(['status' => 'failed', 'msg' => 'Failed']);
				exit;
			}
		}

		$data['db'] 			= $this->db;
		$data['offset'] 		= $this->offset;
		$data['num_per_page'] 	= $this->num_per_page;
		$data['csrf_name'] 		= $this->csrf['name'];
		$data['csrf_hash'] 		= $this->csrf['hash'];

		return view('translated', $data);
	}

	public function untranslated()
	{
		set_title('Untranslated');

		register_js(['<script src="'.base_url('assets/plugins/fontawesome/5.15.3/js/all.min.js').'"></script>']);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		if ($this->input->post('step') && $this->input->post('step') == 'post') 
		{			
			if (is_array($this->input->post('lang')))
			{
				foreach ($this->input->post('lang') as $key) 
				{
					$this->db->sql_update(['lang_to' => $key['to']], 'ml_language', ['id' => $key['id']]);
				}

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
			else
			{
				echo json_encode(['status' => 'failed', 'msg' => 'Failed']);
				exit;
			}
		}

		$data['db'] 			= $this->db;
		$data['offset'] 		= $this->offset;
		$data['num_per_page'] 	= $this->num_per_page;
		$data['csrf_name'] 		= $this->csrf['name'];
		$data['csrf_hash'] 		= $this->csrf['hash'];

		return view('untranslated', $data);
	}

	public function getUsers()
	{
		$res_getTotal = $this->db->sql_prepare("select count(*) as num from ml_accounts where (username like :username and fullname like :fullname)");
		$bindParam_getTotal = $this->db->sql_bindParam(['username' => '%'.$this->input->get('user').'%', 'fullname' => '%'.$this->input->get('user').'%'], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_accounts where (username like :username and fullname like :fullname) order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['username' => '%'.$this->input->get('user').'%', 'fullname' => '%'.$this->input->get('user').'%'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			// Remove password for security reason
			$row['password'] = ( ! empty($row['password'])) ? '[removed]' : '';

			$row['avatar']	 = avatar($row['id']);
			$row['role'] 	 = get_role($row['roles']);
			$row['status']	 = get_status_user($row['status']);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No user'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function getUserData()
	{
		$res = $this->db->sql_prepare("select a.*, a.id as uid, ui.* from ml_accounts as a join ml_user_information as ui on ui.user_id = a.id where a.id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $this->input->get('id')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['uid'] = isset($row['uid']) ? $row['uid'] : '';

		if ( ! $row['uid'] || ! $this->input->get('id'))
		{
			echo 'User not found';
			exit;
		}

		// Remove password for security reason
		$row['password'] = ( ! empty($row['password'])) ? '[removed]' : '';

		$row['email'] 	  	 = '<i class="fas fa-envelope fa-fw mr-2"></i> <strong>Email Address:</strong> <span class="float-right">'.$row['email'].'</span>';
		$row['role'] 	  	 = '<i class="fas fa-project-diagram fa-fw mr-2"></i> <strong>Role Account:</strong> <span class="float-right">'.get_role($row['id']).'</span>';
		$row['status']	  	 = '<i class="fas fa-user-check fa-fw mr-2"></i> <strong>Status Account:</strong> <span class="float-right">'.get_status_user($row['status']).'</span>';
		$row['gender']	  	 = '<i class="fas fa-venus-mars fa-fw mr-2"></i> <strong>Gender:</strong> <span class="float-right">'.get_status_gender($row['gender']).'</span>';
		$row['birthdate'] 	 = '<i class="fas fa-birthday-cake fa-fw mr-2"></i> <strong>Birthdate:</strong> <span class="float-right">'.$row['birthdate'].'</span>';
		$row['phone_number'] = '<i class="fas fa-venus-mars fa-fw mr-2"></i> <strong>Gender:</strong> <span class="float-right">'.$row['phone_number'].'</span>';
		$row['about'] 	 	 = '<i class="fas fa-quote-right fa-fw mr-2"></i> <strong>About Us:</strong> <div class="mt-2">'.$row['about'].'</div>';

		$output[] = $row;

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function getListRole()
	{
		$res = $this->db->sql_select("select * from ml_roles order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$output[] = $row;
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deleterole($id)
	{
		$check = $this->db->num_rows("ml_roles", "", ['id' => $id]);

		if ($check)
		{
			$this->db->sql_delete("ml_roles", ['id' => $id]);
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

	public function setlanguage()
	{
		$allowed_language = ['english', 'indonesian'];

		if (in_array($this->input->get('id'), $allowed_language))
		{
			set_cookie('language', $this->input->get('id'), 3600*24*365, '', '/', 'ml_', NULL, TRUE);
			
			redirect('awesome_admin/translate');
		}
		else
		{
			echo 'Your language is not allowed by system';
			exit;
		}
	}

	public function getListofRoles()
	{
		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode(get_list_role(), JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function getListRoleofMenus()
	{
		$current_modules = array();

		$res = $this->db->sql_select("select m.*, mp.parent_code, mp.roles from ml_modules as m left join ml_menu_parent as mp on mp.parent_code = m.name where m.type = 'menu' order by id");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = explode(",", $row['roles']);
		}

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($current_modules, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	protected function check_install()
	{
		$install = array();
		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		foreach ($current_modules as $module) 
		{
			if (file_exists('modules/'.$module['name'].'/'.$module['name'].'.install.php')) 
			{
				include_once('modules/'.$module['name'].'/'.$module['name'].'.install.php');
			}

			$function = $module['name'].'_install';

			if ($module['actived'] == 1 && function_exists($function))
			{
				$install[] = $module['name'];
			}
		}

		if (isset($install) && is_array($install))
		{
			return $install;
		}
		else
		{
			return FALSE;
		}
	}

	protected function check_menu()
	{
		$hooks = array();
		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		foreach ($current_modules as $module) 
		{
			if (file_exists('modules/'.$module['name'].'/'.$module['name'].'.menu.php')) 
			{
				include_once('modules/'.$module['name'].'/'.$module['name'].'.menu.php');
			}

			$function = $module['name'].'_menu';

			if ($module['actived'] == 1 && function_exists($function))
			{
				$hooks[] = $module['name'];
			}
		}

		if (isset($hooks) && is_array($hooks))
		{
			return $hooks;
		}
		else
		{
			return FALSE;
		}
	}

	protected function check_hook($act = 'hook')
	{
		$hooks = array();
		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}

		foreach ($current_modules as $module) 
		{
			if ($module['hooking'] == 1 && file_exists('modules/'.$module['name'].'/'.$module['name'].'.hook.php')) 
			{
				include_once('modules/'.$module['name'].'/'.$module['name'].'.hook.php');
			}

			$function = $module['name'].'_'.$act;

			if ($module['actived'] == 1 && function_exists($function))
			{
				$hooks[] = $module['name'];
			}
		}

		if (isset($hooks) && is_array($hooks))
		{
			return $hooks;
		}
		else
		{
			return FALSE;
		}
	}

	public function test()
	{
		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}		

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					if (file_exists('modules/'.$file.'/'.$file.'.hook.php')) 
					{
						$module['hooking'] = 1;
					}
					else 
					{
						$module['hooking'] = 0;
					}

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode(PHP_EOL, $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		/*
		foreach ($current_modules as $module) 
		{
			if ($module['hooking'] == 1 && file_exists('modules/'.$module['name'].'/'.$module['name'].'.hook.php')) 
			{
				include_once('modules/'.$module['name'].'/'.$module['name'].'.hook.php');
			}
		}

		$test = function_exists('manage_news_menu');
		$function = manage_news_menu();

		foreach ($function as $key => $value)
		{
			if ($value['type'] == 'parent')
			{
				$res_parent = $this->db->sql_prepare("select * from ml_menu_parent_test where parent_name = :parent_name");
				$bindParam_parent = $this->db->sql_bindParam(['parent_name' => $value['name']], $res_parent);

				if ( ! $this->db->sql_counts($bindParam_parent))
				{
					$value['converted_name'] = strtolower($value['name']);
					$value['converted_name'] = preg_replace("/\s+/", "_", $value['converted_name']);

					$data_0 = 
					[
						'parent_name' 	=> $value['name'],
						'parent_code' 	=> $value['converted_name'],
						'icon'			=> $value['icon'],
						'roles'			=> $value['roles']
					];

					$this->db->sql_insert($data_0, 'ml_menu_parent_test');

					$parent_id = $this->db->insert_id();
				}
				else
				{
					$row_parent = $this->db->sql_fetch_single($bindParam_parent);

					$value['converted_name'] = strtolower($value['name']);
					$value['converted_name'] = preg_replace("/\s+/", "_", $value['converted_name']);

					$data_0 = 
					[
						'parent_name' 	=> $value['name'],
						'parent_code' 	=> $value['converted_name'],
						'icon'			=> $value['icon'],
						'roles'			=> $value['roles']
					];

					$this->db->sql_update($data_0, 'ml_menu_parent_test', ['id' => $row_parent['id']]);

					$parent_id = $row_parent['id'];
				}
			}

			if ($value['type'] == 'child')
			{				
				$res_new_menu = $this->db->sql_prepare("select * from ml_menu_test where menu_name = :menu_name");
				$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value['name']], $res_new_menu);

				if ( ! $this->db->sql_counts($bindParam_new_menu))
				{	
					$res_new_parent = $this->db->sql_prepare("select id, parent_code, parent_name from ml_menu_parent_test where id = :id");
					$bindParam_new_parent = $this->db->sql_bindParam(['id' => $parent_id], $res_new_parent);
					$row_new_parent = $this->db->sql_fetch_single($bindParam_new_parent);

					$data_1 = 
					[
						'menu_parent_id'	=> $row_new_parent['id'],
						'menu_parent_name' 	=> $row_new_parent['parent_name'],
						'menu_parent_code' 	=> $row_new_parent['parent_code'],
						'menu_name'			=> $value['name'],
						'url'				=> $value['path'],
						'icon'				=> $value['icon'],
						'roles'				=> $value['roles']
					];

					$this->db->sql_insert($data_1, 'ml_menu_test');
				}	
				else
				{
					$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

					$res_new_parent = $this->db->sql_prepare("select id, parent_name, parent_code from ml_menu_parent_test where id = :id");
					$bindParam_new_parent = $this->db->sql_bindParam(['id' => $parent_id], $res_new_parent);
					$row_new_parent = $this->db->sql_fetch_single($bindParam_new_parent);

					$data_1 = 
					[
						'menu_parent_id'	=> $row_new_parent['id'],
						'menu_parent_name' 	=> $row_new_parent['parent_name'],
						'menu_parent_code' 	=> $row_new_parent['parent_code'],
						'menu_name'			=> $value['name'],
						'url'				=> $value['path'],
						'icon'				=> $value['icon'],
						'roles'				=> $value['roles']
					];

					$this->db->sql_update($data_1, 'ml_menu_test', ['id' => $row_new_menu['id']]);
				}		
			}
		}
		*/

		$hooks 	= $this->check_hook('menu');
		$menu 	= array();

		if ($hooks)
		{
			foreach ($hooks as $hook) 
			{
				$hook_function = $hook.'_menu';
				$array_hook = $hook_function();

				foreach ($array_hook as $key => $item) 
				{
					$menu[$hook_function][$key] = $item;

					/*
					foreach ($menu as $key => $value)
					{
						
						if ($value['type'] == 'parent')
						{
							$res_parent = $this->db->sql_prepare("select * from ml_menu_parent_test where parent_name = :parent_name");
							$bindParam_parent = $this->db->sql_bindParam(['parent_name' => $value['name']], $res_parent);

							if ( ! $this->db->sql_counts($bindParam_parent))
							{
								$value['converted_name'] = strtolower($value['name']);
								$value['converted_name'] = preg_replace("/\s+/", "_", $value['converted_name']);

								$data_0 = 
								[
									'parent_name' 	=> $value['name'],
									'parent_code' 	=> $value['converted_name'],
									'icon'			=> $value['icon'],
									'roles'			=> $value['roles']
								];

								$this->db->sql_insert($data_0, 'ml_menu_parent_test');

								$parent_id = $this->db->insert_id();
							}
							else
							{
								$row_parent = $this->db->sql_fetch_single($bindParam_parent);

								$value['converted_name'] = strtolower($value['name']);
								$value['converted_name'] = preg_replace("/\s+/", "_", $value['converted_name']);

								$data_0 = 
								[
									'parent_name' 	=> $value['name'],
									'parent_code' 	=> $value['converted_name'],
									'icon'			=> $value['icon'],
									'roles'			=> $value['roles']
								];

								$this->db->sql_update($data_0, 'ml_menu_parent_test', ['id' => $row_parent['id']]);

								$parent_id = $row_parent['id'];
							}
						}

						if ($value['type'] == 'child')
						{				
							$res_new_menu = $this->db->sql_prepare("select * from ml_menu_test where menu_name = :menu_name");
							$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value['name']], $res_new_menu);

							if ( ! $this->db->sql_counts($bindParam_new_menu))
							{	
								$res_new_parent = $this->db->sql_prepare("select id, parent_code, parent_name from ml_menu_parent_test where id = :id");
								$bindParam_new_parent = $this->db->sql_bindParam(['id' => $parent_id], $res_new_parent);
								$row_new_parent = $this->db->sql_fetch_single($bindParam_new_parent);

								$data_1 = 
								[
									'menu_parent_id'	=> $row_new_parent['id'],
									'menu_parent_name' 	=> $row_new_parent['parent_name'],
									'menu_parent_code' 	=> $row_new_parent['parent_code'],
									'menu_name'			=> $value['name'],
									'url'				=> $value['path'],
									'icon'				=> $value['icon'],
									'roles'				=> $value['roles']
								];

								$this->db->sql_insert($data_1, 'ml_menu_test');
							}	
							else
							{
								$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

								$res_new_parent = $this->db->sql_prepare("select id, parent_name, parent_code from ml_menu_parent_test where id = :id");
								$bindParam_new_parent = $this->db->sql_bindParam(['id' => $parent_id], $res_new_parent);
								$row_new_parent = $this->db->sql_fetch_single($bindParam_new_parent);

								$data_1 = 
								[
									'menu_parent_id'	=> $row_new_parent['id'],
									'menu_parent_name' 	=> $row_new_parent['parent_name'],
									'menu_parent_code' 	=> $row_new_parent['parent_code'],
									'menu_name'			=> $value['name'],
									'url'				=> $value['path'],
									'icon'				=> $value['icon'],
									'roles'				=> $value['roles']
								];

								$this->db->sql_update($data_1, 'ml_menu_test', ['id' => $row_new_menu['id']]);
							}		
						}
						
					}
					*/

					// foreach ($menu as $key => $value)
					// {
					// 	echo $value['type'].' - '.$value['name'].'<br/>';
					// }
				}

				// foreach ($menu as $key => $value)
				// {
				// 	echo $value['type'].' - '.$value['name'].'<br/>';
				// }

				foreach ($menu as $key0 => $value0)
				{	
						// if ($value['type'] == 'parent')
						// {
						// 	$res_parent = $this->db->sql_prepare("select * from ml_menu_parent where parent_name = :parent_name");
						// 	$bindParam_parent = $this->db->sql_bindParam(['parent_name' => $value['name']], $res_parent);

						// 	if ($this->db->sql_counts($bindParam_parent))
						// 	{
						// 		$row_parent = $this->db->sql_fetch_single($bindParam_parent);

						// 		// echo $row_parent['id'].'<br/>';
						// 	}
						// }
						
						// if ($value['type'] == 'child')
						// {				
						// 	$res_new_menu = $this->db->sql_prepare("select * from ml_menu where menu_name = :menu_name and menu_parent_id = :menu_parent_id");
						// 	$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value['name'], 'menu_parent_id' => $row_parent['id']], $res_new_menu);

						// 	if ($this->db->sql_counts($bindParam_new_menu))
						// 	{	
						// 		$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

						// 		echo 'ID: '.$row_new_menu['id'].' - Parent ID: '.$row_parent['id'].' - Menu Parent ID: '.$row_new_menu['menu_parent_id'].' - '.$value['name'].'<br/>';
						// 	}
						// 	else
						// 	{
						// 		echo 'Parent ID: '.$row_parent['id'].' - '.$value['name'].'<br/>';
						// 	}		
						// }
					
				}
			}

			foreach ($menu as $key0 => $value0)
			{
				$get_real_module_name = str_replace("_menu", "", $key0);

				foreach ($value0 as $key1 => $value1)
				{
					if ($value1['type'] == 'parent')
					{
						$res_parent = $this->db->sql_prepare("select * from ml_menu_parent where parent_name = :parent_name");
						$bindParam_parent = $this->db->sql_bindParam(['parent_name' => $value1['name']], $res_parent);

						if ($this->db->sql_counts($bindParam_parent))
						{
							$row_parent = $this->db->sql_fetch_single($bindParam_parent);
						}
						else
						{
							echo 'Insert to new database';
						}
					}
					
					if ($value1['type'] == 'child')
					{				
						$res_new_menu = $this->db->sql_prepare("select * from ml_menu where menu_name = :menu_name and menu_parent_id = :menu_parent_id");
						$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value1['name'], 'menu_parent_id' => $row_parent['id']], $res_new_menu);

						if ($this->db->sql_counts($bindParam_new_menu))
						{	
							$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

							echo 'Group: '.$get_real_module_name.' ID: '.$row_new_menu['id'].' - Parent ID: '.$row_parent['id'].' - Menu Parent ID: '.$row_new_menu['menu_parent_id'].' - '.$value1['name'].'<br/>';
						}
						else
						{
							echo 'Parent ID: '.$row_parent['id'].' - '.$value1['name'].'<br/>';
						}		
					}

					if ($value1['type'] == 'single')
					{				
						$res_new_menu = $this->db->sql_prepare("select * from ml_menu where menu_name = :menu_name and menu_parent_id = :menu_parent_id");
						$bindParam_new_menu = $this->db->sql_bindParam(['menu_name' => $value1['name'], 'menu_parent_id' => $row_parent['id']], $res_new_menu);

						if ($this->db->sql_counts($bindParam_new_menu))
						{	
							$row_new_menu = $this->db->sql_fetch_single($bindParam_new_menu);

							echo 'Group: '.$get_real_module_name.' ID: '.$row_new_menu['id'].' - Parent ID: '.$row_parent['id'].' - Menu Parent ID: '.$row_new_menu['menu_parent_id'].' - '.$value1['name'].'<br/>';
						}
						else
						{
							echo 'Parent ID: '.$row_parent['id'].' - '.$value1['name'].'<br/>';
						}		
					}
				}
			}
		}

		// $this->output->set_content_type('application/json', 'utf-8')
		// 		 ->set_header('Access-Control-Allow-Origin: '.site_url())
		// 		 ->set_output(json_encode($menu, JSON_PRETTY_PRINT))
		// 		 ->_display();
		exit;
	}

	public function test2()
	{
		$current_modules = array();

		$res = $this->db->sql_select("select * from ml_modules");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$current_modules[$row['name']] = $row;
		}		

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					if (file_exists('modules/'.$file.'/'.$file.'.install.php')) 
					{
						$module['install'] = 1;
					}
					else 
					{
						$module['install'] = 0;
					}

					if (file_exists('modules/'.$file.'/'.$file.'.hook.php')) 
					{
						$module['hooking'] = 1;
					}
					else 
					{
						$module['hooking'] = 0;
					}

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode(PHP_EOL, $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		$init_install 	= $this->check_install();
		$list_config 	= array();

		if ($init_install)
		{
			$list_install = ['active_slideshow', 'active_coverimage', 'active_widget'];

			foreach ($init_install as $module) 
			{
				$install_function = $module.'_install';
				$array_install = $install_function();

				foreach ($array_install as $key => $item) 
				{
					$list_config[$install_function][$key] = $item;
				}

			}

			foreach ($list_config as $key0 => $value0)
			{
				$get_real_module_name = str_replace("_install", "", $key0);

				foreach ($value0 as $key1 => $value1)
				{
					if (in_array($key1, $list_install))
					{
						$update_module = [$key1 => $value1];

						$this->db->sql_update([$key1 => $value1], 'ml_modules', ['name' => $get_real_module_name]);
					}
				}
			}
		}

		// $this->output->set_content_type('application/json', 'utf-8')
		// 		 ->set_header('Access-Control-Allow-Origin: '.site_url())
		// 		 ->set_output(json_encode($menu, JSON_PRETTY_PRINT))
		// 		 ->_display();
		// exit;
	}
}

?>