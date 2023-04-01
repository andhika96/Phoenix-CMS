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

		$link_border_radius 	= ( ! empty($this->input->post('link_border_radius'))) ? $this->input->post('link_border_radius') : '';
		$margin_top_link 		= ( ! empty($this->input->post('margin_top_link'))) ? $this->input->post('margin_top_link') : '';
		$margin_right_link 		= ( ! empty($this->input->post('margin_right_link'))) ? $this->input->post('margin_right_link') : '';
		$margin_bottom_link 	= ( ! empty($this->input->post('margin_bottom_link'))) ? $this->input->post('margin_bottom_link') : '';
		$margin_left_link 		= ( ! empty($this->input->post('margin_left_link'))) ? $this->input->post('margin_left_link') : '';

		$padding_top_link 		= ( ! empty($this->input->post('padding_top_link'))) ? $this->input->post('padding_top_link') : '';
		$padding_right_link 	= ( ! empty($this->input->post('padding_right_link'))) ? $this->input->post('padding_right_link') : '';
		$padding_bottom_link 	= ( ! empty($this->input->post('padding_bottom_link'))) ? $this->input->post('padding_bottom_link') : '';
		$padding_left_link 		= ( ! empty($this->input->post('padding_left_link'))) ? $this->input->post('padding_left_link') : '';

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$data = [
					'menu_position'					=> $this->input->post('menu_position'),
					'background_color'				=> $this->input->post('background_color'),
					'background_color_active'		=> $this->input->post('background_color_active'),
					'link_color'					=> $this->input->post('link_color'),
					'link_color_hover'				=> $this->input->post('link_color_hover'),
					'link_color_active'				=> $this->input->post('link_color_active'),
					'link_border_radius'			=> $link_border_radius,
					'background_link_color'			=> $this->input->post('background_link_color'),
					'background_link_color_hover'	=> $this->input->post('background_link_color_hover'),
					'background_link_color_active'	=> $this->input->post('background_link_color_active'),
					'margin_top_link'				=> $margin_top_link,
					'margin_right_link'				=> $margin_right_link,
					'margin_bottom_link'			=> $margin_bottom_link,
					'margin_left_link'				=> $margin_left_link,
					'padding_top_link'				=> $padding_top_link,
					'padding_right_link'			=> $padding_right_link,
					'padding_bottom_link'			=> $padding_bottom_link,
					'padding_left_link'				=> $padding_left_link,
					'section_type'					=> $this->input->post('section_type')
				];

				$this->db->sql_update($data, 'ml_section', ['uri' => 'header']);

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
		}

		$data['row'] = $row;
		$data['section_type'] = $section_type;
		$data['menu_position'] = $menu_position;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('header', $data);
	}

	public function footer()
	{
		set_title('Section Footer');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => 'footer'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$this->form_validation->set_rules('background_color', 'Background Color', 'required');
		$this->form_validation->set_rules('background_color_active', 'Background Color Active', 'required');
		$this->form_validation->set_rules('link_color', 'Link Color', 'required');
		$this->form_validation->set_rules('link_color_hover', 'Link Color Hover', 'required');
		$this->form_validation->set_rules('link_color_active', 'Link Color Active', 'required');
		$this->form_validation->set_rules('background_link_color', 'Background Link Color', 'required');
		$this->form_validation->set_rules('background_link_color_hover', 'Background Link Color Hover', 'required');
		$this->form_validation->set_rules('background_link_color_active', 'Background Link Color Active', 'required');

		$link_border_radius 	= ( ! empty($this->input->post('link_border_radius'))) ? $this->input->post('link_border_radius') : '0px';
		$margin_top_link 		= ( ! empty($this->input->post('margin_top_link'))) ? $this->input->post('margin_top_link') : '0px';
		$margin_right_link 		= ( ! empty($this->input->post('margin_right_link'))) ? $this->input->post('margin_right_link') : '0px';
		$margin_bottom_link 	= ( ! empty($this->input->post('margin_bottom_link'))) ? $this->input->post('margin_bottom_link') : '0px';
		$margin_left_link 		= ( ! empty($this->input->post('margin_left_link'))) ? $this->input->post('margin_left_link') : '0px';

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$data = [
					'menu_position'					=> '',
					'background_color'				=> $this->input->post('background_color'),
					'background_color_active'		=> $this->input->post('background_color_active'),
					'link_color'					=> $this->input->post('link_color'),
					'link_color_hover'				=> $this->input->post('link_color_hover'),
					'link_color_active'				=> $this->input->post('link_color_active'),
					'link_border_radius'			=> $link_border_radius,
					'background_link_color'			=> $this->input->post('background_link_color'),
					'background_link_color_hover'	=> $this->input->post('background_link_color_hover'),
					'background_link_color_active'	=> $this->input->post('background_link_color_active'),
					'margin_top_link'				=> $margin_top_link,
					'margin_right_link'				=> $margin_right_link,
					'margin_bottom_link'			=> $margin_bottom_link,
					'margin_left_link'				=> $margin_left_link,
					'section_type'					=> ''
				];

				$this->db->sql_update($data, 'ml_section', ['uri' => 'footer']);

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
				exit;
			}
		}

		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('footer', $data);
	}
}

?>