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

class manage_section_content extends Aruna_Controller
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
		check_active_page('manage_section_content');

		// Only role page with role user
		check_role_page('manage_section_content');

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('List of Contact');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$data['db'] = $this->db;
		
		return view('index', $data);
	}

	public function header()
	{
		set_title('Section Header');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'header'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		// Get Vars 2
		$get_vars = json_decode($row['vars_1'], true);

		$menu_position[0] = (isset($get_vars['navbar']['menu']['position']) && $get_vars['navbar']['menu']['position'] == 'left') ? 'selected' : FALSE;
		$menu_position[1] = (isset($get_vars['navbar']['menu']['position']) && $get_vars['navbar']['menu']['position'] == 'center') ? 'selected' : FALSE;
		$menu_position[2] = (isset($get_vars['navbar']['menu']['position']) && $get_vars['navbar']['menu']['position'] == 'right') ? 'selected' : FALSE;

		$section_type[0] = (isset($get_vars['navbar']['menu']['placement']) && $get_vars['navbar']['menu']['placement'] == 'default') ? 'selected' : FALSE;
		$section_type[1] = (isset($get_vars['navbar']['menu']['placement']) && $get_vars['navbar']['menu']['placement'] == 'fixed-top') ? 'selected' : FALSE;
		$section_type[2] = (isset($get_vars['navbar']['menu']['placement']) && $get_vars['navbar']['menu']['placement'] == 'sticky-top') ? 'selected' : FALSE;

		$background_shadow[0] = (isset($get_vars['navbar']['background']['shadow']) && $get_vars['navbar']['background']['shadow'] == 'shadow-none') ? 'selected' : FALSE;
		$background_shadow[1] = (isset($get_vars['navbar']['background']['shadow']) && $get_vars['navbar']['background']['shadow'] == 'shadow-sm') ? 'selected' : FALSE;
		$background_shadow[2] = (isset($get_vars['navbar']['background']['shadow']) && $get_vars['navbar']['background']['shadow'] == 'shadow') ? 'selected' : FALSE;
		$background_shadow[3] = (isset($get_vars['navbar']['background']['shadow']) && $get_vars['navbar']['background']['shadow'] == 'shadow-lg') ? 'selected' : FALSE;

		$this->form_validation->set_rules('vars_1[navbar]', 'Style', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_vars['navbar'] = $this->input->post('vars_1')['navbar'];

				$this->db->sql_update(['vars_1' => json_encode($get_vars)], 'ml_section', ['id' => $row['id']]);

				echo json_encode(['status' => 'success', 'message' => 'Success']);
				exit;
			}
		}

		$data['vars'] = json_decode($row['vars_1'], true);

		$data['section_type'] = $section_type;
		$data['menu_position'] = $menu_position;
		$data['background_shadow'] = $background_shadow;

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('header', $data);
	}

	public function header_old()
	{
		set_title('Section Header');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section_old where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'header'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$menu_position[0] = (isset($row['menu_position']) && $row['menu_position'] == 'left') ? 'selected' : FALSE;
		$menu_position[1] = (isset($row['menu_position']) && $row['menu_position'] == 'center') ? 'selected' : FALSE;
		$menu_position[2] = (isset($row['menu_position']) && $row['menu_position'] == 'right') ? 'selected' : FALSE;

		$section_type[0] = (isset($row['section_type']) && $row['section_type'] == 'default') ? 'selected' : FALSE;
		$section_type[1] = (isset($row['section_type']) && $row['section_type'] == 'fixed-top') ? 'selected' : FALSE;
		$section_type[2] = (isset($row['section_type']) && $row['section_type'] == 'sticky-top') ? 'selected' : FALSE;

		$this->form_validation->set_rules('menu_position', 'Menu Position', 'required');
		$this->form_validation->set_rules('background_color', 'Background Color', 'required');
		// $this->form_validation->set_rules('background_color_active', 'Background Color Active', 'required');
		$this->form_validation->set_rules('link_color', 'Link Color', 'required');
		$this->form_validation->set_rules('link_color_hover', 'Link Color Hover', 'required');
		$this->form_validation->set_rules('link_color_active', 'Link Color Active', 'required');
		$this->form_validation->set_rules('background_link_color', 'Background Link Color', 'required');
		$this->form_validation->set_rules('background_link_color_hover', 'Background Link Color Hover', 'required');
		$this->form_validation->set_rules('background_link_color_active', 'Background Link Color Active', 'required');
		$this->form_validation->set_rules('section_type', 'Header Type', 'required');

		$margin_top_link 		= ( ! empty($this->input->post('margin_top_link'))) ? $this->input->post('margin_top_link') : '';
		$margin_right_link 		= ( ! empty($this->input->post('margin_right_link'))) ? $this->input->post('margin_right_link') : '';
		$margin_bottom_link 	= ( ! empty($this->input->post('margin_bottom_link'))) ? $this->input->post('margin_bottom_link') : '';
		$margin_left_link 		= ( ! empty($this->input->post('margin_left_link'))) ? $this->input->post('margin_left_link') : '';

		$padding_top_link 		= ( ! empty($this->input->post('padding_top_link'))) ? $this->input->post('padding_top_link') : '';
		$padding_right_link 	= ( ! empty($this->input->post('padding_right_link'))) ? $this->input->post('padding_right_link') : '';
		$padding_bottom_link 	= ( ! empty($this->input->post('padding_bottom_link'))) ? $this->input->post('padding_bottom_link') : '';
		$padding_left_link 		= ( ! empty($this->input->post('padding_left_link'))) ? $this->input->post('padding_left_link') : '';

		$border_top_left_radius_link 		= ( ! empty($this->input->post('border_top_left_radius_link'))) ? $this->input->post('border_top_left_radius_link') : '';
		$border_top_right_radius_link 		= ( ! empty($this->input->post('border_top_right_radius_link'))) ? $this->input->post('border_top_right_radius_link') : '';
		$border_bottom_left_radius_link 	= ( ! empty($this->input->post('border_bottom_left_radius_link'))) ? $this->input->post('border_bottom_left_radius_link') : '';
		$border_bottom_right_radius_link 	= ( ! empty($this->input->post('border_bottom_right_radius_link'))) ? $this->input->post('border_bottom_right_radius_link') : '';

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$data = [
					'menu_position'						=> $this->input->post('menu_position'),
					'background_color'					=> $this->input->post('background_color'),
					'background_color_active'			=> $this->input->post('background_color_active'),
					'link_color'						=> $this->input->post('link_color'),
					'link_color_hover'					=> $this->input->post('link_color_hover'),
					'link_color_active'					=> $this->input->post('link_color_active'),
					'background_link_color'				=> $this->input->post('background_link_color'),
					'background_link_color_hover'		=> $this->input->post('background_link_color_hover'),
					'background_link_color_active'		=> $this->input->post('background_link_color_active'),
					'margin_top_link'					=> $margin_top_link,
					'margin_right_link'					=> $margin_right_link,
					'margin_bottom_link'				=> $margin_bottom_link,
					'margin_left_link'					=> $margin_left_link,
					'padding_top_link'					=> $padding_top_link,
					'padding_right_link'				=> $padding_right_link,
					'padding_bottom_link'				=> $padding_bottom_link,
					'padding_left_link'					=> $padding_left_link,
					'border_top_left_radius_link'		=> $border_top_left_radius_link,
					'border_top_right_radius_link'		=> $border_top_right_radius_link,
					'border_bottom_left_radius_link'	=> $border_bottom_left_radius_link,
					'border_bottom_right_radius_link'	=> $border_bottom_right_radius_link,
					'section_type'						=> $this->input->post('section_type')
				];

				$this->db->sql_update($data, 'ml_section_old', ['uri' => 'header']);

				echo json_encode(['status' => 'success', 'message' => 'Success']);
				exit;
			}
		}

		$data['row'] = $row;
		$data['section_type'] = $section_type;
		$data['menu_position'] = $menu_position;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('header_old', $data);
	}

	public function header_menu($section)
	{
		set_title('Section Header Menu - '.$section);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'header'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		// Get Vars 2
		$get_vars = json_decode($row['vars_2'], true);

		// Section Name
		$section_name = str_replace("_", " ", $section);
		$section_name = ucwords($section_name);

		$this->form_validation->set_rules('vars_2['.$section.']', 'Style', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_vars[$section] = $this->input->post('vars_2')[$section];

				$this->db->sql_update(['vars_2' => json_encode($get_vars)], 'ml_section', ['id' => $row['id']]);

				echo json_encode(['status' => 'success', 'message' => 'Success']);
				exit;
			}
		}

		$data['section'] = $section;
		$data['vars'] = json_decode($row['vars_2'], true);

		$data['section_name'] = $section_name;

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('header_menu', $data);
	}

	public function footer()
	{
		set_title('Section Footer');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'footer'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$get_vars_1 = json_decode($row['vars_1'], true);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->input->post('footer_left') !== null)
			{
				if ($this->input->post('footer_left')['display_type'] == 'logo')
				{
					if ( ! empty($_FILES['image_logo']['name']))
					{
						$dir = date("Ym", time());
						$s_folder = './contents/userfiles/logo/'.$dir.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/logo/'.$dir.'/';

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

						if ( ! $upload->do_upload('image_logo'))
						{
							if ($_FILES['image_logo']['error'] != 4)
							{
								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							if (file_exists($get_vars_1['footer_left']['site_logo']['content']))
							{
								$image_web = $get_vars_1['footer_left']['site_logo']['content'];
							}
							else
							{
								$image_web = 'empty';
							}
						}
						else 
						{
							if (file_exists($get_vars_1['footer_left']['site_logo']['content']))
							{
								unlink($get_vars_1['footer_left']['site_logo']['content']);
							}

							$image_web = $x_folder.$upload->data('file_name');
						}
					}
					else
					{
						if (file_exists($get_vars_1['footer_left']['site_logo']['content']))
						{
							$image_web = $get_vars_1['footer_left']['site_logo']['content'];
						}
						else
						{
							$image_web = 'empty';
						}
					}
				}
				
				$get_vars_1['footer_left'] = $this->input->post('footer_left');
				$get_vars_1['footer_left']['site_logo']['content'] = $image_web;

				$this->db->sql_update(['vars_1' => json_encode($get_vars_1)], 'ml_section', ['uri' => 'footer']);
			}

			if ($this->input->post('footer_right_link1') !== null)
			{
				$get_vars_1['footer_right_link1'] = $this->input->post('footer_right_link1');

				$this->db->sql_update(['vars_1' => json_encode($get_vars_1)], 'ml_section', ['uri' => 'footer']);
			}

			if ($this->input->post('footer_right_link2') !== null)
			{
				$get_vars_1['footer_right_link2'] = $this->input->post('footer_right_link2');

				$this->db->sql_update(['vars_1' => json_encode($get_vars_1)], 'ml_section', ['uri' => 'footer']);
			}

			if ($this->input->post('footer_right_link3') !== null)
			{
				$get_vars_1['footer_right_link3'] = $this->input->post('footer_right_link3');

				$this->db->sql_update(['vars_1' => json_encode($get_vars_1)], 'ml_section', ['uri' => 'footer']);
			}

			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success', 'message' => 'Success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}

		$data['__footer_left'] 		= $this->__footer_left();
		$data['__footer_link_1'] 	= $this->__footer_link_1();
		$data['__footer_link_2'] 	= $this->__footer_link_2();
		$data['__footer_link_3'] 	= $this->__footer_link_3();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('footer', $data);
	}

	public function getFooterContent()
	{
		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'footer'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$get_vars_1 = json_decode($row['vars_1'], true);

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($get_vars_1, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function icon()
	{
		$new_lists = array();
		$files = file_get_contents(base_url('assets/plugins/fontawesome/5.15.3/metadata/icons.json'));

		$json_decode = json_decode($files, true);

		foreach ($json_decode as $key => $value) 
		{
			if ($key == $this->input->get('search'))
			{
				$code = $key;
				$icon = isset($value['svg']['solid']) ? $value['svg']['solid']['raw'] : $value['svg']['brands']['raw'];

				$new_lists[] = ['code' => $code, 'icon' => $icon];
			}
			
			if ( ! $this->input->get('search'))
			{
				$code = $key;
				$icon = isset($value['svg']['solid']) ? $value['svg']['solid']['raw'] : $value['svg']['brands']['raw'];

				$new_lists[] = ['code' => $code, 'icon' => $icon];
			}
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($new_lists, JSON_PRETTY_PRINT))
					 ->_display();
		exit;		
	}

	protected function __footer_left()
	{
		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'footer'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$get_vars = json_decode($row['vars_1'], true);

		$data['get_vars'] = $get_vars;

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('__footer_left', $data, FALSE, TRUE);
	}

	protected function __footer_link_1()
	{
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('__footer_link_1', $data, FALSE, TRUE);
	}

	protected function __footer_link_2()
	{
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('__footer_link_2', $data, FALSE, TRUE);
	}

	protected function __footer_link_3()
	{
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('__footer_link_3', $data, FALSE, TRUE);
	}
}

?>