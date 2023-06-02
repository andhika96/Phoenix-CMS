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

class apps extends Aruna_Controller
{
	protected $ext;
	
	public function __construct() 
	{
	    parent::__construct();
	    
		$this->ext = load_ext(['url']);
	}

	public function index()
	{
		return view('index');
	}
}

?>