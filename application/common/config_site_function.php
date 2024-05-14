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

class Aruna_Config_Site_Function
{
	protected $table_prefix = 'ml_';

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();
	}

	public function get_config_site($coloumn)
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."site_config WHERE id = :id");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => 1], $res);

		if ($this->Aruna->db->sql_counts($bindParam))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			if ($coloumn == 'site_thumbnail')
			{
				$row['site_thumbnail']  = ! empty($row['site_thumbnail']) ? base_url($row['site_thumbnail']) : base_url('assets/images/aruna_card_1200.jpg');
			
				return $row['site_thumbnail'];
			}
			else
			{
				$row[$coloumn] = isset($row[$coloumn]) ? $row[$coloumn] : NULL;

				return $row[$coloumn];
			}
		}
		else
		{
			log_message('error', 'Config site data not found in the database.');
			show_error("Config site data not found in the database.");
		}
	}

	public function get_config_multiple_device()
	{
		if ($this->get_config_site('login_multiple_device') == 0)
		{
			return TRUE;
		}
		elseif ($this->get_config_site('login_multiple_device') == 1)
		{
			return FALSE;
		}
	}

	public function get_site_title()
	{
		if ( ! get_page_title())
		{
			return get_config_site('site_name').' - '.get_config_site('site_slogan');
		}
		else 
		{
			return get_page_title().' - '.get_config_site('site_name');
		}
	}
}

?>