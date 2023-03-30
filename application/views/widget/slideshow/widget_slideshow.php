<?php

class widget_content
{
	public function index($page)
	{
		$Aruna =& get_instance();

		$res_module = $Aruna->db->sql_prepare("select * from ml_modules where name = :name and type = :type");
		$bindParam_module = $Aruna->db->sql_bindParam(['name' => $page, 'type' => 'page'], $res_module);
		$row_module = $Aruna->db->sql_fetch_single($bindParam_module);

		return 'Hello World '.$row_module['name'];
	}

	protected function slideshow_layout1()
	{

	}

	protected function slideshow_layout2()
	{
		
	}
}

?>