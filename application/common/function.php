<?php

	/*
	 *  Aruna Development Project
	 *  IS NOT FREE SOFTWARE
	 *  Codename: Ardev Cassandra
	 *  Source: Based on Sosiaku Social Networking Software
	 *  Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *  Created and developed by Andhika Adhitia N
	 */

	defined('APPPATH') OR exit('No direct script access allowed');

	// ------------------------------------------------------------------------

	/**
	 * Do Authentication
	 * 
	 * Berfungsi untuk otentikasi pengguna untuk mengakses halaman
	 *
	 * @return boolean
	 */
	
	function do_auth($uid = 0, $username = '', $token = '', $whitelist_role = array())
	{
		$roles = array();

		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select roles from ml_accounts where id = :id and username = :username and token = :token");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $uid, 'username' => $username, 'token' => $token], $res);
		while ($row = $Aruna->db->sql_fetch_single($bindParam))
		{
			$roles[] = $row['roles'];
		}

		if (is_array($whitelist_role))
		{
			foreach ($whitelist_role as $key) 
			{
				if (in_array($key, $roles))
				{
					return TRUE;
				}
			}
		}
		else 
		{
			if (is_array($roles) && in_array($whitelist_role, $roles))
			{
				return TRUE;
			}
		}	

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Has Access
	 * 
	 * Berfungsi untuk otentikasi pengguna untuk mengakses halaman
	 * 
	 * @return string
	 */

	function has_access($whitelist_role = array())
	{
		$id 		= isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
		$token		= isset($_SESSION['token']) ? $_SESSION['token'] : NULL;
		$username	= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

		if ( ! do_auth($id, $username, $token, $whitelist_role))
		{
			section_notice('<div class="card card-full-color card-full-warning" role="alert"><div class="card-body"><i class="fas fa-exclamation-triangle mr-1"></i> The page you requested cannot be displayed right now. It may be temporarily unavailable, the link you clicked on may be broken or expired, or you may not have permission to view this page.</div></div>');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Has Allow Access
	 * 
	 * Berfungsi untuk membatasi siapa saja pengguna yang dapat melihat fitur atau modul
	 *
	 * @return boolean
	 */

	function has_allow_access($whitelist_role = array())
	{
		$id 		= isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
		$token		= isset($_SESSION['token']) ? $_SESSION['token'] : NULL;
		$username	= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

		if ( ! do_auth($id, $username, $token, $whitelist_role))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Has Login
	 * 
	 * Berfungsi untuk memeriksa pengguna sudah login atau tidak
	 * 
	 * @return boolean
	 */

	function has_login()
	{
		$url = load_ext('url');

		if (empty($_SESSION['id']) && empty($_SESSION['username']) && empty($_SESSION['token']))
		{
			redirect('auth/login');
		}
		else
		{
			$Aruna =& get_instance();

			$res_token = $Aruna->db->sql_prepare("select token from ml_accounts where id = :id and username = :username");
			$bindParam_token = $Aruna->db->sql_bindParam(['id' => $_SESSION['id'], 'username' => $_SESSION['username']], $res_token);
			$row_token = $Aruna->db->sql_fetch_single($bindParam_token);

			if ($row_token['token'] != $_SESSION['token'])
			{
				$_SESSION['id'] = '';
				$_SESSION['username'] = '';
				$_SESSION['token'] = '';

				redirect('auth/login');
			}
			else
			{
				$res = $Aruna->db->sql_prepare("select status from ml_accounts where id = :id and username = :username and token = :token");
				$bindParam = $Aruna->db->sql_bindParam(['id' => $_SESSION['id'], 'username' => $_SESSION['username'], 'token' => $_SESSION['token']], $res);
				$row = $Aruna->db->sql_fetch_single($bindParam);

				if ($row['status'] == 1 && uri_string() != 'dashboard/checkpoint')
				{
					redirect('dashboard/checkpoint');
				}
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Avatar
	 * 
	 * Berfungsi untuk menampilkan foto avatar pengguna
	 *
	 * @return string
	 */

	function avatar($userid)
	{
		// Load URL Extension
		$url = load_ext('url');


		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select avatar from ml_user_information where user_id = :user_id");
		$bindParam = $Aruna->db->sql_bindParam(['user_id' => $userid], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['avatar'] = isset($row['avatar']) ? $row['avatar'] : '';

		if ( ! $row['avatar'])
		{
			$avatar = '';
		}
		else 
		{
			$avatar = base_url($row['avatar']);
		}

		return $avatar;
	}

	// ------------------------------------------------------------------------

	/**
	 * Avatar Alternative
	 * 
	 * Berfungsi untuk menampilkan foto avatar pengguna
	 *
	 * @return string
	 */

	function avatar_alt($id, $size = '', $class = NULL, $border = NULL)
	{
		// Load URL Extension
		$url = load_ext('url');


		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select avatar from ml_user_information where user_id = :user_id");
		$bindParam = $Aruna->db->sql_bindParam(['user_id' => $id], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		$row['avatar'] = isset($row['avatar']) ? $row['avatar'] : '';

		if ($border == 1)
		{
			$border = 'border: 1px #fff solid;';
		}

		if (empty($size))
		{
			if ( ! $row['avatar'])
			{
				$resize = 'style="font-size: 5em;"';
			}
			else 
			{
				$resize = 'style="width: 70px;height: 70px;'.$border.'"';
			}
		}
		else
		{
			if ( ! $row['avatar'])
			{
				if ( ! is_numeric($size) && $size == 'small')
				{
					$resize = 'style="width: 32px;height: 32px;vertical-align: middle;"';
				}
				else 
				{
					$resize = 'style="width: '.$size.'px;height: '.$size.'px;font-size: '.$size.'px;vertical-align: middle;"';
				}
			}
			else 
			{
				if ( ! is_numeric($size) && $size == 'small')
				{
					$resize = 'style="width: 32px;height: 32px;'.$border.'"';
				}
				else 
				{
					$resize = 'style="width: '.$size.'px;height: '.$size.'px;'.$border.'"';
				}
			}
		}

		if ( ! $row['avatar'])
		{
			$avatar = '<i class="fas fa-user-circle '.$class.'" '.$resize.'></i>';
		}
		else 
		{
			$avatar = '<img src="'.base_url($row['avatar']).'" class="rounded-circle '.$class.'" '.$resize.'>';
		}

		return $avatar;
	}

	// ------------------------------------------------------------------------
	
	function get_status_gender($key = '')
	{
		if ($key == 1)
		{
			$output = 'Male';
		}
		elseif ($key == 2) 
		{
			$output = 'Female';	
		}
		else
		{
			$output = 'Unknown';
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	function get_status_user($key = '')
	{
		if ($key == 0)
		{
			$output = '<span class="text-success">Active</span>';
		}
		elseif ($key == 1)
		{
			$output = '<span class="text-danger">Not active</span>';
		}
		else
		{
			$output = '<span class="text-muted">Unknown status</span>';
		}

		return $output;
	}

	// ------------------------------------------------------------------------
	
	function get_status_article($key = '', $with_style = FALSE)
	{
		if ($key == 0)
		{
			$output = ($with_style == TRUE) ? '<span class="badge bg-success">Publish</span>' : 'Publish';
		}
		elseif ($key == 1) 
		{
			$output = ($with_style == TRUE) ? '<span class="badge bg-secondary">Draft</span>' : 'Draft';	
		}
		elseif ($key == 2) 
		{
			$output = ($with_style == TRUE) ? '<span class="badge bg-danger">Deleted</span>' : 'Deleted';	
		}
		else
		{
			$output = ($with_style == TRUE) ? '<span class="badge bg-info">Unknown</span>' : 'Unknown';	
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Role
	 * 
	 * Berfungsi untuk mendapatkan atau menampilkan status atau peran akun pengguna.
	 *
	 * @return string
	 */

	function get_role($id = 0)
	{

		$Aruna =& get_instance();

		// $res = $Aruna->db->sql_prepare("select a.*, a.id as uid, r.* from ml_accounts as a join ml_roles as r on r.id = a.roles where r.code_name = a.role_code and a.id = :id");
		$res = $Aruna->db->sql_prepare("select name from ml_roles where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $id], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['name'] = isset($row['name']) ? $row['name'] : NULL;
	
		return $row['name'];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Role
	 * 
	 * Berfungsi untuk mendapatkan atau menampilkan status atau peran akun pengguna.
	 *
	 * @return string
	 */

	function get_role_all($id = 0)
	{

		$Aruna =& get_instance();

		// $res = $Aruna->db->sql_prepare("select a.*, a.id as uid, r.* from ml_accounts as a join ml_roles as r on r.id = a.roles where r.code_name = a.role_code and a.id = :id");
		$res = $Aruna->db->sql_prepare("select * from ml_roles where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $id], $res);
		$row = $Aruna->db->sql_fetch($bindParam);

		return $row[0];
	}

	// ------------------------------------------------------------------------

	function get_list_role()
	{

		$Aruna =& get_instance();

		$res = $Aruna->db->sql_select("select * from ml_roles order by id asc");
		while ($row = $Aruna->db->sql_fetch_single($res))
		{
			$row['id_in_string'] = ''.$row['id'].'';

			$output[] = $row;
		}
	
		return $output;
	}

// ------------------------------------------------------------------------

	function get_menu_parent($id, $coloum)
	{

		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_menu_parent where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $id], $res);
		$row = $Aruna->db->sql_fetch($bindParam);
	
		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;

		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Config Site
	 * 
	 * Berfungsi untuk mendapatkan atau menampilkan konfigurasi halaman situs
	 * seperti, nama situs, slogan, kata kunci, dsb.
	 *
	 * @return string
	 */

	function get_csite($key)
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_site_config where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => 1], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		if ($key == 'site_thumbnail')
		{
			$row['site_thumbnail']  = ! empty($row['site_thumbnail']) ? base_url($row['site_thumbnail']) : base_url('assets/images/aruna_card_1200.jpg');
		
			return $row['site_thumbnail'];
		}
		else
		{
			$row[$key] = isset($row[$key]) ? $row[$key] : NULL;

			return $row[$key];
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Config Title
	 * 
	 * Berfungsi untuk mendapatkan judul halaman situs
	 * 
	 * @return string
	 */

	function get_ctitle()
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_site_config where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => 1], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		if ( ! get_data_global('title'))
		{
			return $row['site_name'].' - '.$row['site_slogan'];
		}
		else 
		{
			return get_data_global('title').' - '.$row['site_name'];
		}	
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Client Value
	 * 
	 * Hampir sama fungsinya dengan fungsi get_client() fungsi ini menampilkan
	 * informasi data pengguna nama kolom yang dimasukkan.
	 * 
	 * @return string
	 */

	function get_client_value($key = '', $value = '',  $coloum = '')
	{

		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_accounts where $key = :$key");
		$bindParam = $Aruna->db->sql_bindParam([$key => $value], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;
	
		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Client
	 * 
	 * Hampir sama fungsinya dengan fungsi get_user() fungsi ini menampilkan
	 * informasi data pengguna per id akun bukan per session pengguna.
	 * 
	 * @return string
	 */

	function get_client($key = '',  $coloum = '')
	{

		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_accounts where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $key], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;
	
		return $row[$coloum];
	}

	function get_info_client($key = '',  $coloum = '')
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_user_information where user_id = :user_id");
		$bindParam = $Aruna->db->sql_bindParam(['user_id' => $key], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;
	
		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get User
	 * 
	 * Berfungsi untuk mendapatkan informasi data pengguna per session
	 * 
	 * @return string
	 */

	function get_user($key)
	{
		$Aruna 		=& get_instance();
		$id 		= isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
		$token		= isset($_SESSION['token']) ? $_SESSION['token'] : NULL;
		$username	= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

		$res = $Aruna->db->sql_prepare("select * from ml_accounts where id = :id and username = :username and token = :token");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $id, 'username' => $username, 'token' => $token], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$key] = isset($row[$key]) ? $row[$key] : NULL;
	
		return $row[$key];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Content Page
	 * 
	 * Berfungsi untuk mendapatkan konten untuk setiap masing-masing halaman depan
	 * bersifat dinamis karena bisa diganti melalui panel admin.
	 * 
	 * @return string
	 */

	function get_content_page($uri = '', $section = '', $column = '')
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select var from ml_pages where uri = :uri");
		$bindParam = $Aruna->db->sql_bindParam(['uri' => $uri], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		$json_decode = json_decode($row['var'], true);

		if ( empty($json_decode[$section]) || empty($json_decode[$section][$column]))
		{
			return '';
		}
		else
		{
			return $json_decode[$section][$column]['content'];
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Section Page
	 * 
	 * Berfungsi untuk mendapatkan konten untuk bagian header dan footer dihalaman depan
	 * bersifat dinamis karena bisa diganti melalui panel admin.
	 * 
	 * @return string
	 */

	function get_section_page($uri = '', $section = '', $column = '', $wlink = '')
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select vars from ml_section where uri = :uri");
		$bindParam = $Aruna->db->sql_bindParam(['uri' => $uri], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		$json_decode = json_decode($row['vars'], true);

		if ( empty($json_decode[$section]) || empty($json_decode[$section][$column]))
		{
			return '';
		}
		else
		{
			if ( ! isset($json_decode[$section][$column]['link']) && $wlink == 'wlink')
			{
				return '';
			}
			elseif (isset($json_decode[$section][$column]['link']) && $wlink == 'wlink')
			{
				return $json_decode[$section][$column]['link'];
			}
			else
			{
				return $json_decode[$section][$column]['content'];
			}
		}
	}

	// ------------------------------------------------------------------------

	function get_section_header($column = '')
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $Aruna->db->sql_bindParam(['uri' => 'header'], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$column] = isset($row[$column]) ? $row[$column] : NULL;

		if ($column == 'menu_position')
		{
			if ($row['menu_position'] == 'left')
			{
				$menu_position = 'd-lg-flex justify-content-lg-start';
			}
			elseif ($row['menu_position'] == 'center')
			{
				$menu_position = 'd-lg-flex justify-content-lg-center';
			}
			elseif ($row['menu_position'] == 'right')
			{
				$menu_position = 'd-lg-flex justify-content-lg-end';
			}

			return $menu_position;
		}

		if ($column == 'section_type')
		{
			if ($row['section_type'] == 'default')
			{
				return '';
			}
		}

		if ($column == 'margin_link')
		{
			return 'margin: '.$row['margin_top_link'].' '.$row['margin_right_link'].' '.$row['margin_bottom_link'].' '.$row['margin_left_link'];
		}

		if ($column == 'padding_link')
		{
			$padding = '';

			$padding .= ( ! empty($row['padding_top_link'])) ? 'padding-top: '.$row['padding_top_link'].';' : '';
			$padding .= ( ! empty($row['padding_right_link'])) ? 'padding-right: '.$row['padding_right_link'].';' : '';
			$padding .= ( ! empty($row['padding_bottom_link'])) ? 'padding-bottom: '.$row['padding_bottom_link'].';' : '';
			$padding .= ( ! empty($row['padding_left_link'])) ? 'padding-left: '.$row['padding_left_link'].';' : '';

			return $padding;
		}

		if ($column == 'border_radius_link')
		{
			$border = '';

			$border .= ( ! empty($row['border_top_left_radius_link'])) ? 'border-top-left-radius: '.$row['border_top_left_radius_link'].';' : '';
			$border .= ( ! empty($row['border_top_right_radius_link'])) ? 'border-top-right-radius: '.$row['border_top_right_radius_link'].';' : '';
			$border .= ( ! empty($row['border_bottom_left_radius_link'])) ? 'border-bottom-left-radius: '.$row['border_bottom_left_radius_link'].';' : '';			
			$border .= ( ! empty($row['border_bottom_right_radius_link'])) ? 'border-bottom-right-radius: '.$row['border_bottom_right_radius_link'].';' : '';
			
			return $border;
		}

		return $row[$column];
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Category
	 * 
	 * Berfungsi untuk mendapatkan konten untuk setiap masing-masing halaman depan
	 * bersifat dinamis karena bisa digantin melalui panel admin.
	 * 
	 * @return string
	 */

	function get_category(int $cid = 0, string $page = 'news')
	{
		$Aruna =& get_instance();

		if ($page == 'news')
		{
			$table_database = 'ml_news_category';
		}
		elseif ($page == 'event')
		{
			$table_database = 'ml_event_category';
		}
		elseif ($page == 'promotion')
		{
			$table_database = 'ml_promotion_category';
		}
		elseif ($page == 'portofolio')
		{
			$table_database = 'ml_portofolio_category';
		}

		$res = $Aruna->db->sql_prepare("select name from $table_database where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $cid], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		return $row['name'];
	}

	// ------------------------------------------------------------------------

	function get_module($name, $coloum)
	{
		$Aruna =& get_instance();	

		$res = $Aruna->db->sql_prepare("select * from ml_modules where name = :name");
		$bindParam = $Aruna->db->sql_bindParam(['name' => $name], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;

		if ( ! $row[$coloum])
		{
			return 'Could not find module <strong>'.$name.'</strong> in database';
		}

		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	function get_module_actived($module_name)
	{
		$Aruna =& get_instance();	

		$res = $Aruna->db->sql_prepare("select * from ml_modules where name = :name");
		$bindParam = $Aruna->db->sql_bindParam(['name' => $module_name], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['name'] = isset($row['name']) ? $row['name'] : NULL;

		if ( ! $row['name'])
		{
			return 'Could not find module <strong>'.$module_name.'</strong> in database';
		}

		return $row['actived'];
	}

	// ------------------------------------------------------------------------

	function get_role_page($page_name)
	{
		$Aruna =& get_instance();	

		$current_modules = array();

		$res = $Aruna->db->sql_prepare("select m.*, mp.parent_code, mp.roles from ml_modules as m left join ml_menu_parent as mp on mp.parent_code = m.name where m.type = 'menu' and mp.parent_code = :parent_code order by id");
		$bindParam = $Aruna->db->sql_bindParam(['parent_code' => $page_name], $res);
		while ($row = $Aruna->db->sql_fetch_single($res))
		{
			$current_modules = explode(",", $row['roles']);
		}

		if (in_array(get_user('roles'), $current_modules))
		{
			return TRUE;
		}	
		else
		{
			return FALSE;
		}
	}

	// ------------------------------------------------------------------------

	function get_logo($id, $coloum)
	{
		$Aruna =& get_instance();	

		$res = $Aruna->db->sql_prepare("select * from ml_logo where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => $id], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;

		if ( ! $row[$coloum])
		{
			return '';
		}

		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	function check_active_page($module_name, $style = array())
	{
		if (get_module_actived($module_name) == 0)
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

	// ------------------------------------------------------------------------

	function check_role_page($page_name)
	{
		if (get_role_page($page_name) == FALSE)
		{
			section_notice('
			<div class="bg-danger p-3 rounded mb-3 text-dark bg-opacity-25">
				<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> You do not have access to this page.
			</div>');
		}
	}

	// ------------------------------------------------------------------------

	function get_layout($page, $coloum, $section = 'main_content')
	{
		$Aruna =& get_instance();
	
		$res = $Aruna->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam = $Aruna->db->sql_bindParam(['page' => $page, 'section' => $section], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row[$coloum] = isset($row[$coloum]) ? $row[$coloum] : NULL;

		if ( ! $row[$coloum])
		{
			return '';
		}

		return $row[$coloum];
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Slideshow
	 * 
	 * Example:
	 * 
	 * add_slideshow('homepage')
	 * 
	 * @return string
	 */

	function add_slideshow($page)
	{
		$Aruna =& get_instance();

		$res_module = $Aruna->db->sql_prepare("select * from ml_modules where name = :name and type = :type and is_slideshow = :is_slideshow");
		$bindParam_module = $Aruna->db->sql_bindParam(['name' => $page, 'type' => 'page', 'is_slideshow' => 1], $res_module);
		$row_module = $Aruna->db->sql_fetch_single($bindParam_module);

		$res_layout = $Aruna->db->sql_prepare("select * from ml_layout where name = :name and section = :section");
		$bindParam_layout = $Aruna->db->sql_bindParam(['name' => $page, 'section' => 'slideshow'], $res_layout);
		$row_layout = $Aruna->db->sql_fetch_single($bindParam_layout);
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Cover Image
	 * 
	 * Example:
	 * 
	 * add_coverimage('homepage')
	 * 
	 * @return string
	 */

	function add_coverimage($page)
	{
		$Aruna =& get_instance();

		$res_module = $Aruna->db->sql_prepare("select * from ml_modules where name = :name and type = :type");
		$bindParam_module = $Aruna->db->sql_bindParam(['name' => $page, 'type' => 'page'], $res_module);
		$row_module = $Aruna->db->sql_fetch_single($bindParam_module);

		if ($row_module['is_coverimage'] == 1)
		{
			$path = APPPATH.'/views/widget/coverimage/widget_coverimage.php';

			if (file_exists($path))
			{
				require_once $path;

				if (method_exists('widget_content', 'index'))
				{
					$load_widget = new widget_content;

					// Access function content() from $path
					return $load_widget->index($page);
				}
				else
				{
					return '<div class="bg-danger bg-opacity-25 text-center rounded p-4 m-5">Error: function index() not exist</div>';
				}
			}
			else
			{
				return '<div class="bg-warning bg-opacity-25 text-center rounded p-4 m-5">Widget not found</div>';
			}
		}
	}

	// ------------------------------------------------------------------------

	function add_title_widget($string, $options = array('for_widget' => ''))
	{
		$GLOBALS['widget']['title'][$options['for_widget']] = $string;	
	}

	// ------------------------------------------------------------------------

	function add_caption_widget($string, $options = array('for_widget' => ''))
	{
		$GLOBALS['widget']['caption'][$options['for_widget']] = $string;	
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Widget
	 * 
	 * Example:
	 * 
	 * 1. Module Name
	 * 2. View Type: list, grid, grid-box
	 * 
	 * add_widget('news', 'grid', array('sortBy' => 'desc', 'limit' => 6))
	 * 
	 * @return string
	 */

	function add_widget($widget = '', $view_type = 'grid', $options = array('sortBy' => 'desc', 'limit' => 6))
	{
		$Aruna =& get_instance();

		$res_module = $Aruna->db->sql_prepare("select * from ml_modules where name = :name and type = :type");
		$bindParam_module = $Aruna->db->sql_bindParam(['name' => $widget, 'type' => 'page'], $res_module);
		$row_module = $Aruna->db->sql_fetch_single($bindParam_module);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_module = ($row_module !== FALSE) ? $row_module : [];

		if ($row_module['is_widget'] == 1)
		{
			$res_article = $Aruna->db->sql_select("select * from ml_".$widget."_article order by id ".$options['sortBy']." limit ".$options['limit']."");
			$row_article = $Aruna->db->sql_fetch($res_article);

			if ($view_type == 'grid')
			{
				include APPPATH.'views/widget/common/grid_view.php';

				return $output;
			}
			elseif ($view_type == 'grid_box')
			{
				include APPPATH.'views/widget/common/grid_box_view.php';

				return $output;
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Maintenance Mode
	 * 
	 * Berfungsi untuk mengubah status website menjadi mode maintenance
	 * 
	 * @return string
	 */

	function get_maintenance_mode()
	{
		$url = load_ext('url');

		if ($exclude_uris = config_item('mt_exclude_uris'))
		{
			$target = FALSE;

			foreach ($exclude_uris as $excluded)
			{
			    // Convert wildcards to RegEx
			    $excluded = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $excluded);
			    
				if (preg_match('#^'.$excluded.'$#i'.(UTF8_ENABLED ? 'u' : ''), uri_string()) || get_user('roles') == 99 || get_user('roles') == 98 || get_user('roles') == 97 || get_user('roles') == 96)
				{
					$target = TRUE;
				}
			}

			if ($target !== TRUE)
			{
				if (get_csite('offline_mode') == 1)
				{
					include APPPATH.'views/maintenance/maintenance.php';
					exit;
				}
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Language
	 * 
	 * Berfungsi untuk mendapatkan konfigurasi bahasa untuk pengguna
	 * 
	 * @return string
	 */

	function get_language()
	{
		$ext = load_ext(['cookie']);

		if (get_cookie('ml_language'))
		{
			$lang = get_cookie('ml_language');
		}
		else 
		{
			$lang = 'indonesian';
		}

		return $lang;
	}

	// ------------------------------------------------------------------------

	/**
	 * Init Language
	 * 
	 * 
	 * @return string
	 */

	function init_language()
	{
		$ext = load_ext(['cookie']);
		$allowed_language = ['english', 'indonesian'];

		if (get_cookie('ml_language'))
		{
			$lang = get_cookie('ml_language');
		}
		else 
		{
			$lang = 'indonesian';
		}

		foreach ($allowed_language as $key) 
		{
			if ($key == $lang)
			{
				$lang_list[] = '<i class="font-weight-bold">'.ucfirst($key).'</i>';
			}
			else
			{
				$lang_list[] = '<a href="'.site_url('awesome_admin/setlanguage?id='.$key).'">'.ucfirst($key).'</a>';
			}

			$lang_select = implode(' | ', $lang_list);
		}

		return $lang_select;
	}

	// ------------------------------------------------------------------------

	/**
	 * Init Language
	 * 
	 * 
	 * @return string
	 */

	function unselected_language()
	{
		$ext = load_ext(['cookie']);
		$allowed_language = ['english', 'indonesian'];

		if ( ! get_cookie('ml_language'))
		{
			$lang = 'indonesian';
		}
		else 
		{
			$lang = get_cookie('ml_language');
		}

		foreach ($allowed_language as $key) 
		{
			if ($key != $lang)
			{
				return '<a class="dropdown-item" href="'.site_url('home/setlanguage?id='.$key).'"><i class="fas fa-globe-europe fa-fw mr-1"></i> '.ucfirst($key).'</a>';
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Translate Function
	 * 
	 * Berfungsi untuk menterjemahkan bahasa yang diinginkan berdasarkan bahasa yang dipilih
	 * 
	 * @return string
	 */

	function t($str, $att1 = '', $att2 = '', $att3 = '', $godb = 0) 
	{

		$Aruna =& get_instance();

		$dbstr = addslashes($str);
		$res = $Aruna->db->sql_prepare("select * from ml_language where lang_from = :lang_from and lang = :lang limit 1");
		$bindParam = $Aruna->db->sql_bindParam(['lang_from' => $dbstr, 'lang' => get_language()], $res);

		if ( ! $Aruna->db->sql_counts($bindParam)) 
		{
			$insert_lang = [
				'lang_from'	=> $dbstr,
				'lang_to'	=> '',
				'lang'		=> get_language()
			];

			$Aruna->db->sql_insert($insert_lang, 'ml_language');
		}
		else 
		{
			$row = $Aruna->db->sql_fetch_single($bindParam);

			if (strlen($row['lang_to'])) 
			{
				$str = $row['lang_to'];
			}
			else 
			{
				$str = $row['lang_from'];
			}
		}

		if ($godb) 
		{
			$str = addslashes($str);
		}
	
		return str_replace(['{1}', '{2}', '{3}'], [$att1, $att2, $att3], $str);
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Set Meta Function
	 * 
	 * Berfungsi untuk set meta title, description, dan image dengan global variable
	 * 
	 * @return string
	 */

	function set_meta($url, $title, $description, $image)
	{	
		$GLOBALS['meta']['url'] = $url;	
		$GLOBALS['meta']['title'] = $title;
		$GLOBALS['meta']['description'] = $description;
		$GLOBALS['meta']['image'] = $image;
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Get Meta Description
	 * 
	 * Berfungsi untuk mendapatkan data meta description dari function set_meta()
	 * Jika value dari argument function get_meta() kosong atau global variable meta kosong otomatis akan mengambil meta
	 * dari database
	 * 
	 * @return string
	 */

	function get_meta($key)
	{
		$Aruna =& get_instance();

		$res = $Aruna->db->sql_prepare("select * from ml_site_config where id = :id");
		$bindParam = $Aruna->db->sql_bindParam(['id' => 1], $res);
		$row = $Aruna->db->sql_fetch_single($bindParam);

		if ($key == 'url')
		{
			$getResTitle = (empty($key) || ! isset($GLOBALS['meta']) || empty($GLOBALS['meta']['url'])) ? site_url() : $GLOBALS['meta']['url'];

			return $getResTitle;
		}
		elseif ($key == 'title')
		{
			$getResTitle = (empty($key) || ! isset($GLOBALS['meta']) || empty($GLOBALS['meta']['title'])) ? $row['site_name'] : $GLOBALS['meta']['title'];

			return $getResTitle;
		}
		elseif ($key == 'description')
		{
			$getResDescription = (empty($key) || ! isset($GLOBALS['meta']) || empty($GLOBALS['meta']['description'])) ? $row['site_slogan'] : $GLOBALS['meta']['description'];

			return $getResDescription;
		}
		elseif ($key == 'image')
		{
			$getResImage = (empty($key) || ! isset($GLOBALS['meta']) || empty($GLOBALS['meta']['image'])) ? get_csite('site_thumbnail') : base_url($GLOBALS['meta']['image']);

			return $getResImage;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Date
	 * 
	 * Berfungsi untuk mengubah waktu sistem UNIX dan menampilkan waktu umum
	 * 
	 * @return string
	 */

	function get_date($timeo, $type = 'time') 
	{
		// Default set timezone is +7 for Jakarta, Indonesia
		$timezone = +7;

		// Default set for some settings
		$settings = [
			'time_format' 	 => 'g:i a',
			'date_format' 	 => 'M jS Y',
			'date_today' 	 => 'Today',
			'date_yesterday' => 'Yesterday'
		];

		$timeline = $timeo+$timezone*3600;
		$current = time()+$timezone*3600;
		$it_s = intval($current - $timeline);
		$it_m = intval($it_s/60);
		$it_h = intval($it_m/60);
		$it_d = intval($it_h/24);
		$it_y = intval($it_d/365);

		$timec = time()-$timeo;

		if ($timec < 3600 && $timec >= 0) 
		{
			return ceil($timec/60).' minute ago';
		}
		elseif ($timec < 12*3600 && $timec >= 0) 
		{
			return ceil($timec/3600).' hours ago';
		}
		else 
		{
			if ($type == 'time') 
			{
				return gmdate($settings['date_format'].', '.$settings['time_format'], $timeline);
			}
			else 
			{
				return gmdate($settings['date_format'], $timeline);
			}
		}

		if ($type == 'date') 
		{
			return gmdate($settings['date_format'], $timeline);
		}
		else 
		{
			if (gmdate("j", $timeline) == gmdate("j", $current)) 
			{
				return $settings['date_today'].', '.gmdate($settings['time_format'], $timeline);
			}
			elseif (gmdate("j", $timeline) == gmdate("j", ($current-3600*24))) 
			{
				return $settings['date_yesterday'].', '.gmdate($settings['time_format'], $timeline);
			}
			return gmdate($settings['date_format'].', '.$settings['time_format'], $timeline);
		}
	}

	// ------------------------------------------------------------------------

	function get_list_menu()
	{
		$Aruna =& get_instance();

		// Define variable output before use by content below
		$output = null;

		$res_parent = $Aruna->db->sql_select("select pm.id, pm.roles as pm_roles, pm.parent_name as pm_name, pm.parent_code as pm_code, pm.icon as pm_icon, m.* from ml_menu_parent as pm right join ml_menu as m on m.menu_parent_id = pm.id where m.status = 0 group by m.menu_parent_code order by m.id asc");
		while ($row_parent = $Aruna->db->sql_fetch_single($res_parent))
		{
			$res_module = $Aruna->db->sql_prepare("select * from ml_modules where name = :name");
			$bindParam_module = $Aruna->db->sql_bindParam(['name' => $row_parent['pm_code']], $res_module);
			$row_module = $Aruna->db->sql_fetch_single($bindParam_module);

			// Prevent from Automatic conversion of false to array is deprecated
			$row_module = ($row_module !== FALSE) ? $row_module : [];

			$row_module['actived'] = isset($row_module['actived']) ? $row_module['actived'] : '';

			if ($row_parent['menu_parent_code'] == 'uncategorized_'.$row_parent['pm_code'])
			{
				if ($row_module['actived'] == 1)
				{
					if (in_array(get_user('roles'), explode(",", $row_parent['roles'])))
					{
						$output .= '<a href="'.site_url($row_parent['url']).'" class="list-group-item">'.$row_parent['icon'].' '.t($row_parent['menu_name']).'</a>';
					}
				}
			}
			else
			{
				if ($row_module['actived'] == 1)
				{
					if (in_array(get_user('roles'), explode(",", $row_parent['pm_roles'] ?? '')))
					{
						$output .= '										
						<a href="javascript:void(0)" class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-target="#Collapse'.$row_parent['pm_code'].'" role="button" aria-expanded="false" aria-controls="Collapse'.$row_parent['pm_code'].'"><span class="text-truncate">'.$row_parent['pm_icon'].' '.t($row_parent['pm_name']).'</span></a>

						<div class="collapse multi-collapse list-group-sub" id="Collapse'.$row_parent['pm_code'].'">
							<div class="list-group list-group-flush">';
					
								$res_menu = $Aruna->db->sql_prepare("select * from ml_menu where menu_parent_id = :menu_parent_id and status = 0 order by id");
								$bindParam_menu = $Aruna->db->sql_bindParam(['menu_parent_id' => $row_parent['menu_parent_id']], $res_menu);
								while ($row_menu = $Aruna->db->sql_fetch_single($bindParam_menu))
								{
									if (in_array(get_user('roles'), explode(",", $row_menu['roles'])))
									{
										$output .= '<a href="'.site_url($row_menu['url']).'" class="list-group-item list-group-item-action ps-5">'.$row_menu['icon'].' '.t($row_menu['menu_name']).'</a>';
									}
								}

						$output .= '
							</div>
						</div>';
					}
				}
			}
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	function get_list_menu_header()
	{
		$Aruna =& get_instance();

		$modules = array();

		$res = $Aruna->db->sql_select("select * from ml_modules where type = 'page' order by position asc");
		while ($row = $Aruna->db->sql_fetch_single($res))
		{
			$modules[$row['name']] = $row;
		}

		if ($handle = opendir('modules')) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				$module = array();
				$ignores = array('.svn');

				if (is_dir('modules/' .$file) && $file != '.' && $file != '..' && ! in_array($file, $ignores) && file_exists('modules/'.$file.'/'.$file.'.info')) 
				{
					$module['name'] = $file;

					if (file_exists('modules/'.$file.'/'.$file.'.info')) 
					{
						$filename = 'modules/'.$file.'/'.$file.'.info';
						$handle2 = fopen($filename, "r");
						$info = fread($handle2, filesize($filename));
						fclose($handle2);
						$arr = explode("\r\n", $info);

						foreach ($arr as $item) 
						{
							$info = explode('=',$item);
							$key = trim($info[0]);

							$value = trim($info[1]);
							$module[$key] = $value;
							$module['flag'] = $file;
						}
					}
					else 
					{
						$module['flag'] 		= $file;
						$module['version'] 		= 'Unknown';
						$module['description'] 	= '';
						$module['type'] 		= '';
						$module['manage_path'] 	= '';
					}

					$this_modules[$file] = $module;
				}
			}

			closedir($handle);
		}

		$output = '';

		foreach ($modules as $module) 
		{
			if ($module['actived'] == 1)
			{
				$output .= '
				<li class="nav-item" style="'.get_section_header('margin_link').'">
					<a class="nav-link '.getNavMenu($module['name']).'" style="'.get_section_header('padding_link').'" href="'.site_url($module['name']).'">'.$this_modules[$module['name']]['name'].'</a>
				</li>';
			}
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Format Size
	 * 
	 * Berfungsi untuk menampilkan ukuran berkas
	 * dalam satuan KB, MB, GB, TB, dsb.
	 * 
	 * @return string
	 */

	function format_size($file) 
	{
		if ( ! file_exists($file)) 
		{
			$bytes = '';
		}
		else {
			$bytes = filesize($file);
		}

		if ($bytes < 1024) 
		{
			return $bytes.' B';
		} 
		elseif ($bytes < 1048576) 
		{
			return round($bytes / 1024, 2).' KB';
		}
		elseif ($bytes < 1073741824) 
		{
			return round($bytes / 1048576, 2).' MB';
		}
		elseif ($bytes < 1099511627776) 
		{
			return round($bytes / 1073741824, 2).' GB';
		}
		elseif ($bytes < 1125899906842624) 
		{
			return round($bytes / 1099511627776, 2).' TB';
		}
		elseif ($bytes < 1152921504606846976) 
		{
			return round($bytes / 1125899906842624, 2).' PB';
		}
		elseif ($bytes < 1180591620717411303424) 
		{
			return round($bytes / 1152921504606846976, 2).' EB';
		}
		elseif ($bytes < 1208925819614629174706176) 
		{
			return round($bytes / 1180591620717411303424, 2).' ZB';
		}
		else 
		{
			return round($bytes / 1208925819614629174706176, 2).' YB';
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Register JS
	 * 
	 * Berfungsi untuk mendaftarkan file javascript per module
	 * 
	 * @return string
	 */

	function register_js($file = array())
	{
		$GLOBALS['register_js'] = implode("\r\n 			", $file);

		return $GLOBALS['register_js'];
	}

	// ------------------------------------------------------------------------

	/**
	 * Load JS
	 * 
	 * Berfungsi untuk menampilkan berkas javascript yang telah didaftarkan
	 * fungsi diletakan difolder tema
	 * 
	 * @return string
	 */

	function load_js()
	{
		return get_data_global('register_js');	
	}

	// ------------------------------------------------------------------------

	/**
	 * getNavMenu
	 * 
	 * Berfungsi untuk mendeteksi halaman, jika dihalaman yang lagi dibuka
	 * fungsi class pada menu navigasi akan aktif
	 * 
	 * @return string
	 */

	function getNavMenu(string $currect_page = '')
	{
		$ext = load_ext(['url']);

		return $currect_page === uri_string() ? 'active' : '';
	}

	// ------------------------------------------------------------------------

	function error_page($message = '', $style = array())
	{
		if (empty($message))
		{
			$message = '<h4 class="h5 font-weight-normal" style="line-height: 1.6">Sorry sweetheart, I can\'t find the page you requested <i class="far fa-frown ml-1 fa-lg"></i></h6><div class="mt-3"><a href="javascript:history.back();" class="text-white"><i class="fas fa-long-arrow-alt-left mr-2"></i> Back to Previous Page</a></div>';
		}

		section_notice('<div class="bg-danger bg-opacity-50 text-center rounded p-4 '.$style['style_class_name'].'">'.$message.'</div>');
	}

	// ------------------------------------------------------------------------

	if ( ! function_exists('cs_offset'))
	{
		function cs_offset()
		{
			return cs_num_per_page()*(get_data_global('page')-1);
		}
	}

	// ------------------------------------------------------------------------

	if ( ! function_exists('cs_num_per_page'))
	{
		function cs_num_per_page()
		{
			$cs_config = load_cs_config('config');

			return $cs_config->item('num_per_page_exam');
		}
	}

	// ------------------------------------------------------------------------

	if ( ! function_exists('breadcrumb'))
	{
		function breadcrumb($data = array(), $output = '')
		{
			if (is_array($data))
			{
				$output .= '
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb rounded" style="background-color: #e9ecef;padding: .75rem 1rem;">';

				foreach ($data as $key => $value) 
				{
					if (empty($value))
					{	
						$output .= '
							<li class="breadcrumb-item active" aria-current="page">'.$key.'</li>';
					}
					else
					{
						$output .= '
							<li class="breadcrumb-item active" aria-current="page"><a href="'.$value.'">'.$key.'</a></li>';
					}
				}

				$output .= '
					</ol>
				</nav>';

				return $output;
			}
			else
			{
				show_error('Invalid breadcrumb data.');
			}
		}
	}

?>