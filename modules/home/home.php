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
}

?>