<?php

/*
 *  Aruna Development Project
 *  IS NOT FREE SOFTWARE
 *  Codename: Ardev Phoenix
 *	Website: https://www.aruna-dev.com
 *	Build Year: February 2024
 *  Created and developed by Andhika Adhitia N
 */

defined('APPPATH') OR exit('No direct script access allowed');

class Aruna_Page_Function
{
	protected $table_prefix = 'ml_';

	protected $config_site;

	protected $user_function;

	protected $extension = array();

	protected $roles = array();

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();

		$this->extension = load_ext('url');

		$this->config_site = config_site_function();

		$this->user_function = user_function();
	}

	public function check_active_page(array $style = array())
	{
		if ($this->check_module_page($this->Aruna->uri->segment(0)) == 0)
		{
			ini_set('display_errors', 0);
			
			if (isset($style['style_class_name']))
			{
				section_notice('
				<div class="bg-warning rounded p-3 '.$style['style_class_name'].' text-dark bg-opacity-25">
					<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> This page has been disabled.
				</div>');

			}
			else
			{
				section_notice('
				<div class="bg-warning rounded p-3 mb-3 text-dark bg-opacity-25">
					<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> This page has been disabled.
				</div>');
			}
		}
	}

	public function check_access_page()
	{	
		if ($this->get_role_page($this->Aruna->uri->segment(0)) == FALSE)
		{
			section_notice('
			<div class="bg-danger p-3 rounded mb-3 text-dark bg-opacity-25">
				<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> You do not have access to this page.
			</div>');
		}
	}

	public function check_module_page(string $module_name)
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."modules WHERE name = :name");
		$bindParam = $this->Aruna->db->sql_bindParam(['name' => $module_name], $res);

		if ($this->Aruna->db->sql_counts($bindParam))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			return $row['actived'];
		}
		else
		{
			return 'Could not find module <strong>'.$module_name.'</strong> in database';
		}
	}

	public function get_role_page(string $page_uri)
	{
		$current_modules = array();

		$res = $this->Aruna->db->sql_prepare("SELECT m.*, mp.parent_code, mp.roles FROM ml_modules AS m LEFT JOIN ml_menu_parent AS mp ON mp.parent_code = m.name WHERE m.type = 'menu' AND mp.parent_code = :parent_code ORDER BY id");
		$bindParam = $this->Aruna->db->sql_bindParam(['parent_code' => $page_uri], $res);
		while ($row = $this->Aruna->db->sql_fetch_single($res))
		{
			$current_modules = explode(",", $row['roles']);
		}

		if (in_array($this->user_function->get_user('roles'), $current_modules))
		{
			return TRUE;
		}	
		else
		{
			return FALSE;
		}
	}
}

?>