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

class manage_contactus extends Aruna_Controller
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
		set_title('List of Contact');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$data['db'] = $this->db;
		
		return view('index', $data);
	}

	public function getListContacts()
	{
		$timezone  = +7;

		$res_getTotal = $this->db->sql_prepare("select count(*) as num from ml_contact where (email like :email and fullname like :fullname)");
		$bindParam_getTotal = $this->db->sql_bindParam(['email' => '%'.$this->input->get('search').'%', 'fullname' => '%'.$this->input->get('search').'%'], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_contact where (email like :email and fullname like :fullname) order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['email' => '%'.$this->input->get('category').'%', 'fullname' => '%'.$this->input->get('search').'%'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['get_created']  = get_date($row['created']);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No data'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}
}

?>