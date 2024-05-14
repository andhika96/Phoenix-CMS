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

class Aruna_Post_Function
{
	protected $table_prefix = 'ml_';

	protected $config_site;

	protected $auth_function;

	protected $default_post_type = ['news', 'event', 'promotion', 'portofolio'];

	protected $default_post_order = ['DESC', 'ASC'];

	protected $default_post_arguments = ['numberposts' => 5, 'category' => 0, 'orderby' => 'id', 'order' => 'DESC'];

	protected $extension = [];

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();

		$this->extension = load_ext('url');

		$this->config_site = config_site_function();

		$this->auth_function = auth_function();
	}

	public function get_posts(string $post_type = '', array $arguments = array())
	{
		if (in_array($post_type, $this->default_post_type))
		{
			$sql = '';

			foreach ($arguments as $key => $value) 
			{
				if (isset($arguments[$key]))
				{
					$this->default_post_arguments[$key] = $arguments[$key];
				}
			}

			// $this->default_post_arguments['numberposts'] 	= $arguments['numberposts'];
			// $this->default_post_arguments['category'] 		= $arguments['category'];
			// $this->default_post_arguments['orderby'] 		= $arguments['orderby'];
			// $this->default_post_arguments['order'] 			= $arguments['order'];

			if ($this->default_post_arguments['category'] !== 0)
			{
				$sql .= 'WHERE cid IN ('.$this->default_post_arguments['category'].')';
			}

			$res = $this->Aruna->db->sql_select("SELECT * FROM ".$this->table_prefix.$post_type."_article ".$sql." ORDER BY ".$this->default_post_arguments['orderby']." ".$this->default_post_arguments['order']." LIMIT ".$this->default_post_arguments['numberposts']);
			$row = $this->Aruna->db->sql_fetch($res);

			return $row;
		}
		else
		{
			return 'Tidak Ada Post Type';
		}
	}
}

?>