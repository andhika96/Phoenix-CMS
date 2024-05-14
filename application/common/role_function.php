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

class Aruna_Role_Function
{
	protected $table_prefix = 'ml_';

	protected $config_site;

	protected $extension = array();

	protected $roles = array();

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();

		$this->extension = load_ext('url');

		$this->config_site = config_site_function();
	}
	
	public function get_roles($order = 'DESC')
	{
		$res = $Aruna->db->sql_select("SELECT * FROM ".$this->table_prefix."roles ORDER BY id ".$order);
		$row = $Aruna->db->sql_fetch($res);

		return $row;
	}

	public function get_role_id(string $role_code)
	{
		$res = $Aruna->db->sql_prepare("SELECT id, code_name FROM ".$this->table_prefix."roles WHERE code_name = :code_name");
		$bindParam = $Aruna->db->sql_bindParam(['code_name' => $role_code], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Ternary variable validation
		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		return $row['id'];
	}

	public function get_role_name(int $role_id)
	{
		$res = $Aruna->db->sql_prepare("SELECT id, name FROM ".$this->table_prefix."roles WHERE id = :role_id");
		$bindParam = $Aruna->db->sql_bindParam(['role_id' => $role_id], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Ternary variable validation
		$row['name'] = isset($row['name']) ? $row['name'] : NULL;

		return $row['name'];
	}
}

?>