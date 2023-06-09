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

class manage_header extends Aruna_Controller
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
		check_active_page('manage_header');

		// Only role page with role user
		check_role_page('manage_header');

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('List of Header Menu');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('dropdown_type', 'Header Type', 'required');
		$this->form_validation->set_rules('page_id', 'Page', 'required');

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
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_test');
				}
				else
				{
					echo json_encode(['status' => 'failed', 'msg' => $this->_getDetailPage($this->input->post('page_id'), 'name').' already added']);
					exit;
				}

				echo json_encode(['status' => 'success', 'msg' => 'Success']);
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
		set_title('Add Header');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('dropdown_type', 'Header Type', 'required');
		$this->form_validation->set_rules('page_id', 'Page', 'required');

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
					
					$this->db->sql_insert($data_dropdown_menu, 'ml_dropdown_test');
				}
				else
				{
					echo json_encode(['status' => 'failed', 'msg' => $this->_getDetailPage($this->input->post('page_id'), 'name').' already added']);
					exit;
				}

				echo json_encode(['status' => 'success', 'url' => site_url('manage_header/editpost/'.$getLatestID)]);
				exit;
			}
		}

		$data['pages'] = $this->_getListPages();
		$data['menus'] = $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('addpost', $data);
	}

	public function editpost($id)
	{
		set_title('Edit Header');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_header_menu where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{							
			$data_header_menu = [
				'hmenu_vars' => $this->input->post('hmenu_vars')
			];

			$this->db->sql_update($data_header_menu, 'ml_header_menu', ['id' => $row['id']]);

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}

		$data['id']		= $id;
		$data['pages'] 	= $this->_getListPages();
		$data['menus'] 	= $this->_getListPages();

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editpost', $data);
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

	public function getListHeader()
	{
		$res = $this->db->sql_select("select * from ml_header_menu order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$row['capitalize_hmenu_name'] = ucfirst($row['hmenu_name']);

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

	public function getListHeaderMenuDetail($id)
	{
		$res = $this->db->sql_prepare("select * from ml_header_menu where id = :id order by id desc");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			if ($row['hmenu_vars'] != null)
			{
				$output[] = json_decode($row['hmenu_vars'], TRUE);
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
}

?>