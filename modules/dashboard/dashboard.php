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

class dashboard extends Aruna_Controller
{
	public function __construct() 
	{
		parent::__construct();

		auth_function()->do_auth();
	}

	public function index()
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		return view('index');
	}

	public function checkpoint()
	{
		$res = $this->db->sql_prepare("select status from ml_accounts where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $this->session->userdata('id')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Check status user account is active or not
		if ($row['status'] == 0)
		{
			redirect('dashboard');
		}

		include APPPATH.'views/errors/html/check_point.php';
		exit;
	}
}

?>