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

class manage 
{
	protected $session;

	protected $ext;

	protected $input;

	protected $db;

	protected $security;

	protected $csrf;

	protected $offset;

	protected $num_per_page;

	protected $formv;

	protected $output;
	
	public function __construct() 
	{
		$this->session = load_lib('session');

		$this->ext = load_ext(['url', 'text']);

		$this->input = load_lib('input');

		$this->security = load_lib('security');

		$this->formv = load_lib('form_validation');

		$this->output = load_lib('output');

		$this->db = load_db('default', 'MySQL');

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		// Active CSRF Protection
		$this->security->set_csrf(1);

		// Create variable array CSRF to get CSRF token name and CSRF Hash
		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		section_content('<style>.arv3-sub-content { overflow-x: hidden; }</style>');

		// Only role admin and webmaster is allowed
		has_access([99, 98]);

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		redirect('dashboard');
	}

	public function categories()
	{
		set_title('Manage Categories');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->formv->set_rules('newcategory', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_code = str_replace(" ", "", strtolower($this->input->post('newcategory')));
				$get_code = str_replace("&", "-", $get_code);
				$get_code = str_replace("/", "-", $get_code);

				$data = [
					'name' => $this->input->post('newcategory'),
					'code' => $get_code,
				];
				
				$this->db->sql_insert($data, 'ml_blog_category');

				echo json_encode(['status' => 'success', 'msg' => 'New category added!']);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('categories', $data);
	}

	public function editcategory($id)
	{
		set_title('Edit Category');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name from ml_blog_category where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->formv->set_rules('category', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_code = str_replace(" ", "", strtolower($this->input->post('category')));
				$get_code = str_replace("&", "-", $get_code);
				$get_code = str_replace("/", "-", $get_code);

				$data = [
					'name' => $this->input->post('category'),
					'code' => $get_code,
				];
				
				$this->db->sql_update($data, 'ml_blog_category', ['id' => $id]);

				echo json_encode(['status' => 'success', 'msg' => 'New category added!', 'url' => site_url('manage/categories')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editcategory', $data);
	}

	public function posts()
	{
		set_title('Manage Posts');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$data['db'] = $this->db;
		
		return view('posts', $data);
	}

	public function addpost()
	{
		set_title('Add Post');

		register_js([
			'<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>',
			'<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>',
			'<script src="'.base_url('assets/plugins/ckeditor5_3/build/ckeditor.js').'"></script>',
			'<script src="'.base_url('assets/plugins/ckfinder/ckfinder.js').'"></script>',
			'<script src="'.base_url('assets/js/cs-ckeditor5.js').'"></script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->formv->set_rules('title', 'Title', 'required|min_length[3]');
		$this->formv->set_rules('category', 'Category', 'required');
		$this->formv->set_rules('content', 'Content', 'required|callback_charlength');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if ( ! empty($_FILES['thumbnail']))
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/thumbs/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/thumbs/'.$dir.'/';

					if ( ! is_dir($s_folder)) 
					{
						mkdir($s_folder, 0777);
					}

					$configs['upload_path']		= $s_folder;
					$configs['allowed_types']	= 'jpg|jpeg|png';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 8000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('thumbnail'))
					{
						if ($_FILES['thumbnail']['error'] != 4)
						{	
							echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$thumb_l = FALSE;
						$thumb_s = FALSE;
						$status_upload = 1;
					}
					else 
					{
						$status_upload = 0;
						$thumb_l = $x_folder.$upload->data('file_name');
						$thumb_s = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $thumb_l;
						$cfg_img['create_thumb']	= true;
						$cfg_img['maintain_ratio']	= true;
						$cfg_img['width']			= 720;
						$cfg_img['quality']			= '80%';

						$image_lib = load_lib('image', $cfg_img);
						$image_lib->resize();
					}
				}

				$status_upload = 0;
				$uri = strtolower($this->input->post('title'));
				$uri = preg_replace("/[^a-z0-9_\s-]/", "", $uri);
				$uri = preg_replace("/[\s-]+/", " ", $uri);
				$uri = preg_replace("/[\s_]/", "-", $uri);

				$time = ( ! empty($this->input->post('schedule_pub'))) ? strtotime($this->input->post('schedule_pub').':0') : time();

				$data = [
					'title' 		=> $this->input->post('title'),
					'cid'	 		=> $this->input->post('category'),
					'content' 		=> $this->input->post('content', FALSE),
					'userid'		=> get_user('id'),
					'thumb_s'		=> $thumb_s,
					'thumb_l'		=> $thumb_l,
					'uri'			=> $uri,
					'schedule_pub'	=> $time,
					'created'	 	=> time()
				];
				
				if ($status_upload == 0)
				{
					$this->db->sql_insert($data, 'ml_blog_article');

					echo json_encode(['status' => 'success', 'msg' => 'New post added!', 'url' => site_url('manage/posts')]);
					exit;
				}
			}
		}

		$data['db'] = $this->db;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('addpost', $data);
	}

	public function editpost($id)
	{
		set_title('Edit Post');

		register_js([
			'<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>',
			'<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>',
			'<script src="'.base_url('assets/plugins/ckeditor5_3/build/ckeditor.js').'"></script>',
			'<script src="'.base_url('assets/plugins/ckfinder/ckfinder.js').'"></script>',
			'<script src="'.base_url('assets/js/cs-ckeditor5.js').'"></script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_blog_article where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;
		$row['content'] = isset($row['content']) ? $row['content'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->formv->set_rules('title', 'Title', 'required|min_length[3]');
		$this->formv->set_rules('category', 'Category', 'required');
		$this->formv->set_rules('content', 'Content', 'required|callback_charlength');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if ( ! empty($_FILES['thumbnail']))
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/thumbs/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/thumbs/'.$dir.'/';

					if ( ! is_dir($s_folder)) 
					{
						mkdir($s_folder, 0777);
					}

					$configs['upload_path']		= $s_folder;
					$configs['allowed_types']	= 'jpg|jpeg|png';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 8000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('thumbnail'))
					{
						if ($_FILES['thumbnail']['error'] != 4)
						{	
							echo json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$thumb_l = $row['thumb_l'];
						$thumb_s = $row['thumb_s'];
						$status_upload = 1;
					}
					else 
					{
						if (file_exists($row['thumb_l']))
						{
							unlink($row['thumb_l']);
						}

						if (file_exists($row['thumb_s']))
						{
							unlink($row['thumb_s']);
						}

						$status_upload = 0;
						$thumb_l = $x_folder.$upload->data('file_name');
						$thumb_s = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $thumb_l;
						$cfg_img['create_thumb']	= true;
						$cfg_img['maintain_ratio']	= true;
						$cfg_img['width']			= 720;
						$cfg_img['quality']			= '80%';

						$image_lib = load_lib('image', $cfg_img);
						$image_lib->resize();
					}
				}

				$status_upload = 0;
				$uri = strtolower($this->input->post('title'));
				$uri = preg_replace("/[^a-z0-9_\s-]/", "", $uri);
				$uri = preg_replace("/[\s-]+/", " ", $uri);
				$uri = preg_replace("/[\s_]/", "-", $uri);

				$getCurrentTimeSchedule = ($row['schedule_pub'] != $row['created']) ? $row['schedule_pub'] : time();

				$time = ( ! empty($this->input->post('schedule_pub'))) ? strtotime($this->input->post('schedule_pub').':0') : $getCurrentTimeSchedule;

				$data = [
					'title' 		=> $this->input->post('title'),
					'cid'	 		=> $this->input->post('category'),
					'content' 		=> $this->input->post('content', FALSE),
					'thumb_s'		=> $thumb_s,
					'thumb_l'		=> $thumb_l,
					'uri'			=> $uri,
					'schedule_pub' 	=> $time
				];
				
				if ($status_upload == 0)
				{
					$this->db->sql_update($data, 'ml_blog_article', ['id' => $row['id']]);

					echo json_encode(['status' => 'success', 'msg' => 'Post Edited', 'url' => site_url('manage/posts')]);
					exit;
				}
			}
		}

		$data['row'] = $row;
		$data['db'] = $this->db;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('editpost', $data);
	}

	public function gallery()
	{
		set_title('Manage Gallery');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->formv->set_rules('newcategory', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$total = $this->db->num_rows('ml_photo_category');

				if ($total >= 5)
				{
					echo json_encode(['status' => 'failed', 'msg' => 'The maximum gallery category is 5']);
					exit;
				}
				else
				{
					$get_code = str_replace(" ", "", strtolower($this->input->post('newcategory')));
					$get_code = str_replace("&", "-", $get_code);
					$get_code = str_replace("/", "-", $get_code);

					$data = [
						'name' 	  => $this->input->post('newcategory'),
						'caption' => $this->input->post('caption'),
						'code'	  => $get_code,
						'created' => time()
					];
					
					$this->db->sql_insert($data, 'ml_photo_category');

					echo json_encode(['status' => 'success', 'msg' => 'New category added!']);
					exit;
				}
			}
		}

		$data['db']	= $this->db;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('gallery', $data);
	}

	public function editgallery($id)
	{
		set_title('Edit Gallery');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name, caption from ml_photo_category where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['id'] = isset($row['id']) ? $row['id'] : '';
		$row['caption'] = isset($row['caption']) ? $row['caption'] : '';

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->formv->set_rules('editcategory', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->formv->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->formv->validation_errors('<div class="mb-2">', '</div>')]);
				exit;
			}
			else
			{
				$get_code = str_replace(" ", "", strtolower($this->input->post('editcategory')));
				$get_code = str_replace("&", "-", $get_code);
				$get_code = str_replace("/", "-", $get_code);

				$data = [
					'name' 		=> $this->input->post('editcategory'),
					'caption'	=> $this->input->post('caption'),
					'code'		=> $get_code,
				];
				
				$this->db->sql_update($data, 'ml_photo_category', ['id' => $row['id']]);

				echo json_encode(['status' => 'success', 'msg' => 'Gallery edited!', 'url' => site_url('manage/gallery')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['caption']   = $row['caption'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editgallery', $data);
	}

	public function listphotos($uri)
	{
		set_title('List of Photos');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_photo_category where code = :code");
		$bindParam = $this->db->sql_bindParam(['code' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['code'] = isset($row['code']) ? $row['code'] : '';

		if ( ! $row['code'] || ! is_string($row['code']))
		{
			error_page();
		}

		$data['db'] = $this->db;
		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('listphotos', $data);
	}

	public function pages()
	{
		set_title('Manage Pages');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$data['db'] = $this->db;

		return view('pages', $data);
	}

	public function editpage($uri = '')
	{
		set_title('Edit Page');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_pages where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		if ( ! $row['uri'] || ! is_string($row['uri']))
		{
			error_page();
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			$out = json_decode($row['var'], true);

			foreach ($out as $keys => $values) 
			{
				$section_title = str_replace("_", " ", $keys);
				$section_title = ucwords($section_title);

				foreach ($values as $key1 => $value1) 
				{
					if ($this->input->post('get_'.$keys) || ! empty($_FILES['get_'.$keys]))
					{
						if ($out[$keys][$key1]['type'] == 'file' && isset($_FILES['get_'.$keys]['name'][$key1]))
						{
							if ( ! empty($value1['alias']))
							{
								$label = str_replace("_", " ", $value1['alias']);
								$label = ucwords($label);
							}
							else
							{
								$label = str_replace("_", " ", $key1);
								$label = ucwords($label);
							}

							$_FILES['file']['name'] = $_FILES['get_'.$keys]['name'][$key1];
							$_FILES['file']['type'] = $_FILES['get_'.$keys]['type'][$key1];
							$_FILES['file']['tmp_name'] = $_FILES['get_'.$keys]['tmp_name'][$key1];
							$_FILES['file']['error'] = $_FILES['get_'.$keys]['error'][$key1];
							$_FILES['file']['size'] = $_FILES['get_'.$keys]['size'][$key1];

							$dir = date("Ym", time());
							$s_folder = './contents/userfiles/photos/'.$dir.'/';

							// For database only without dot and slash at the front folder
							$x_folder = 'contents/userfiles/photos/'.$dir.'/';

							if ( ! is_dir($s_folder)) 
							{
								mkdir($s_folder, 0777);
							}

							$configs['upload_path']		= $s_folder;
							$configs['allowed_types']	= 'jpg|jpeg|png|svg';
							$configs['overwrite']		= TRUE;
							$configs['remove_spaces']	= TRUE;
							$configs['encrypt_name']	= TRUE;
							$configs['max_size']		= 8000;

							$upload = load_lib('upload', $configs);

							if ( ! $upload->do_upload('file'))
							{
								if ($_FILES['file']['error'] != 4)
								{
									echo json_encode(['status' => 'failed', 'msg' => '<div class="text-break mb-2">('.$label.' in section '.$section_title.') :</div> '.$upload->display_errors('<span>', '</span>')]);
									exit;
								}

								$out[$keys][$key1]['content'] = $out[$keys][$key1]['content'];
							}
							else 
							{
								if (file_exists($out[$keys][$key1]['content']))
								{
									unlink($out[$keys][$key1]['content']);
								}

								$out[$keys][$key1]['content'] = $x_folder.$upload->data('file_name');
							}
							
						}
						elseif ($out[$keys][$key1]['type'] == 'text' || $out[$keys][$key1]['type'] == 'textarea')
						{
							$getData = str_replace('"', "'", $this->input->post('get_'.$keys)[$key1]);
							$out[$keys][$key1]['content'] = $getData;
						}
					}
				}
			}

			$this->db->sql_update(['var' => json_encode($out), 'updated' => time()], 'ml_pages', ['uri' => $row['uri']]);

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}
		
		$data['row'] = $row;
		$data['name_page'] = $row['name'];
		$data['db'] = $this->db;
		$data['input'] = $this->input;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('editpage', $data);
	}

	public function sections()
	{
		set_title('Manage Sections');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$data['db'] = $this->db;

		return view('sections', $data);
	}

	public function editsection($uri = '')
	{
		set_title('Edit Section');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res = $this->db->sql_prepare("select * from ml_section where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';

		if ( ! $row['uri'] || ! is_string($row['uri']))
		{
			error_page();
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			$out = json_decode($row['var'], true);

			foreach ($out as $keys => $values) 
			{
				$section_title = str_replace("_", " ", $keys);
				$section_title = ucwords($section_title);

				foreach ($values as $key1 => $value1) 
				{
					if ($this->input->post('get_'.$keys) || ! empty($_FILES['get_'.$keys]))
					{
						if ($out[$keys][$key1]['type'] == 'file' && isset($_FILES['get_'.$keys]['name'][$key1]))
						{
							if ( ! empty($value1['alias']))
							{
								$label = str_replace("_", " ", $value1['alias']);
								$label = ucwords($label);
							}
							else
							{
								$label = str_replace("_", " ", $key1);
								$label = ucwords($label);
							}

							$_FILES['file']['name'] = $_FILES['get_'.$keys]['name'][$key1];
							$_FILES['file']['type'] = $_FILES['get_'.$keys]['type'][$key1];
							$_FILES['file']['tmp_name'] = $_FILES['get_'.$keys]['tmp_name'][$key1];
							$_FILES['file']['error'] = $_FILES['get_'.$keys]['error'][$key1];
							$_FILES['file']['size'] = $_FILES['get_'.$keys]['size'][$key1];

							$dir = date("Ym", time());
							$s_folder = './contents/userfiles/photos/'.$dir.'/';

							// For database only without dot and slash at the front folder
							$x_folder = 'contents/userfiles/photos/'.$dir.'/';

							if ( ! is_dir($s_folder)) 
							{
								mkdir($s_folder, 0777);
							}

							$configs['upload_path']		= $s_folder;
							$configs['allowed_types']	= 'jpg|jpeg|png|svg';
							$configs['overwrite']		= TRUE;
							$configs['remove_spaces']	= TRUE;
							$configs['encrypt_name']	= TRUE;
							$configs['max_size']		= 8000;

							$upload = load_lib('upload', $configs);

							if ( ! $upload->do_upload('file'))
							{
								if ($_FILES['file']['error'] != 4)
								{
									echo json_encode(['status' => 'failed', 'msg' => '<div class="text-break mb-2">('.$label.' in section '.$section_title.') :</div> '.$upload->display_errors('<span>', '</span>')]);
									exit;
								}

								$out[$keys][$key1]['content'] = $out[$keys][$key1]['content'];
							}
							else 
							{
								if (file_exists($out[$keys][$key1]['content']))
								{
									unlink($out[$keys][$key1]['content']);
								}

								$out[$keys][$key1]['content'] = $x_folder.$upload->data('file_name');
							}
							
						}
						elseif ($out[$keys][$key1]['type'] == 'text' || $out[$keys][$key1]['type'] == 'textarea')
						{
							$getData = str_replace('"', "'", $this->input->post('get_'.$keys)[$key1]);
							$out[$keys][$key1]['content'] = $getData;

							if (isset($out[$keys][$key1]['link']))
							{	
								$getData2 = str_replace('"', "'", $this->input->post('get_'.$keys)[$key1.'_link']);
								$out[$keys][$key1]['link'] = $getData2;
							}
						}
					}
				}
			}

			$this->db->sql_update(['var' => json_encode($out), 'updated' => time()], 'ml_section', ['uri' => $row['uri']]);

			echo json_encode(['status' => 'success', 'msg' => 'Success']);
			exit;
		}
		
		$data['row'] = $row;
		$data['name_page'] = $row['name'];
		$data['db'] = $this->db;
		$data['input'] = $this->input;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('editsection', $data);
	}

	public function contactus()
	{
		set_title('Manage Contact Us');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$data['db'] = $this->db;

		return view('contactus', $data);
	}

	public function filemanager()
	{
		set_title('File Manager');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		return view('filemanager');		
	}

	public function getListPosts()
	{
		$timezone  = +7;

		$res_getTotal = $this->db->sql_prepare("select count(*) as num from ml_blog_article where (cid like :cid and title like :title)");
		$bindParam_getTotal = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('title').'%'], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_blog_article where (cid like :cid and title like :title) order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('title').'%'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumb_s'] 	 = ( ! empty($row['thumb_s'])) ? (file_exists($row['thumb_s']) ? base_url($row['thumb_s']) : 'undefined') : '';
			$row['content'] 	 = strip_tags(ellipsize($row['content'], 145));
			$row['content'] 	 = preg_replace("/&#?[a-z0-9]+;/i",'', $row['content']);
			$row['created_post'] = get_date($row['created']);
			$row['scheduled']	 = ($row['schedule_pub'] != $row['created']) ? '<span class="badge badge-success">Scheduled for '.gmdate("M jS Y, g:i a", $row['schedule_pub']+$timezone*3600).'</span>' : '';

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No article'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function deletepost($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_blog_article", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select thumb_l, thumb_s from ml_blog_article where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			if (file_exists($row['thumb_l']))
			{
				unlink($row['thumb_l']);
			}

			if (file_exists($row['thumb_s']))
			{
				unlink($row['thumb_s']);
			}

			$this->db->sql_delete("ml_blog_article", ['id' => $id]);
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}

	public function getListCategories()
	{
		$res = $this->db->sql_select("select * from ml_blog_category order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$output[] = $row;
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deletecategory($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_blog_category", "", ['id' => $id]);

		if ($check)
		{
			$this->db->sql_delete("ml_blog_category", ['id' => $id]);
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}

	public function getListGallery()
	{
		$res = $this->db->sql_select("select * from ml_photo_category order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$res_ltphoto = $this->db->sql_prepare("select thumbnail from ml_photos where cid = :cid order by id desc limit 1");
			$bindParam_ltphoto = $this->db->sql_bindParam(['cid' => $row['id']], $res_ltphoto);
			$row_ltphoto = $this->db->sql_fetch_single($bindParam_ltphoto);

			$row_ltphoto['thumbnail'] = isset($row_ltphoto['thumbnail']) ? base_url($row_ltphoto['thumbnail']) : '';
			$row['thumbnail'] = $row_ltphoto['thumbnail'];
			$row['caption'] = strip_tags(ellipsize($row['caption'], 175));
			$row['caption'] = preg_replace("/&#?[a-z0-9]+;/i",'', $row['caption']);

			$output[] = $row;
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deletegallery($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_photo_category", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select id, thumbnail, uri from ml_photos where cid = :cid");
			$bindParam = $this->db->sql_bindParam(['cid' => $id], $res);
			while ($row = $this->db->sql_fetch_single($bindParam))
			{
				if ($this->db->sql_counts($bindParam))
				{
					if (file_exists($row['thumbnail']))
					{
						unlink($row['thumbnail']);
					}

					if (file_exists($row['uri']))
					{
						unlink($row['uri']);
					}

					$this->db->sql_delete("ml_photos", ['cid' => $id]);
				}
			}

			$this->db->sql_delete("ml_photo_category", ['id' => $id]);

			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}

	public function getListPhotos($cid = '')
	{
		$count_page = $this->db->num_rows('ml_photos', '', ['cid' => $cid]);
		$totalpage = ceil($count_page/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_photos where cid = :cid order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => $cid], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumbnail'] = ( ! empty($row['thumbnail'])) ? (file_exists($row['thumbnail']) ? base_url($row['thumbnail']) : 'undefined') : '';
			$row['uri'] = ( ! empty($row['uri'])) ? (file_exists($row['uri']) ? base_url($row['uri']) : 'undefined') : '';

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'Not photo'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deletephoto($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_photos", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select thumbnail, uri from ml_photos where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			if (file_exists($row['thumbnail']))
			{
				unlink($row['thumbnail']);
			}

			if (file_exists($row['uri']))
			{
				unlink($row['uri']);
			}

			$this->db->sql_delete("ml_photos", ['id' => $id]);
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'success'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
		else
		{
			$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode(['status' => 'failed'], JSON_PRETTY_PRINT))
					 ->_display();
			exit;
		}
	}

	public function getUploadPhoto()
	{
		$total = $this->db->num_rows('ml_photos', 'num', ['cid' => $this->input->post('getcatid')]);

		if ($total['num'] >= 50)
		{
			$this->output->set_content_type('application/json', 'utf-8')
						 ->set_header('Access-Control-Allow-Origin: '.site_url())
						 ->set_header('HTTP/1.0 400 Bad Request')
						 ->set_output(json_encode(['status' => 'failed', 'msg' => 'Could not upload because it has reached the upload limit of 50'], JSON_PRETTY_PRINT))
						 ->_display();
			exit;
		}
		else
		{
			if ( ! empty($_FILES['photos']) && count($_FILES['photos']['name']) > 0)
			{
				for ($i = 0; $i < count($_FILES['photos']['name']); $i++)
				{
					$dir = date("Ym", time());
					$s_folder = './contents/userfiles/gallery/'.$dir.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/gallery/'.$dir.'/';

					if ( ! is_dir($s_folder)) 
					{
						mkdir($s_folder, 0777);
					}
					
					$_FILES['file']['name'] = $_FILES['photos']['name'][$i];
					$_FILES['file']['type'] = $_FILES['photos']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['photos']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['photos']['error'][$i];
					$_FILES['file']['size'] = $_FILES['photos']['size'][$i];

					$configs['upload_path']		= $s_folder;
					$configs['allowed_types']	= 'jpg|jpeg|png|svg|webp';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 8000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('file'))
					{
						if ($_FILES['file']['error'] != 4)
						{	
							$this->output->set_content_type('application/json', 'utf-8')
										 ->set_header('Access-Control-Allow-Origin: '.site_url())
										 ->set_header('HTTP/1.0 400 Bad Request')
										 ->set_output(json_encode(['status' => 'failed', 'msg' => $upload->display_errors('<span>', '</span>')], JSON_PRETTY_PRINT))
										 ->_display();
							exit;
						}

						$photos = FALSE;
						$thumb  = FALSE;
					}
					else 
					{
						$photos = $x_folder.$upload->data('file_name');
						$thumb  = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $photos;
						$cfg_img['create_thumb']	= true;
						$cfg_img['maintain_ratio']	= true;
						$cfg_img['width']			= 720;
						$cfg_img['quality']			= '80%';

						$image_lib = load_lib('image', $cfg_img);
						$image_lib->resize();
					}

					$data = [
						'cid'		=> $this->input->post('getcatid'),
						'uri'		=> $photos,
						'thumbnail'	=> $thumb,
						'created'	=> time()
					];

					$this->db->sql_insert($data, 'ml_photos');
				}
			
				$this->output->set_content_type('application/json', 'utf-8')
							 ->set_header('Access-Control-Allow-Origin: '.site_url())
							 ->set_output(json_encode(['status' => 'success', 'msg' => 'Ok'], JSON_PRETTY_PRINT))
							 ->_display();
				exit;
			}
			else
			{
				$this->output->set_content_type('application/json', 'utf-8')
							 ->set_header('Access-Control-Allow-Origin: '.site_url())
							 ->set_header('HTTP/1.0 400 Bad Request')
							 ->set_output(json_encode(['status' => 'failed', 'msg' => 'Request fail'], JSON_PRETTY_PRINT))
							 ->_display();
				exit;
			}
		}
	}
}

?>