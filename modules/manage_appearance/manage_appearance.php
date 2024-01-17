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

class manage_appearance extends Aruna_Controller
{
	protected $csrf;

	protected $offset;

	protected $num_per_page;

	protected $allowed_file_type_slideshow = 'jpg|jpeg|png|gif|mp4';

	protected $max_file_size_slideshow = 200000; // KB


	protected $allowed_file_type_coverimage = 'png|jpg|jpeg|webp';

	protected $max_file_size_coverimage = 24000; // KB

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
		check_active_page('manage_appearance');

		// Only role page with role user
		check_role_page('manage_appearance');

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		redirect('dashboard');
	}

	public function logo()
	{
		set_title('Logo');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if (is_array($_FILES['logo']))
			{
				if ( ! empty($_FILES['logo']['name']) && count($_FILES['logo']['name']) > 0)
				{
					if ( ! empty($_FILES['logo']['name']['desktop_homepage']))
					{
						$res_logo_desktop_hp = $this->db->sql_select("select * from ml_logo where id = 1");
						$row_logo_desktop_hp = $this->db->sql_fetch_single($res_logo_desktop_hp);

						$dir_yearmonth	= date("Ym", time());
						$subdir_date	= 'date_'.date("d", time());

						// For database only with dot and slash at the front folder
						$s_parentfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/';
						$s_subfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						if ( ! is_dir($s_parentfolder)) 
						{
							mkdir($s_parentfolder, 0777);
						}

						if ( ! is_dir($s_subfolder)) 
						{
							mkdir($s_subfolder, 0777);
						}

						$_FILES['desktop_homepage']['name'] 	= $_FILES['logo']['name']['desktop_homepage'];
						$_FILES['desktop_homepage']['type'] 	= $_FILES['logo']['type']['desktop_homepage'];
						$_FILES['desktop_homepage']['tmp_name'] = $_FILES['logo']['tmp_name']['desktop_homepage'];
						$_FILES['desktop_homepage']['error'] 	= $_FILES['logo']['error']['desktop_homepage'];
						$_FILES['desktop_homepage']['size'] 	= $_FILES['logo']['size']['desktop_homepage'];

						$configs['upload_path']		= $s_subfolder;
						$configs['allowed_types']	= 'jpg|jpeg|png';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 8000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('desktop_homepage'))
						{
							if ($_FILES['desktop_homepage']['error'] != 4)
							{	
								$status_upload = 1;

								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$status_upload = 0;

							if (file_exists($row_logo_desktop_hp['image']))
							{
								$desktop_homepage = $row_logo_desktop_hp['image'];
							}
							else
							{
								$desktop_homepage = FALSE;
							}
						}
						else 
						{
							$status_upload = 0;

							if (file_exists($row_logo_desktop_hp['image']))
							{
								unlink($row_logo_desktop_hp['image']);
							}

							$desktop_homepage = $x_folder.$upload->data('file_name');
						}

						if ($status_upload == 0)
						{
							$data = [
								'image' 	=> $desktop_homepage,
								'size'		=> $this->input->post('logo_desktop_homepage_size'),
								'created' 	=> time()
							];

							$this->db->sql_update($data, 'ml_logo', ['id' => 1, 'type' => 'desktop', 'page' => 'homepage']);
						}
					}
					elseif ( ! empty($this->input->post('logo_desktop_homepage_size')))
					{
						$data = [
							'size'		=> $this->input->post('logo_desktop_homepage_size'),
							'created' 	=> time()
						];

						$this->db->sql_update($data, 'ml_logo', ['id' => 1, 'type' => 'mobile', 'page' => 'homepage']);
					}

					if ( ! empty($_FILES['logo']['name']['mobile_homepage']))
					{
						$res_logo_mobile_hp = $this->db->sql_select("select * from ml_logo where id = 2");
						$row_logo_mobile_hp = $this->db->sql_fetch_single($res_logo_mobile_hp);

						$dir_yearmonth	= date("Ym", time());
						$subdir_date	= 'date_'.date("d", time());

						// For database only with dot and slash at the front folder
						$s_parentfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/';
						$s_subfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						if ( ! is_dir($s_parentfolder)) 
						{
							mkdir($s_parentfolder, 0777);
						}

						if ( ! is_dir($s_subfolder)) 
						{
							mkdir($s_subfolder, 0777);
						}

						$_FILES['mobile_homepage']['name'] 		= $_FILES['logo']['name']['mobile_homepage'];
						$_FILES['mobile_homepage']['type'] 		= $_FILES['logo']['type']['mobile_homepage'];
						$_FILES['mobile_homepage']['tmp_name'] 	= $_FILES['logo']['tmp_name']['mobile_homepage'];
						$_FILES['mobile_homepage']['error'] 	= $_FILES['logo']['error']['mobile_homepage'];
						$_FILES['mobile_homepage']['size'] 		= $_FILES['logo']['size']['mobile_homepage'];

						$configs['upload_path']		= $s_subfolder;
						$configs['allowed_types']	= 'jpg|jpeg|png';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 8000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('mobile_homepage'))
						{
							if ($_FILES['mobile_homepage']['error'] != 4)
							{	
								$status_upload = 1;

								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$status_upload = 0;

							if (file_exists($row_logo_mobile_hp['image']))
							{
								$mobile_homepage = $row_logo_mobile_hp['image'];
							}
							else
							{
								$mobile_homepage = FALSE;
							}
						}
						else 
						{
							$status_upload = 0;

							if (file_exists($row_logo_mobile_hp['image']))
							{
								unlink($row_logo_mobile_hp['image']);
							}

							$mobile_homepage = $x_folder.$upload->data('file_name');
						}

						if ($status_upload == 0)
						{
							$data = [
								'image' 	=> $mobile_homepage,
								'size'		=> $this->input->post('logo_mobile_homepage_size'),
								'created' 	=> time()
							];

							$this->db->sql_update($data, 'ml_logo', ['id' => 2, 'type' => 'mobile', 'page' => 'homepage']);
						}
					}
					elseif ( ! empty($this->input->post('logo_mobile_homepage_size')))
					{
						$data = [
							'size'		=> $this->input->post('logo_mobile_homepage_size'),
							'created' 	=> time()
						];

						$this->db->sql_update($data, 'ml_logo', ['id' => 2, 'type' => 'mobile', 'page' => 'homepage']);
					}

					if ( ! empty($_FILES['logo']['name']['desktop_dashboard']))
					{
						$res_logo_desktop_hp = $this->db->sql_select("select * from ml_logo where id = 3");
						$row_logo_desktop_hp = $this->db->sql_fetch_single($res_logo_desktop_hp);

						$dir_yearmonth	= date("Ym", time());
						$subdir_date	= 'date_'.date("d", time());

						// For database only with dot and slash at the front folder
						$s_parentfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/';
						$s_subfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						if ( ! is_dir($s_parentfolder)) 
						{
							mkdir($s_parentfolder, 0777);
						}

						if ( ! is_dir($s_subfolder)) 
						{
							mkdir($s_subfolder, 0777);
						}

						$_FILES['desktop_dashboard']['name'] 		= $_FILES['logo']['name']['desktop_dashboard'];
						$_FILES['desktop_dashboard']['type'] 		= $_FILES['logo']['type']['desktop_dashboard'];
						$_FILES['desktop_dashboard']['tmp_name'] 	= $_FILES['logo']['tmp_name']['desktop_dashboard'];
						$_FILES['desktop_dashboard']['error'] 		= $_FILES['logo']['error']['desktop_dashboard'];
						$_FILES['desktop_dashboard']['size'] 		= $_FILES['logo']['size']['desktop_dashboard'];

						$configs['upload_path']		= $s_subfolder;
						$configs['allowed_types']	= 'jpg|jpeg|png';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 8000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('desktop_dashboard'))
						{
							if ($_FILES['desktop_dashboard']['error'] != 4)
							{	
								$status_upload = 1;

								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$status_upload = 0;

							if (file_exists($row_logo_desktop_hp['image']))
							{
								$desktop_dashboard = $row_logo_desktop_hp['image'];
							}
							else
							{
								$desktop_dashboard = FALSE;
							}
						}
						else 
						{
							$status_upload = 0;

							if (file_exists($row_logo_desktop_hp['image']))
							{
								unlink($row_logo_desktop_hp['image']);
							}

							$desktop_dashboard = $x_folder.$upload->data('file_name');
						}

						if ($status_upload == 0)
						{
							$data = [
								'image' 	=> $desktop_dashboard,
								'size'		=> $this->input->post('logo_desktop_dashboard_size'),
								'created' 	=> time()
							];

							$this->db->sql_update($data, 'ml_logo', ['id' => 3, 'type' => 'desktop', 'page' => 'dashboard']);
						}
					}
					elseif ( ! empty($this->input->post('logo_desktop_dashboard_size')))
					{
						$data = [
							'size'		=> $this->input->post('logo_desktop_dashboard_size'),
							'created' 	=> time()
						];

						$this->db->sql_update($data, 'ml_logo', ['id' => 3, 'type' => 'desktop', 'page' => 'dashboard']);
					}

					if ( ! empty($_FILES['logo']['name']['mobile_dashboard']))
					{
						$res_logo_mobile_hp = $this->db->sql_select("select * from ml_logo where id = 4");
						$row_logo_mobile_hp = $this->db->sql_fetch_single($res_logo_mobile_hp);

						$dir_yearmonth	= date("Ym", time());
						$subdir_date	= 'date_'.date("d", time());

						// For database only with dot and slash at the front folder
						$s_parentfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/';
						$s_subfolder = './contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/logo/'.$dir_yearmonth.'/'.$subdir_date.'/';

						if ( ! is_dir($s_parentfolder)) 
						{
							mkdir($s_parentfolder, 0777);
						}

						if ( ! is_dir($s_subfolder)) 
						{
							mkdir($s_subfolder, 0777);
						}

						$_FILES['mobile_dashboard']['name'] 	= $_FILES['logo']['name']['mobile_dashboard'];
						$_FILES['mobile_dashboard']['type'] 	= $_FILES['logo']['type']['mobile_dashboard'];
						$_FILES['mobile_dashboard']['tmp_name'] = $_FILES['logo']['tmp_name']['mobile_dashboard'];
						$_FILES['mobile_dashboard']['error'] 	= $_FILES['logo']['error']['mobile_dashboard'];
						$_FILES['mobile_dashboard']['size'] 	= $_FILES['logo']['size']['mobile_dashboard'];

						$configs['upload_path']		= $s_subfolder;
						$configs['allowed_types']	= 'jpg|jpeg|png';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 8000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('mobile_dashboard'))
						{
							if ($_FILES['mobile_dashboard']['error'] != 4)
							{	
								$status_upload = 1;

								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$status_upload = 0;

							if (file_exists($row_logo_mobile_hp['image']))
							{
								$mobile_dashboard = $row_logo_mobile_hp['image'];
							}
							else
							{
								$mobile_dashboard = FALSE;
							}
						}
						else 
						{
							$status_upload = 0;

							if (file_exists($row_logo_mobile_hp['image']))
							{
								unlink($row_logo_mobile_hp['image']);
							}

							$mobile_dashboard = $x_folder.$upload->data('file_name');
						}

						if ($status_upload == 0)
						{
							$data = [
								'image' 	=> $mobile_dashboard,
								'size'		=> $this->input->post('logo_mobile_dashboard_size'),
								'created' 	=> time()
							];

							$this->db->sql_update($data, 'ml_logo', ['id' => 4, 'type' => 'mobile', 'page' => 'dashboard']);
						}
					}
					elseif ( ! empty($this->input->post('logo_mobile_dashboard_size')))
					{
						$data = [
							'size'		=> $this->input->post('logo_mobile_dashboard_size'),
							'created' 	=> time()
						];

						$this->db->sql_update($data, 'ml_logo', ['id' => 4, 'type' => 'mobile', 'page' => 'dashboard']);
					}
				}
			}

			echo json_encode(['status' => 'success', 'message' => 'Success']);
			exit;
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('logo', $data);
	}

	public function slideshow()
	{
		set_title('Slideshow');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_select("select * from ml_modules where is_slideshow = 1");
		$row = $this->db->sql_fetch($res);

		$data['row'] = $row;

		return view('slideshow', $data);
	}

	public function edit_slideshow($page)
	{
		set_title('Edit Slideshow');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		// Table ml_slideshow
		$res = $this->db->sql_prepare("select * from ml_slideshow where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $page], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		// Table ml_layout_coverimage
		$res_layout = $this->db->sql_prepare("select * from ml_layout_slideshow where uri = :uri");
		$bindParam_layout = $this->db->sql_bindParam(['uri' => $page], $res_layout);
		$row_layout = $this->db->sql_fetch_single($bindParam_layout);

		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		$selected_effect[0] = (isset($row_layout['effect']) && $row_layout['effect'] == 'fade') ? 'selected' : FALSE;
		$selected_effect[1] = (isset($row_layout['effect']) && $row_layout['effect'] == 'nonfade') ? 'selected' : FALSE;

		$is_parallax[0] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 0) ? 'selected' : FALSE;
		$is_parallax[1] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 1) ? 'selected' : FALSE;

		$is_adaptive_height[0] = (isset($row_layout['is_adaptive_height']) && $row_layout['is_adaptive_height'] == 0) ? 'selected' : FALSE;
		$is_adaptive_height[1] = (isset($row_layout['is_adaptive_height']) && $row_layout['is_adaptive_height'] == 1) ? 'selected' : FALSE;

		$selected_autoplay[0] = (isset($row_layout['autoplay_activate']) && $row_layout['autoplay_activate'] == 'inactive') ? 'selected' : FALSE;
		$selected_autoplay[1] = (isset($row_layout['autoplay_activate']) && $row_layout['autoplay_activate'] == 'active') ? 'selected' : FALSE;

		$selected_slide_per_view[0] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 1) ? 'selected' : FALSE;
		$selected_slide_per_view[1] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 2) ? 'selected' : FALSE;
		$selected_slide_per_view[2] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 3) ? 'selected' : FALSE;

		$selected_display_slideshow[0] = (isset($row_layout['display_type']) && $row_layout['display_type'] == 'only_image') ? 'selected' : FALSE;
		$selected_display_slideshow[1] = (isset($row_layout['display_type']) && $row_layout['display_type'] == 'background_image') ? 'selected' : FALSE;

		// Table ml_modules
		$res_check_page = $this->db->sql_prepare("select * from ml_modules where name = :name and is_slideshow = :is_slideshow");
		$bindParam_check_page = $this->db->sql_bindParam(['name' => $page, 'is_slideshow' => 1], $res_check_page);

		if ( ! $this->db->sql_counts($bindParam_check_page))
		{
			error_page();
		}

		$this->form_validation->set_rules('effect', 'Effect', 'required');
		$this->form_validation->set_rules('slide_per_view', 'Slide per View', 'required');
		$this->form_validation->set_rules('autoplay_activate', 'Autoplay', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if (is_array($this->input->post('image_key')))
				{				
					foreach ($this->input->post('image_key') as $key) 
					{
						if ($this->input->post('image_id')[$key]['id'] === 'undefined')
						{
							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$config_slideshow_web['upload_path']	= $s_folder;
								$config_slideshow_web['allowed_types']	= $this->allowed_file_type_slideshow;
								$config_slideshow_web['overwrite']		= TRUE;
								$config_slideshow_web['remove_spaces']	= TRUE;
								$config_slideshow_web['encrypt_name']	= TRUE;
								$config_slideshow_web['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $config_slideshow_web);

								$upload->initialize($config_slideshow_web);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = false;
								}
								else 
								{
									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$config_slideshow_mobile['upload_path']		= $s_folder;
								$config_slideshow_mobile['allowed_types']	= $this->allowed_file_type_slideshow;
								$config_slideshow_mobile['overwrite']		= TRUE;
								$config_slideshow_mobile['remove_spaces']	= TRUE;
								$config_slideshow_mobile['encrypt_name']	= TRUE;
								$config_slideshow_mobile['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $config_slideshow_mobile);

								$upload->initialize($config_slideshow_mobile);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = false;
								}
								else 
								{
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_insert(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile, 'title' => $this->input->post('image_text')[$key]['title'], 'caption' => $this->input->post('image_text')[$key]['caption'], 'vars' => '{"button":[{"type":"text","alias":"empty","title":"Link 1","content":"https://www.aruna-dev.com"},{"type":"text","alias":"empty","title":"Link 2","content":"https://www.aruna-dev.com"}],"style":{"position_desktop":"left","position_mobile":"left", "background_overlay": "rgba(0, 0, 0, 0.1)"}}'], 'ml_slideshow');
							
								$get_latest_id = $this->db->insert_id();

								$get_vars['button'] 						= $this->input->post('image_button')[$key];
								$get_vars['style']['position_desktop'] 		= $this->input->post('image_style')[$key]['position_desktop'];
								$get_vars['style']['position_mobile'] 		= $this->input->post('image_style')[$key]['position_mobile'];
								$get_vars['style']['background_overlay'] 	= $this->input->post('image_style')[$key]['background_overlay'];

								$this->db->sql_update(['vars' => json_encode($get_vars)], 'ml_slideshow', ['id' => $get_latest_id]);
							}
							else
							{
								echo json_encode(['status' => 'failed', 'message' => 'Please upload the image']);
								exit;							
							}
						}
						else
						{
							$res = $this->db->sql_prepare("select * from ml_slideshow where id = :id");
							$bindParam = $this->db->sql_bindParam(['id' => $this->input->post('image_id')[$key]['id']], $res);
							$row = $this->db->sql_fetch_single($bindParam);

							// Prevent from Automatic conversion of false to array is deprecated
							$row = ($row !== FALSE) ? $row : [];

							$row['id'] = isset($row['id']) ? $row['id'] : '';

							$get_vars = json_decode($row['vars'], true);

							if ( ! $row['id'])
							{
								echo json_encode(['status' => 'failed', 'message' => 'Cannot update the image, please contact the programmer to trace this issue.']);
								exit;
							}

							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$config_slideshow_web['upload_path']	= $s_folder;
								$config_slideshow_web['allowed_types']	= $this->allowed_file_type_slideshow;
								$config_slideshow_web['overwrite']		= TRUE;
								$config_slideshow_web['remove_spaces']	= TRUE;
								$config_slideshow_web['encrypt_name']	= TRUE;
								$config_slideshow_web['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $config_slideshow_web);

								$upload->initialize($config_slideshow_web);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = $row['image_web'];
								}
								else 
								{
									if (file_exists($row['image_web']))
									{
										unlink($row['image_web']);
									}

									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$config_slideshow_mobile['upload_path']		= $s_folder;
								$config_slideshow_mobile['allowed_types']	= $this->allowed_file_type_slideshow;
								$config_slideshow_mobile['overwrite']		= TRUE;
								$config_slideshow_mobile['remove_spaces']	= TRUE;
								$config_slideshow_mobile['encrypt_name']	= TRUE;
								$config_slideshow_mobile['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $config_slideshow_mobile);

								$upload->initialize($config_slideshow_mobile);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = $row['image_mobile'];
								}
								else 
								{
									if (file_exists($row['image_mobile']))
									{
										unlink($row['image_mobile']);
									}
									
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_update(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile], 'ml_slideshow', ['id' => $row['id']]);
							}

							$get_vars['button'] 						= $this->input->post('image_button')[$key];
							$get_vars['style']['position_desktop'] 		= $this->input->post('image_style')[$key]['position_desktop'];
							$get_vars['style']['position_mobile'] 		= $this->input->post('image_style')[$key]['position_mobile'];
							$get_vars['style']['background_overlay'] 	= $this->input->post('image_style')[$key]['background_overlay'];

							$this->db->sql_update(['title' => $this->input->post('image_text')[$key]['title'], 'caption' => $this->input->post('image_text')[$key]['caption'], 'vars' => json_encode($get_vars)], 'ml_slideshow', ['id' => $row['id']]);
						}
					}

					$layout_slideshow =
					[
						'effect'				=> $this->input->post('effect'),
						'slide_per_view'		=> $this->input->post('slide_per_view'),
						'is_parallax'			=> $this->input->post('is_parallax'),
						'is_adaptive_height'	=> $this->input->post('is_adaptive_height'),
						'autoplay_activate'		=> $this->input->post('autoplay_activate'),
						'autoplay_duration'		=> $this->input->post('autoplay_duration'),
						'display_type'			=> $this->input->post('display_slideshow')
					];

					if ( ! $this->db->sql_counts($bindParam_layout))
					{
						$this->db->sql_insert($layout_slideshow, 'ml_layout_slideshow');
					}
					else
					{
						$this->db->sql_update($layout_slideshow, 'ml_layout_slideshow', ['id' => $row_layout['id']]);
					}

					echo json_encode(['status' => 'success', 'message' => 'Success']);
					exit;
				}
			}
		}

		$data['uri']							= $page;
		$data['row']							= $row;
		$data['row_layout']						= $row_layout;
		$data['selected_effect'] 				= $selected_effect;
		$data['is_parallax']					= $is_parallax;
		$data['is_adaptive_height']				= $is_adaptive_height;
		$data['selected_autoplay']				= $selected_autoplay;
		$data['selected_slide_per_view']		= $selected_slide_per_view;
		$data['selected_display_slideshow'] 	= $selected_display_slideshow;
		$data['csrf_name'] 						= $this->csrf['name'];
		$data['csrf_hash'] 						= $this->csrf['hash'];

		return view('edit_slideshow', $data);
	}

	public function edit_slideshow_old($page)
	{
		set_title('Edit Slideshow');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_slideshow where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $page], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		$res_layout = $this->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam_layout = $this->db->sql_bindParam(['page' => $page, 'section' => 'slideshow'], $res_layout);
		$row_layout = $this->db->sql_fetch_single($bindParam_layout);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		$selected_effect[0] = (isset($row_layout['effect']) && $row_layout['effect'] == 'fade') ? 'selected' : FALSE;
		$selected_effect[1] = (isset($row_layout['effect']) && $row_layout['effect'] == 'nonfade') ? 'selected' : FALSE;

		$selected_autoplay[0] = (isset($row_layout['autoplay']) && $row_layout['autoplay'] == 'active') ? 'selected' : FALSE;
		$selected_autoplay[1] = (isset($row_layout['autoplay']) && $row_layout['autoplay'] == 'inactive') ? 'selected' : FALSE;

		$selected_display_slideshow[0] = (isset($row_layout['display_slideshow']) && $row_layout['display_slideshow'] == 'only_image') ? 'selected' : FALSE;
		$selected_display_slideshow[1] = (isset($row_layout['display_slideshow']) && $row_layout['display_slideshow'] == 'background_image') ? 'selected' : FALSE;

		$slide_per_view[0] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 1) ? 'selected' : FALSE;
		$slide_per_view[1] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 2) ? 'selected' : FALSE;
		$slide_per_view[2] = (isset($row_layout['slide_per_view']) && $row_layout['slide_per_view'] == 3) ? 'selected' : FALSE;

		$res_check_page = $this->db->sql_prepare("select * from ml_modules where name = :name and is_slideshow = :is_slideshow");
		$bindParam_check_page = $this->db->sql_bindParam(['name' => $page, 'is_slideshow' => 1], $res_check_page);

		if ( ! $this->db->sql_counts($bindParam_check_page))
		{
			error_page();
		}

		$this->form_validation->set_rules('effect', 'Effect', 'required');
		$this->form_validation->set_rules('slide_per_view', 'Slide per View', 'required');
		$this->form_validation->set_rules('autoplay', 'Autoplay', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if (is_array($this->input->post('image_key')))
				{				
					foreach ($this->input->post('image_key') as $key) 
					{
						if ($this->input->post('image_id')[$key]['id'] === 'undefined')
						{
							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= $this->allowed_file_type_slideshow;
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = false;
								}
								else 
								{
									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= $this->allowed_file_type_slideshow;
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = false;
								}
								else 
								{
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_insert(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile, 'title' => $this->input->post('image_text')[$key]['title'], 'caption' => $this->input->post('image_text')[$key]['caption'], 'vars' => '{"button":[{"type":"text","alias":"empty","title":"Link 1","content":"https://www.aruna-dev.com"},{"type":"text","alias":"empty","title":"Link 2","content":"https://www.aruna-dev.com"}],"style":{"position":"left"}}'], 'ml_slideshow');
							
								$get_latest_id = $this->db->insert_id();

								$get_vars['button'] = $this->input->post('image_button')[$key];
								$get_vars['style']['position'] = $this->input->post('image_style')[$key]['position'];
								$get_vars['style']['background_overlay'] = $this->input->post('image_style')[$key]['background_overlay'];

								$this->db->sql_update(['vars' => json_encode($get_vars)], 'ml_slideshow', ['id' => $get_latest_id]);
							}
							else
							{
								echo json_encode(['status' => 'failed', 'message' => 'Please upload the image']);
								exit;							
							}
						}
						else
						{
							$res = $this->db->sql_prepare("select * from ml_slideshow where id = :id");
							$bindParam = $this->db->sql_bindParam(['id' => $this->input->post('image_id')[$key]['id']], $res);
							$row = $this->db->sql_fetch_single($bindParam);

							// Prevent from Automatic conversion of false to array is deprecated
							$row = ($row !== FALSE) ? $row : [];

							$row['id'] = isset($row['id']) ? $row['id'] : '';

							$get_vars = json_decode($row['vars'], true);

							if ( ! $row['id'])
							{
								echo json_encode(['status' => 'failed', 'message' => 'Cannot update the image, please contact the programmer to trace this issue.']);
								exit;
							}

							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= $this->allowed_file_type_slideshow;
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = $row['image_web'];
								}
								else 
								{
									if (file_exists($row['image_web']))
									{
										unlink($row['image_web']);
									}

									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/slideshow/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/slideshow/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= $this->allowed_file_type_slideshow;
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= $this->max_file_size_slideshow;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = $row['image_mobile'];
								}
								else 
								{
									if (file_exists($row['image_mobile']))
									{
										unlink($row['image_mobile']);
									}
									
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_update(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile], 'ml_slideshow', ['id' => $row['id']]);
							}

							if (empty($this->input->post('image_button')[$key]))
							{
								$this->input->post('image_button')[$key] = '{"button":[{"type":"text","alias":"empty","title":"Link 1","content":"https://www.aruna-dev.com"},{"type":"text","alias":"empty","title":"Link 2","content":"https://www.aruna-dev.com"}],"style":{"position":"left"}}';
							}

							$get_vars['button'] = $this->input->post('image_button')[$key];
							$get_vars['style']['position'] = $this->input->post('image_style')[$key]['position'];
							$get_vars['style']['background_overlay'] = $this->input->post('image_style')[$key]['background_overlay'];

							$this->db->sql_update(['title' => $this->input->post('image_text')[$key]['title'], 'caption' => $this->input->post('image_text')[$key]['caption'], 'vars' => json_encode($get_vars)], 'ml_slideshow', ['id' => $row['id']]);
						}
					}

					$slideshow_data = [
						'page'					=> $page,
						'section'				=> 'slideshow',
						'slide_per_view'		=> $this->input->post('slide_per_view'),
						'display_slideshow'		=> $this->input->post('display_slideshow'),
						'effect'				=> $this->input->post('effect'),
						'autoplay'				=> $this->input->post('autoplay'),
						'autoplay_delay'		=> $this->input->post('autoplay_delay'),
						'created'				=> time()
					];

					if ( ! $this->db->sql_counts($bindParam_layout))
					{
						$this->db->sql_insert($slideshow_data, 'ml_layout');
					}
					else
					{
						$this->db->sql_update($slideshow_data, 'ml_layout', ['id' => $row_layout['id']]);
					}

					echo json_encode(['status' => 'success', 'message' => 'Success']);
					exit;
				}
			}
		}

		$data['uri']							= $page;
		$data['row']							= $row;
		$data['row_layout']						= $row_layout;
		$data['selected_effect'] 				= $selected_effect;
		$data['selected_autoplay']				= $selected_autoplay;
		$data['selected_display_slideshow'] 	= $selected_display_slideshow;
		$data['slide_per_view']					= $slide_per_view;
		$data['csrf_name'] 						= $this->csrf['name'];
		$data['csrf_hash'] 						= $this->csrf['hash'];

		return view('edit_slideshow', $data);
	}

	public function coverimage()
	{
		set_title('Cover Image');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_select("select * from ml_modules where is_coverimage = 1");
		$row = $this->db->sql_fetch($res);

		$data['row'] = $row;

		return view('coverimage', $data);
	}

	public function edit_coverimage($page)
	{
		set_title('Edit Cover Image');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		// Table ml_coverimage
		$res = $this->db->sql_prepare("select * from ml_coverimage where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $page], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		// Table ml_layout_coverimage
		$res_layout = $this->db->sql_prepare("select * from ml_layout_coverimage where uri = :uri");
		$bindParam_layout = $this->db->sql_bindParam(['uri' => $page], $res_layout);
		$row_layout = $this->db->sql_fetch_single($bindParam_layout);

		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		$is_parallax[0] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 0) ? 'selected' : FALSE;
		$is_parallax[1] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 1) ? 'selected' : FALSE;

		$is_adaptive_height[0] = (isset($row_layout['is_adaptive_height']) && $row_layout['is_adaptive_height'] == 0) ? 'selected' : FALSE;
		$is_adaptive_height[1] = (isset($row_layout['is_adaptive_height']) && $row_layout['is_adaptive_height'] == 1) ? 'selected' : FALSE;

		$selected_display_type[0] = (isset($row_layout['display_type']) && $row_layout['display_type'] == 'only_image') ? 'selected' : FALSE;
		$selected_display_type[1] = (isset($row_layout['display_type']) && $row_layout['display_type'] == 'background_image') ? 'selected' : FALSE;

		$image_size_desktop[0] = (isset($row_layout['image_size_desktop']) && $row_layout['image_size_desktop'] == 'small') ? 'selected' : FALSE;
		$image_size_desktop[1] = (isset($row_layout['image_size_desktop']) && $row_layout['image_size_desktop'] == 'medium') ? 'selected' : FALSE;
		$image_size_desktop[2] = (isset($row_layout['image_size_desktop']) && $row_layout['image_size_desktop'] == 'large') ? 'selected' : FALSE;
		$image_size_desktop[3] = (isset($row_layout['image_size_desktop']) && $row_layout['image_size_desktop'] == 'full') ? 'selected' : FALSE;

		$image_size_mobile[0] = (isset($row_layout['image_size_mobile']) && $row_layout['image_size_mobile'] == 'small') ? 'selected' : FALSE;
		$image_size_mobile[1] = (isset($row_layout['image_size_mobile']) && $row_layout['image_size_mobile'] == 'medium') ? 'selected' : FALSE;
		$image_size_mobile[2] = (isset($row_layout['image_size_mobile']) && $row_layout['image_size_mobile'] == 'large') ? 'selected' : FALSE;
		$image_size_mobile[3] = (isset($row_layout['image_size_mobile']) && $row_layout['image_size_mobile'] == 'full') ? 'selected' : FALSE;

		$disable_form_image_size_desktop 	= (isset($row_layout['display_type']) && $row_layout['display_type'] == 'only_image') ? 'disabled' : '';
		$disable_form_image_size_mobile 	= (isset($row_layout['display_type']) && $row_layout['display_type'] == 'only_image') ? 'disabled' : '';
		$disable_form_is_parallax			= (isset($row_layout['display_type']) && $row_layout['display_type'] == 'only_image') ? 'disabled' : '';

		// Table ml_modules
		$res_check_page = $this->db->sql_prepare("select * from ml_modules where name = :name and is_coverimage = :is_coverimage");
		$bindParam_check_page = $this->db->sql_bindParam(['name' => $page, 'is_coverimage' => 1], $res_check_page);

		if ( ! $this->db->sql_counts($bindParam_check_page))
		{
			error_page();
		}

		$this->form_validation->set_rules('display_coverimage', 'Dispay Cover Image', 'required');

		if ($this->input->post('display_coverimage') == 'background_image')
		{
			$this->form_validation->set_rules('image_size_desktop', 'Image Size Desktop', 'required');
			$this->form_validation->set_rules('image_size_mobile', 'Image Size Mobile', 'required');
			$this->form_validation->set_rules('is_parallax', 'Parallax', 'required');
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if (is_array($this->input->post('image_key')))
				{				
					foreach ($this->input->post('image_key') as $key) 
					{
						if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
						{
							$res = $this->db->sql_prepare("select * from ml_coverimage where id = :id");
							$bindParam = $this->db->sql_bindParam(['id' => $this->input->post('image_id')[$key]['id']], $res);
							$row = $this->db->sql_fetch_single($bindParam);

							// Prevent from Automatic conversion of false to array is deprecated
							$row = ($row !== FALSE) ? $row : [];

							$row['id'] = isset($row['id']) ? $row['id'] : '';

							if ( ! $row['id'])
							{
								echo json_encode(['status' => 'failed', 'message' => 'Cannot update the image, please contact the programmer to trace this issue.']);
								exit;
							}

							// Image For Web
							$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
							$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
							$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
							$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
							$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

							$dir = date("Ym", time());
							$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

							// For database only without dot and slash at the front folder
							$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

							if ( ! is_dir($s_folder)) 
							{
								mkdir($s_folder, 0777);
							}

							$config_coverimage_web['upload_path']	= $s_folder;
							$config_coverimage_web['overwrite']		= TRUE;
							$config_coverimage_web['remove_spaces']	= TRUE;
							$config_coverimage_web['encrypt_name']	= TRUE;
							$config_coverimage_web['max_size']		= $this->max_file_size_coverimage;
							$config_coverimage_web['allowed_types']	= $this->allowed_file_type_coverimage;

							$upload = load_lib('upload', $config_coverimage_web);

							$upload->initialize($config_coverimage_web);

							if ( ! $upload->do_upload('file_web'))
							{
								if ($_FILES['file_web']['error'] != 4)
								{
									echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
									exit;
								}

								$image_web = $row['image_web'];
							}
							else 
							{
								if (file_exists($row['image_web']))
								{
									unlink($row['image_web']);
								}

								$image_web = $x_folder.$upload->data('file_name');
							}

							// Image for Mobile
							$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
							$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
							$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
							$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
							$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

							$dir = date("Ym", time());
							$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

							// For database only without dot and slash at the front folder
							$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

							if ( ! is_dir($s_folder)) 
							{
								mkdir($s_folder, 0777);
							}

							$config_coverimage_mobile['upload_path']	= $s_folder;
							$config_coverimage_mobile['overwrite']		= TRUE;
							$config_coverimage_mobile['remove_spaces']	= TRUE;
							$config_coverimage_mobile['encrypt_name']	= TRUE;
							$config_coverimage_mobile['allowed_types']	= $this->allowed_file_type_coverimage;
							$config_coverimage_mobile['max_size']		= $this->max_file_size_coverimage;

							$upload = load_lib('upload', $config_coverimage_mobile);

							$upload->initialize($config_coverimage_mobile);

							if ( ! $upload->do_upload('file_mobile'))
							{
								if ($_FILES['file_mobile']['error'] != 4)
								{
									echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
									exit;
								}

								$image_mobile = $row['image_mobile'];
							}
							else 
							{
								if (file_exists($row['image_mobile']))
								{
									unlink($row['image_mobile']);
								}
								
								$image_mobile = $x_folder.$upload->data('file_name');
							}

							$this->db->sql_update(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile], 'ml_coverimage', ['id' => $row['id']]);
						}

						$get_vars['button'] 						= $this->input->post('image_button')[$key];
						$get_vars['style']['position_desktop'] 		= $this->input->post('image_style')[$key]['position_desktop'];
						$get_vars['style']['position_mobile'] 		= $this->input->post('image_style')[$key]['position_mobile'];
						$get_vars['style']['background_overlay'] 	= $this->input->post('image_style')[$key]['background_overlay'];

						$this->db->sql_update(['uri' => $page, 'vars' => json_encode($get_vars)], 'ml_coverimage', ['id' => $row['id']]);
					}

					$layout_coverimage =
					[
						'image_size_desktop'	=> $this->input->post('image_size_desktop'),
						'image_size_mobile'		=> $this->input->post('image_size_mobile'),
						'is_parallax'			=> $this->input->post('is_parallax'),
						'is_adaptive_height'	=> $this->input->post('is_adaptive_height'),
						'display_type'			=> $this->input->post('display_coverimage')
					];

					if ( ! $this->db->sql_counts($bindParam_layout))
					{
						$this->db->sql_insert($layout_coverimage, 'ml_layout_coverimage');
					}
					else
					{
						$this->db->sql_update($layout_coverimage, 'ml_layout_coverimage', ['id' => $row_layout['id']]);
					}

					echo json_encode(['status' => 'success', 'message' => 'Success']);
					exit;
				}
			}
		}

		$data['uri'] 								= $page;
		$data['row']								= $row;
		$data['row_layout']							= $row_layout;
		$data['is_parallax']						= $is_parallax;
		$data['is_adaptive_height']					= $is_adaptive_height;
		$data['image_size_desktop']					= $image_size_desktop;
		$data['image_size_mobile']					= $image_size_mobile;
		$data['disable_form_image_size_desktop'] 	= $disable_form_image_size_desktop;
		$data['disable_form_image_size_mobile']		= $disable_form_image_size_mobile;
		$data['disable_form_is_parallax']			= $disable_form_is_parallax;
		$data['selected_display_type']				= $selected_display_type;

		$data['csrf_name'] 							= $this->csrf['name'];
		$data['csrf_hash'] 							= $this->csrf['hash'];

		return view('edit_coverimage', $data);
	}

	public function edit_coverimage_old($page)
	{
		set_title('Edit Cover Image');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_coverimage where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $page], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		$res_layout = $this->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam_layout = $this->db->sql_bindParam(['page' => $page, 'section' => 'coverimage'], $res_layout);
		$row_layout = $this->db->sql_fetch_single($bindParam_layout);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		$row_layout['content_title'] = isset($row_layout['content_title']) ? $row_layout['content_title'] : '';
		$row_layout['content_description'] = isset($row_layout['content_description']) ? $row_layout['content_description'] : '';
		$row_layout['background_overlay'] = isset($row_layout['background_overlay']) ? $row_layout['background_overlay'] : '';

		$size_type[0] = (isset($row_layout['size_type']) && $row_layout['size_type'] == 'small') ? 'selected' : FALSE;
		$size_type[1] = (isset($row_layout['size_type']) && $row_layout['size_type'] == 'medium') ? 'selected' : FALSE;
		$size_type[2] = (isset($row_layout['size_type']) && $row_layout['size_type'] == 'large') ? 'selected' : FALSE;
		$size_type[3] = (isset($row_layout['size_type']) && $row_layout['size_type'] == 'full') ? 'selected' : FALSE;

		$selected_display_coverimage[0] = (isset($row_layout['display_coverimage']) && $row_layout['display_coverimage'] == 'only_image') ? 'selected' : FALSE;
		$selected_display_coverimage[1] = (isset($row_layout['display_coverimage']) && $row_layout['display_coverimage'] == 'background_image') ? 'selected' : FALSE;

		$is_parallax[0] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 0) ? 'selected' : FALSE;
		$is_parallax[1] = (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 1) ? 'selected' : FALSE;

		$res_check_page = $this->db->sql_prepare("select * from ml_modules where name = :name and is_coverimage = :is_coverimage");
		$bindParam_check_page = $this->db->sql_bindParam(['name' => $page, 'is_coverimage' => 1], $res_check_page);

		if ( ! $this->db->sql_counts($bindParam_check_page))
		{
			error_page();
		}

		if ($this->input->post('display_coverimage') == 'background_image')
		{
			$this->form_validation->set_rules('size_type', 'Size Type', 'required');
			$this->form_validation->set_rules('is_parallax', 'Parallax', 'required');
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE && $this->input->post('display_coverimage') == 'background_image')
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{			
				if (is_array($this->input->post('image_key')))
				{				
					foreach ($this->input->post('image_key') as $key) 
					{
						if ($this->input->post('image_id')[$key]['id'] == 'undefined')
						{
							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= 'jpg|jpeg|png|mp4';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 24000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = false;
								}
								else 
								{
									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= 'jpg|jpeg|png';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 24000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = false;
								}
								else 
								{
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_insert(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile], 'ml_coverimage');
							}
							else
							{
								echo json_encode(['status' => 'failed', 'message' => 'Please upload the image']);
								exit;							
							}
						}
						else
						{
							if ( ! empty($_FILES['image_web_'.$key]['name']) || ! empty($_FILES['image_mobile_'.$key]['name']))
							{
								$res = $this->db->sql_prepare("select * from ml_coverimage where id = :id");
								$bindParam = $this->db->sql_bindParam(['id' => $this->input->post('image_id')[$key]['id']], $res);
								$row = $this->db->sql_fetch_single($bindParam);

								// Prevent from Automatic conversion of false to array is deprecated
								$row = ($row !== FALSE) ? $row : [];

								$row['id'] = isset($row['id']) ? $row['id'] : '';

								if ( ! $row['id'])
								{
									echo json_encode(['status' => 'failed', 'message' => 'Cannot update the image, please contact the programmer to trace this issue.']);
									exit;
								}

								// Image For Web
								$_FILES['file_web']['name'] 	= $_FILES['image_web_'.$key]['name'];
								$_FILES['file_web']['type'] 	= $_FILES['image_web_'.$key]['type'];
								$_FILES['file_web']['tmp_name'] = $_FILES['image_web_'.$key]['tmp_name'];
								$_FILES['file_web']['error'] 	= $_FILES['image_web_'.$key]['error'];
								$_FILES['file_web']['size'] 	= $_FILES['image_web_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= 'jpg|jpeg|png';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 24000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_web'))
								{
									if ($_FILES['file_web']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_web = $row['image_web'];
								}
								else 
								{
									if (file_exists($row['image_web']))
									{
										unlink($row['image_web']);
									}

									$image_web = $x_folder.$upload->data('file_name');
								}

								// Image for Mobile
								$_FILES['file_mobile']['name'] 		= $_FILES['image_mobile_'.$key]['name'];
								$_FILES['file_mobile']['type'] 		= $_FILES['image_mobile_'.$key]['type'];
								$_FILES['file_mobile']['tmp_name'] 	= $_FILES['image_mobile_'.$key]['tmp_name'];
								$_FILES['file_mobile']['error'] 	= $_FILES['image_mobile_'.$key]['error'];
								$_FILES['file_mobile']['size'] 		= $_FILES['image_mobile_'.$key]['size'];

								$dir = date("Ym", time());
								$s_folder = './contents/userfiles/coverimage/'.$dir.'/';

								// For database only without dot and slash at the front folder
								$x_folder = 'contents/userfiles/coverimage/'.$dir.'/';

								if ( ! is_dir($s_folder)) 
								{
									mkdir($s_folder, 0777);
								}

								$configs['upload_path']		= $s_folder;
								$configs['allowed_types']	= 'jpg|jpeg|png';
								$configs['overwrite']		= TRUE;
								$configs['remove_spaces']	= TRUE;
								$configs['encrypt_name']	= TRUE;
								$configs['max_size']		= 24000;

								$upload = load_lib('upload', $configs);

								if ( ! $upload->do_upload('file_mobile'))
								{
									if ($_FILES['file_mobile']['error'] != 4)
									{
										echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
										exit;
									}

									$image_mobile = $row['image_mobile'];
								}
								else 
								{
									if (file_exists($row['image_mobile']))
									{
										unlink($row['image_mobile']);
									}
									
									$image_mobile = $x_folder.$upload->data('file_name');
								}

								$this->db->sql_update(['uri' => $page, 'name' => $upload->data('file_name'), 'image_web' => $image_web, 'image_mobile' => $image_mobile], 'ml_coverimage', ['id' => $row['id']]);
							}
						}
					}

					$coverimage_data = [
						'page'					=> $page,
						'section'				=> 'coverimage',
						'size_type'				=> $this->input->post('size_type'),
						'is_parallax'			=> $this->input->post('is_parallax'),
						'content_title'			=> $this->input->post('content_title'),
						'content_description'	=> $this->input->post('content_description'),
						'display_coverimage'	=> $this->input->post('display_coverimage'),
						'background_overlay'	=> $this->input->post('background_overlay'),
						'sidebar_position'		=> '',
						'created'				=> time()
					];

					if ( ! $this->db->sql_counts($bindParam_layout))
					{
						$this->db->sql_insert($coverimage_data, 'ml_layout');
					}
					else
					{
						$this->db->sql_update($coverimage_data, 'ml_layout', ['id' => $row_layout['id']]);
					}

					echo json_encode(['status' => 'success', 'message' => 'Success']);
					exit;
				}
			}
		}

		$data['uri']			= $page;
		$data['row']			= $row;
		$data['row_layout']		= $row_layout;
		$data['size_type']		= $size_type;
		$data['is_parallax']	= $is_parallax;
		$data['csrf_name'] 		= $this->csrf['name'];
		$data['csrf_hash'] 		= $this->csrf['hash'];

		return view('edit_coverimage', $data);
	}

	public function pagestyle()
	{
		set_title('Page Style');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_select("select * from ml_page_style order by id asc");
		$row = $this->db->sql_fetch($res);

		$data['row'] = $row;

		return view('pagestyle', $data);
	}

	public function edit_pagestyle($uri)
	{
		set_title('Edit Page Style');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_page_style where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		if ( ! $this->db->sql_counts($bindParam))
		{
			error_page();
		}

		$this->form_validation->set_rules('page_logo_size', 'Logo Size', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				// Upload Page Logo
				if ( ! empty($_FILES['page_logo']['name']))
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/pagestyle/logo/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/pagestyle/logo/'.$dir.'/';

					func_create_directory($s_folder, 0777);

					$config_page_logo['upload_path']	= $s_folder;
					$config_page_logo['allowed_types']	= 'jpg|jpeg|png|webp';
					$config_page_logo['overwrite']		= TRUE;
					$config_page_logo['remove_spaces']	= TRUE;
					$config_page_logo['encrypt_name']	= TRUE;
					$config_page_logo['max_size']		= 10000;

					$upload = load_lib('upload', $config_page_logo);

					$upload->initialize($config_page_logo);

					if ( ! $upload->do_upload('page_logo'))
					{
						if ($_FILES['page_logo']['error'] != 4)
						{
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$page_logo = $row['page_logo'];
					}
					else 
					{
						if (file_exists($row['page_logo']))
						{
							unlink($row['page_logo']);
						}

						$page_logo = $x_folder.$upload->data('file_name');
					}
				}
				else
				{
					$page_logo = '';
				}

				// Upload Page Background Image
				if ( ! empty($_FILES['page_background_image']['name']))
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/pagestyle/background_image/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/pagestyle/background_image/'.$dir.'/';

					func_create_directory($s_folder, 0777);

					$config_page_background_image['upload_path']	= $s_folder;
					$config_page_background_image['allowed_types']	= 'jpg|jpeg|png|webp';
					$config_page_background_image['overwrite']		= TRUE;
					$config_page_background_image['remove_spaces']	= TRUE;
					$config_page_background_image['encrypt_name']	= TRUE;
					$config_page_background_image['max_size']		= 10000;

					$upload = load_lib('upload', $config_page_background_image);

					$upload->initialize($config_page_background_image);

					if ( ! $upload->do_upload('page_background_image'))
					{
						if ($_FILES['page_background_image']['error'] != 4)
						{
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$page_background_image = $row['page_background_image'];
					}
					else 
					{
						if (file_exists($row['page_background_image']))
						{
							unlink($row['page_background_image']);
						}

						$page_background_image = $x_folder.$upload->data('file_name');
					}
				}
				else
				{
					$page_background_image = '';
				}

				$data = [
					'page_logo'				=> $page_logo,
					'page_logo_size'		=> $this->input->post('page_logo_size'),
					'page_background_image'	=> $page_background_image
				];

				$this->db->sql_update($data, 'ml_page_style', ['id' => $row['id']]);
			}
		}
	}

	public function delete_slideshow($id)
	{
		$check = $this->db->num_rows("ml_slideshow", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select image_web, image_mobile from ml_slideshow where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			if (file_exists($row['image_web']))
			{
				unlink($row['image_web']);
			}

			if (file_exists($row['image_mobile']))
			{
				unlink($row['image_mobile']);
			}

			$this->db->sql_delete("ml_slideshow", ['id' => $id]);
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

	public function delete_coverimage($id)
	{
		$check = $this->db->num_rows("ml_coverimage", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select image_web, image_mobile from ml_coverimage where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			if (file_exists($row['image_web']))
			{
				unlink($row['image_web']);
			}

			if (file_exists($row['image_mobile']))
			{
				unlink($row['image_mobile']);
			}

			$this->db->sql_delete("ml_coverimage", ['id' => $id]);
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

	public function getListSlideshow($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_slideshow where uri = :uri order by id asc");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		while ($row = $this->db->sql_fetch_single($res))
		{
			$row['get_vars'] = json_decode($row['vars'], true);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data', 'name' => ''];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getListCoverimage($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_coverimage where uri = :uri order by id asc");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		while ($row = $this->db->sql_fetch_single($res))
		{
			$get_vars 									= json_decode($row['vars'], true);
			
			$row['get_var_button'] 						= $get_vars['button'];
			$row['get_var_style_position_desktop'] 		= $get_vars['style']['position_desktop'];
			$row['get_var_style_position_mobile'] 		= $get_vars['style']['position_mobile'];
			$row['get_var_style_background_overlay'] 	= $get_vars['style']['background_overlay'];
			
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data', 'name' => ''];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function test_create()
	{
		$directory = 'logo/test/asd';

		$this->create_directory($directory);
	}

	public function create_directory($directory)
	{
		if (strstr($directory, '/')) 
		{
			$split_directory = preg_split("#/#", $directory);

			if (count($split_directory) <= 5)
			{
				for ($i = 0; $i < count($split_directory); $i++) 
				{ 
					if ($i == 0)
					{
						$directory = $split_directory[$i];

						$this->init_create_directory($directory);
					}
					elseif ($i == 1)
					{
						$directory = $split_directory[0].'/'.$split_directory[$i];

						$this->init_create_directory($directory);
					}
					elseif ($i == 2)
					{
						$directory = $split_directory[0].'/'.$split_directory[1].'/'.$split_directory[$i];

						$this->init_create_directory($directory);
					}
					elseif ($i == 3)
					{
						$directory = $split_directory[0].'/'.$split_directory[1].'/'.$split_directory[2].'/'.$split_directory[$i];

						$this->init_create_directory($directory);
					}
				}
			}
			else
			{
				show_error("You only can create 5 directory.");
			}
		}
		else
		{
			$this->init_create_directory($directory);
		}
	}

	public function init_create_directory($directory)
	{
		if ( ! is_dir($directory))
		{
			mkdir($directory, 0777);

			log_message('info', 'Directory created successfully');
		}
		else
		{
			log_message('info', 'Cannot create a directory '.$directory.', because the directory already exists.');
		}
	}
}

?>