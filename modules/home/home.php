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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class home extends Aruna_Controller
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{
		$data['agent'] = $this->agent;

		return view('index', $data);
	}

	public function landing()
	{
		$data['db'] = $this->db;
		$data['agent'] = $this->agent;

		return view('landing', $data);
	}

	public function test()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');
	}

	public function zxc()
	{
		$res = $this->db->sql_select("select * from ml_blog_article");
		$row = $this->db->sql_fetch($res);

		$this->db->sql_chunk($row, 10, function ($response) 
		{
			$i = 1;
			foreach ($response as $output)
			{
				echo $i.' - '.$output['title'].'<br/>';

				$i++;
			}

			echo '<br/><br/>';
		});

		// print_r($output);
		exit;
	}

	public function get_posts($post_type = '', $args = array())
	{
		// $output_bindParam = [];

		$param_string	= ['orderby', 'sort_order'];
		$param_integer	= ['numberposts'];

		// print_r($param_string);

		if (is_array($args))
		{
			$i = 0;
			foreach ($args as $key => $value) 
			{
				// if (isset($param_string[$i]) && $param_string[$i] == $key)
				// {
				// 	echo $key.'<br/>';
				// }
				
				if (isset($param_integer[$i]) && $param_integer[$i] == $key)
				{
					echo $key;
				}

				$i++;
			}

			// $category_query 	 = isset($args['category']) ? 'where cid = :cid' : '';
			// $output_bindParam 	+= isset($args['category']) ? ['cid' => $args['category']] : [];

			// $output_bindParam 	+= isset($args['orderby']) ? ['orderby' => $args['orderby']] : ['orderby' => 'id'];
			// $output_bindParam 	+= isset($args['sort_order']) ? ['sort_order' => $args['sort_order']] : ['sort_order' => 'desc'];
			// $output_bindParam 	+= isset($args['numberposts']) ? ['numberposts' => $args['numberposts']] : ['numberposts' => 12];

			// $category 			 = isset($args['category']) ? 'where cid = '.is_int($args['category']) : '';
			// $orderby 			 = isset($args['orderby']) ?  (is_string($args['orderby']) ? $args['orderby'] : 'id') : 'id';
			// $sort_order 		 = isset($args['sort_order']) ? is_int($args['sort_order']) : 'desc';
			// $numberposts 		 = isset($args['numberposts']) ? is_int($args['numberposts']) : 12;

			/*
			if (isset($args['orderby']))
			{
				if (is_string($args['orderby']))
				{
					$orderby = $args['orderby'];
				}
				else
				{
					echo 'order by must be string';
					exit;
				}
			}
			else
			{
				$orderby = 'id';
			}

			if (isset($args['sort_order']))
			{
				if (is_string($args['sort_order']))
				{
					$sort_order = $args['sort_order'];
				}
				else
				{
					echo 'order by must be string desc or asc';
					exit;
				}
			}
			else
			{
				$sort_order = 'desc';
			}

			if (isset($args['numberposts']))
			{
				if (is_int($args['numberposts']))
				{
					$numberposts = $args['numberposts'];
				}
				else
				{
					echo 'numberposts must be integer';
					exit;
				}
			}
			else
			{
				$numberposts = 12;
			}
			*/
		}

		// $output_bindParam += ['test' => 'hello world'];

		// $res_post = $this->db->sql_select("select * from ml_".$post_type."_article ".$category." order by ".$orderby." ".$sort_order." limit ".$numberposts."");
		// $res_post = $this->db->sql_select("select * from ml_".$post_type."_article order by ".$orderby." ".$sort_order." limit ".$numberposts."");

		// print_r($res_post);
		exit;
	}

	public function hello()
	{
		return $this->get_posts('news', ['orderby' => 'id', 'sort_order' => 'desc', 'numberposts' => 12]);
	}

	public function testing()
	{
		// $config_site_function = new Aruna_Config_Site_Function;

		// $auth_function = new Aruna_Auth_Function;

		// $user_function = new Aruna_User_Function;

		auth_function()->do_auth();

		// $config_site_function->set_page_title('Hello World');

		// print_r($user_function->get_other_user(2, 'fullname'));

		// echo $user_function->get_status_user(1);

		set_page_title('Testing Hehehehehe');

		// echo get_page_title();

		// echo '<br/><br/>';

		// print_r(post_function()->get_posts('news'));

		$this->output
				 ->set_status_header(200)
				 ->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode(post_function()->get_posts('news', array('category' => '2', 'orderby' => 'id', 'order' => 'ASC', 'numberposts' => 2)), JSON_PRETTY_PRINT))
				 ->_display();

		// print_r($user_function->get_user_role(1, 'code_name'));

		// $var = false;

		// $var = ($var !== FALSE) ? $var : [];

		// $var['key'] = 'value';

		// print_r($var);

		// print_r($config_site_function->get_page_title());

		exit;
	}
}

?>