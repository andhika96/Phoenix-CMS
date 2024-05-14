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

class Aruna_User_Function
{
	protected $table_prefix = 'ml_';

	protected $config_site;

	protected $auth_function;

	protected $extension = [];

	protected $status_user = [0 => 'active', 1 => 'not active'];

	protected $status_gender = [0 => 'female', 1 => 'male'];

	protected $Aruna;

	public function __construct()
	{
		$this->Aruna =& get_instance();

		$this->extension = load_ext('url');

		$this->config_site = config_site_function();

		$this->auth_function = auth_function();
	}

	public function get_current_user_id()
	{
		$get_session_current_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

		return $get_session_current_user_id;
	}

	public function get_user(string $field = '')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."accounts WHERE id = :id AND username = :username");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $this->auth_function->check_login_session('id'), 'username' => $this->auth_function->check_login_session('username')], $res);
		
		if ( ! empty($field))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			// Ternary variable validation
			$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

			return $row[$field];
		}
		elseif (empty($field))
		{
			return $this->Aruna->db->sql_fetch($bindParam);
		}
	}

	public function get_user_info(string $field = '')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."user_information WHERE user_id = :user_id");
		$bindParam = $this->Aruna->db->sql_bindParam(['user_id' => $this->auth_function->check_login_session('id')], $res);
		
		if ( ! empty($field))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			// Ternary variable validation
			$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

			return $row[$field];
		}
		elseif (empty($field))
		{
			return $this->Aruna->db->sql_fetch($bindParam);
		}
	}

	public function get_other_user(int $id = 0, string $field = '')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."accounts WHERE id = :id");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $id], $res);
		
		if ( ! empty($field))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			// Ternary variable validation
			$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

			return $row[$field];
		}
		elseif (empty($field))
		{
			return $this->Aruna->db->sql_fetch($bindParam);
		}
	}

	public function get_other_user_info(int $id = 0, string $field = '')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."user_information WHERE user_id = :user_id");
		$bindParam = $this->Aruna->db->sql_bindParam(['user_id' => $id], $res);
		
		if ( ! empty($field))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			// Ternary variable validation
			$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

			return $row[$field];
		}
		elseif (empty($field))
		{
			return $this->Aruna->db->sql_fetch($bindParam);
		}
	}

	public function get_status_user(int $status_id = 0, string $field = 'name')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."account_status WHERE id = :id");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $status_id], $res);
		$row = $this->Aruna->db->sql_fetch_single($bindParam);

		// Ternary variable validation
		$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

		return $row[$field];
	}

	public function get_status_gender(int $gender_id = 0, string $field = 'name')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."gender WHERE id = :id");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $gender_id], $res);
		$row = $this->Aruna->db->sql_fetch_single($bindParam);

		// Ternary variable validation
		$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

		return $row[$field];
	}

	public function get_role_user(int $role_id = 0, string $field = 'name')
	{
		$res = $this->Aruna->db->sql_prepare("SELECT * FROM ".$this->table_prefix."roles WHERE id = :id");
		$bindParam = $this->Aruna->db->sql_bindParam(['id' => $role_id], $res);
		$row = $this->Aruna->db->sql_fetch_single($bindParam);

		// Ternary variable validation
		$row[$field] = isset($row[$field]) ? $row[$field] : NULL;

		return $row[$field];
	}

	public function get_avatar_user(int $id = 0)
	{
		$res = $this->Aruna->db->sql_prepare("SELECT avatar FROM ".$this->table_prefix."user_information WHERE user_id = :user_id");
		$bindParam = $this->Aruna->db->sql_bindParam(['user_id' => $id], $res);
		
		if ($this->Aruna->db->sql_counts($bindParam))
		{
			$row = $this->Aruna->db->sql_fetch_single($bindParam);

			// Ternary variable validation
			$row['avatar'] = ( ! empty($row['avatar'])) ? base_url($row['avatar']) : '';

			return $row['avatar'];
		}
	}

	public function get_avatar_user_alt($user_id = 0, $size = 'small', $type = 'square', $with_class = NULL, $with_style = NULL)
	{
		if ($size == 'extra-small' || $size == 'small' || $size == 'medium' || $size == 'large' || $size == 'extra-large')
		{
			if ($size == 'extra-small')
			{
				$size_avatar = 'width: 25px;';
				$size_avatar_undefined = 'font-size: 1.563rem;';
			}
			elseif ($size == 'small')
			{
				$size_avatar = 'width: 35px;';
				$size_avatar_undefined = 'font-size: 2.188rem;';
			}
			elseif ($size == 'medium')
			{
				$size_avatar = 'width: 50px;';
				$size_avatar_undefined = 'font-size: 3.125rem;';
			}
			elseif ($size == 'large')
			{
				$size_avatar = 'width: 70px;';
				$size_avatar_undefined = 'font-size: 4.375rem;';
			}
			elseif ($size == 'extra-large')
			{
				$size_avatar = 'width: 100px;';
				$size_avatar_undefined = 'font-size: 6.25rem;';
			}
		}
		else
		{
			$size_avatar = 'width: '.$size.';';
			$size_avatar_undefined = 'font-size: 2.188rem;';
		}

		if ($type == 'square')
		{
			$type_avatar = 'rounded-0';
		}
		elseif ($type == 'square-rounded')
		{
			$type_avatar = 'rounded';
		}
		elseif ($type == 'rounded-circle')
		{
			$type_avatar = 'rounded-circle';
		}

		$output = ( ! empty($this->get_avatar_user($user_id))) ? '<img src="'.$this->get_avatar_user($user_id).'" class="'.$type_avatar.' '.$with_class.'" style="'.$size_avatar.$with_style.'">' : '<i class="fas fa-user-circle '.$with_class.'" style="'.$size_avatar_undefined.$with_style.'"></i>';
	
		return $output;
	}
}

?>