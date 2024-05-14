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

class manage_event extends Aruna_Controller
{
	protected $csrf;

	protected $offset;

	protected $num_per_page;
	
	public function __construct() 
	{
		parent::__construct();

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		// Create variable array CSRF to get CSRF token name and CSRF Hash
		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		page_function()->check_active_page();

		page_function()->check_access_page();

		auth_function()->do_auth();
	}

	public function index()
	{
		set_title('List of Event');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$data['db'] = $this->db;
		
		return view('index', $data);
	}

	public function category()
	{
		set_title('Manage Category');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('newcategory', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
				
				$this->db->sql_insert($data, 'ml_event_category');

				echo json_encode(['status' => 'success', 'message' => 'New category added!']);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('category', $data);
	}

	public function editcategory($id)
	{
		set_title('Edit Category');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name from ml_event_category where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->form_validation->set_rules('category', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
				
				$this->db->sql_update($data, 'ml_event_category', ['id' => $id]);

				echo json_encode(['status' => 'success', 'url' => site_url('manage_event/category')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editcategory', $data);
	}

	public function addpost()
	{
		set_title('Add Post');

		register_js([
			'<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>',
			'<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>',
			'<script src="'.base_url('assets/plugins/ckeditor5/build/ckeditor.js?v=0.0.3').'"></script>',
			'<script src="'.base_url('assets/plugins/ckfinder/ckfinder.js').'"></script>',
			'<script src="'.base_url('assets/js/cs-ckeditor5.js?v=0.0.3').'"></script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required|callback_charlength');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->input->post('check_schedule_posts') == 1)
		{
			$this->form_validation->set_rules('schedule_pub', 'Schedule Posts', 'required');
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if ( ! empty($_FILES['thumbnail']))
				{
					$dir_yearmonth	= date("Ym", time());
					$subdir_date	= 'date_'.date("d", time());

					// For database only with dot and slash at the front folder
					$s_parentfolder = './contents/userfiles/event/'.$dir_yearmonth.'/';
					$s_subfolder = './contents/userfiles/event/'.$dir_yearmonth.'/'.$subdir_date.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/event/'.$dir_yearmonth.'/'.$subdir_date.'/';

					if ( ! is_dir($s_parentfolder)) 
					{
						mkdir($s_parentfolder, 0777);
					}

					if ( ! is_dir($s_subfolder)) 
					{
						mkdir($s_subfolder, 0777);
					}

					$configs['upload_path']		= $s_subfolder;
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
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$thumb_l = FALSE;
						$thumb_s = FALSE;
						$thumb_s2 = FALSE;
						$status_upload = 1;
					}
					else 
					{
						$status_upload = 0;
						$thumb_l = $x_folder.$upload->data('file_name');
						$thumb_s = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');
						$thumb_s2 = $x_folder.$upload->data('raw_name').'_thumb2'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $thumb_l;
						$cfg_img['create_thumb']	= true;
						$cfg_img['maintain_ratio']	= true;
						$cfg_img['width']			= 720;
						$cfg_img['quality']			= '80%';

						$image_lib = load_lib('image');

						$image_lib->initialize($cfg_img);
						$image_lib->resize();
						$image_lib->clear();

						// Find smallest dimension
						$imageSize = $image_lib->get_image_properties($cfg_img['source_image'], TRUE);
						$newSize = min($imageSize);

						$cfg_img2['image_library']		= 'gd2';
						$cfg_img2['source_image']		= $thumb_l;
						$cfg_img2['new_image']			= $upload->data('raw_name').'_thumb2'.$upload->data('file_ext');
						$cfg_img2['create_thumb']		= false;
						$cfg_img2['maintain_ratio']		= false;

						if ($upload->data('image_width') > $upload->data('image_height')) 
						{
							$cfg_img2['width'] 	= $upload->data('image_height');
							$cfg_img2['height'] = $upload->data('image_height');
							$cfg_img2['x_axis'] = (($upload->data('image_width') / 2) - ($cfg_img2['width'] / 2));
						}
						else 
						{
							$cfg_img2['height'] = $upload->data('image_width');
							$cfg_img2['width'] 	= $upload->data('image_width');
							$cfg_img2['y_axis'] = (($upload->data('image_height') / 2) - ($cfg_img2['height'] / 2));
						}

						$image_lib2 = load_lib('image');
						$image_lib2->initialize($cfg_img2);
						$image_lib2->crop();
					}
				}

				$status_upload = 0;
				$uri = strtolower($this->input->post('title'));
				$uri = preg_replace("/[^a-z0-9_\s-]/", "", $uri);
				$uri = preg_replace("/[\s-]+/", " ", $uri);
				$uri = preg_replace("/[\s_]/", "-", $uri);

				if ($this->input->post('uri') !== '')
				{
					$slug = strtolower($this->input->post('uri'));
					$slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
					$slug = preg_replace("/[\s-]+/", " ", $slug);
					$slug = preg_replace("/[\s_]/", "-", $slug);
				}
				else
				{
					$slug = $uri;
				}

				$schedule_pub 	= ($this->input->post('check_schedule_posts') == 1) ? strtotime($this->input->post('schedule_pub')) : '';
				$event_date 	= strtotime($this->input->post('event_date'));

				$data = [
					'title' 			=> $this->input->post('title'),
					'cid'	 			=> $this->input->post('category'),
					'content' 			=> $this->input->post('content', FALSE),
					'event_location'	=> $this->input->post('event_location'),
					'event_address'	 	=> $this->input->post('event_address'),
					'status' 			=> $this->input->post('status'),
					'userid'			=> user_function()->get_user('id'),
					'thumb_s'			=> $thumb_s,
					'thumb_s2'			=> $thumb_s2,
					'thumb_l'			=> $thumb_l,
					'uri'				=> $slug,
					'event_date'		=> $event_date,
					'schedule_pub'		=> $schedule_pub,
					'created'	 		=> time()
				];
				
				if ($status_upload == 0)
				{
					$this->db->sql_insert($data, 'ml_event_article');

					// Get latest ID
					$getLatestID = $this->db->insert_id();

					$this->setseo($getLatestID);

					echo json_encode(['status' => 'success', 'url' => site_url('manage_event/editpost/'.$getLatestID)]);
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

		$res = $this->db->sql_prepare("select * from ml_event_article where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$res_metatag = $this->db->sql_prepare("select * from ml_metatag_article where article_id = :article_id and type = :type");
		$bindParam_metatag = $this->db->sql_bindParam(['article_id' => $id, 'type' => 'event'], $res_metatag);
		$row_metatag = $this->db->sql_fetch_single($bindParam_metatag);

		$timezone  			= +7;
		$get_schedule_posts = ( ! empty($row['schedule_pub'])) ? gmdate("m/d/Y G:i", $row['schedule_pub']+$timezone*3600) : gmdate("m/d/Y G:i", time()+$timezone*3600);
		$get_event_date		= ( ! empty($row['event_date'])) ? gmdate("m/d/Y G:i", $row['event_date']+$timezone*3600) : gmdate("m/d/Y G:i", time()+$timezone*3600);

		register_js([
			'<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>',
			'<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>',
			'<script src="'.base_url('assets/plugins/ckeditor5/build/ckeditor.js').'"></script>',
			'<script src="'.base_url('assets/plugins/ckfinder/ckfinder.js').'"></script>',
			'<script src="'.base_url('assets/js/cs-ckeditor5.js').'"></script>',
			'<script>
				$(".ar-schedule-pub2").daterangepicker(
				{
					singleDatePicker: true,
					timePicker: true,
					timePicker24Hour: true,
					autoUpdateInput: true,
					startDate: "'.$get_schedule_posts.'",
					locale:
					{
						format: "MM/DD/YYYY HH:mm"
					}
				},
				function(ev, picker)
				{
					$(this).val(picker.format("MM/DD/YYYY HH:mm:00"));	
				});

				$(".ar-event-date").daterangepicker(
				{
					singleDatePicker: true,
					timePicker: true,
					timePicker24Hour: true,
					autoUpdateInput: true,
					startDate: "'.$get_event_date.'",
					locale:
					{
						format: "MM/DD/YYYY HH:mm"
					}
				},
				function(ev, picker)
				{
					$(this).val(picker.format("MM/DD/YYYY HH:mm:00"));	
				});
			</script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		// Prevent from Automatic conversion of false to array is deprecated
		$row_metatag = ($row_metatag !== FALSE) ? $row_metatag : [];

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;
		$row['content'] = isset($row['content']) ? $row['content'] : NULL;

		if ( ! $row['id'] || ! is_numeric($id))
		{
			error_page();
		}

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required|callback_charlength');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if ( ! empty($_FILES['thumbnail']))
				{
					$dir_yearmonth	= date("Ym", time());
					$subdir_date	= 'date_'.date("d", time());

					// For database only with dot and slash at the front folder
					$s_parentfolder = './contents/userfiles/event/'.$dir_yearmonth.'/';
					$s_subfolder = './contents/userfiles/event/'.$dir_yearmonth.'/'.$subdir_date.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/event/'.$dir_yearmonth.'/'.$subdir_date.'/';

					if ( ! is_dir($s_parentfolder)) 
					{
						mkdir($s_parentfolder, 0777);
					}

					if ( ! is_dir($s_subfolder)) 
					{
						mkdir($s_subfolder, 0777);
					}

					$configs['upload_path']		= $s_subfolder;
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
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$thumb_l = $row['thumb_l'];
						$thumb_s = $row['thumb_s'];
						$thumb_s2 = $row['thumb_s2'];
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

						if (file_exists($row['thumb_s2']))
						{
							unlink($row['thumb_s2']);
						}

						$status_upload = 0;
						$thumb_l = $x_folder.$upload->data('file_name');
						$thumb_s = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');
						$thumb_s2 = $x_folder.$upload->data('raw_name').'_thumb2'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $thumb_l;
						$cfg_img['create_thumb']	= true;
						$cfg_img['maintain_ratio']	= true;
						$cfg_img['width']			= 720;
						$cfg_img['quality']			= '80%';

						$image_lib = load_lib('image');

						$image_lib->initialize($cfg_img);
						$image_lib->resize();
						$image_lib->clear();

						// Find smallest dimension
						$imageSize = $image_lib->get_image_properties($cfg_img['source_image'], TRUE);
						$newSize = min($imageSize);

						$cfg_img2['image_library']		= 'gd2';
						$cfg_img2['source_image']		= $thumb_l;
						$cfg_img2['new_image']			= $upload->data('raw_name').'_thumb2'.$upload->data('file_ext');
						$cfg_img2['create_thumb']		= false;
						$cfg_img2['maintain_ratio']		= false;

						if ($upload->data('image_width') > $upload->data('image_height')) 
						{
							$cfg_img2['width'] 	= $upload->data('image_height');
							$cfg_img2['height'] = $upload->data('image_height');
							$cfg_img2['x_axis'] = (($upload->data('image_width') / 2) - ($cfg_img2['width'] / 2));
						}
						else 
						{
							$cfg_img2['height'] = $upload->data('image_width');
							$cfg_img2['width'] 	= $upload->data('image_width');
							$cfg_img2['y_axis'] = (($upload->data('image_height') / 2) - ($cfg_img2['height'] / 2));
						}

						$image_lib2 = load_lib('image');
						$image_lib2->initialize($cfg_img2);
						$image_lib2->crop();
					}
				}

				$status_upload = 0;
				$uri = strtolower($this->input->post('title'));
				$uri = preg_replace("/[^a-z0-9_\s-]/", "", $uri);
				$uri = preg_replace("/[\s-]+/", " ", $uri);
				$uri = preg_replace("/[\s_]/", "-", $uri);

				if ($this->input->post('uri') !== '')
				{
					$slug = strtolower(trim($this->input->post('uri')));
					$slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
					$slug = preg_replace("/[\s-]+/", " ", $slug);
					$slug = preg_replace("/[\s_]/", "-", $slug);
				}
				else
				{
					$slug = $uri;
				}

				// $getCurrentTimeSchedule = ($row['schedule_pub'] != $row['created']) ? $row['schedule_pub'] : time();

				$schedule_pub 	= ($this->input->post('check_schedule_posts') == 1) ? strtotime($this->input->post('schedule_pub')) : '';
				$event_date 	= strtotime($this->input->post('event_date'));

				$data = [
					'title' 			=> $this->input->post('title'),
					'cid'	 			=> $this->input->post('category'),
					'content' 			=> $this->input->post('content', FALSE),
					'event_location'	=> $this->input->post('event_location'),
					'event_address'	 	=> $this->input->post('event_address'),
					'status' 			=> $this->input->post('status'),
					'userid'			=> user_function()->get_user('id'),
					'thumb_s'			=> $thumb_s,
					'thumb_s2'			=> $thumb_s2,
					'thumb_l'			=> $thumb_l,
					'uri'				=> $slug,
					'event_date'		=> $event_date,
					'schedule_pub'		=> $schedule_pub
				];
				
				if ($status_upload == 0)
				{
					$this->db->sql_update($data, 'ml_event_article', ['id' => $row['id']]);

					echo json_encode(['status' => 'success', 'message' => 'Post Edited', 'url' => site_url('manage_event')]);
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

	public function setseo($article_id = 0, $first_create = 'from_add_post')
	{
		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			$res_metatag = $this->db->sql_prepare("select * from ml_metatag_article where article_id = :article_id and type = :type");
			$bindParam_metatag = $this->db->sql_bindParam(['article_id' => $article_id, 'type' => 'event'], $res_metatag);
			$row_metatag = $this->db->sql_fetch_single($bindParam_metatag);

			if ( ! $this->db->sql_counts($bindParam_metatag))
			{
				if ($first_create == 'from_add_post')
				{
					$data = [
						'type'					=> 'event',
						'article_id'			=> $article_id,
						'created'	 			=> time()
					];
					
					$this->db->sql_insert($data, 'ml_metatag_article');
				}
				else
				{
					if ( ! empty($_FILES['meta_image']))
					{
						$dir_yearmonth	= date("Ym", time());
						$subdir_date	= 'date_'.date("d", time());

						// For database only with dot and slash at the front folder
						$s_parentfolder = './contents/userfiles/metatag/articles/'.$dir_yearmonth.'/';
						$s_subfolder = './contents/userfiles/metatag/articles/'.$dir_yearmonth.'/'.$subdir_date.'/';

						// For database only without dot and slash at the front folder
						$x_folder = 'contents/userfiles/metatag/articles/'.$dir_yearmonth.'/'.$subdir_date.'/';

						if ( ! is_dir($s_parentfolder)) 
						{
							mkdir($s_parentfolder, 0777);
						}

						if ( ! is_dir($s_subfolder)) 
						{
							mkdir($s_subfolder, 0777);
						}

						$configs['upload_path']		= $s_subfolder;
						$configs['allowed_types']	= 'jpg|jpeg|png';
						$configs['overwrite']		= TRUE;
						$configs['remove_spaces']	= TRUE;
						$configs['encrypt_name']	= TRUE;
						$configs['max_size']		= 8000;

						$upload = load_lib('upload', $configs);

						if ( ! $upload->do_upload('meta_image'))
						{
							if ($_FILES['meta_image']['error'] != 4)
							{	
								echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
								exit;
							}

							$meta_image = FALSE;
							$status_upload = 1;
						}
						else 
						{
							$status_upload = 0;
							$meta_image = $x_folder.$upload->data('file_name');
						}
					}

					$status_upload = 0;

					$data = [
						'type'					=> 'event',
						'article_id'			=> $article_id,
						'metatag_image' 		=> $meta_image,
						'metatag_title' 		=> $this->input->post('meta_title'),
						'metatag_description'	=> $this->input->post('meta_description'),
						'created'	 			=> time()
					];
					
					if ($status_upload == 0)
					{
						$this->db->sql_insert($data, 'ml_metatag_article');

						echo json_encode(['status' => 'success', 'url' => site_url('manage_event')]);
						exit;

					}
				}
			}
			else
			{
				$this->editseo($article_id);
			}
		}
	}

	public function editseo($article_id = 0)
	{
		$res_metatag = $this->db->sql_prepare("select * from ml_metatag_article where article_id = :article_id and type = :type");
		$bindParam_metatag = $this->db->sql_bindParam(['article_id' => $article_id, 'type' => 'event'], $res_metatag);
		$row_metatag = $this->db->sql_fetch_single($bindParam_metatag);

		$this->form_validation->set_rules('meta_title', 'Meta tag title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta tag description', 'required');

		if (empty($article_id))
		{
			$this->form_validation->set_rules('article_id', 'Article ID must be set', 'required');
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				if ( ! empty($_FILES['meta_image']))
				{
					$dir_yearmonth	= date("Ym", time());
					$subdir_date	= 'date_'.date("d", time());

					// For database only with dot and slash at the front folder
					$s_parentfolder = './contents/userfiles/metatag/articles/'.$dir_yearmonth.'/';
					$s_subfolder = './contents/userfiles/metatag/articles/'.$dir_yearmonth.'/'.$subdir_date.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/metatag/articles/'.$dir_yearmonth.'/'.$subdir_date.'/';

					if ( ! is_dir($s_parentfolder)) 
					{
						mkdir($s_parentfolder, 0777);
					}

					if ( ! is_dir($s_subfolder)) 
					{
						mkdir($s_subfolder, 0777);
					}

					$configs['upload_path']		= $s_subfolder;
					$configs['allowed_types']	= 'jpg|jpeg|png';
					$configs['overwrite']		= TRUE;
					$configs['remove_spaces']	= TRUE;
					$configs['encrypt_name']	= TRUE;
					$configs['max_size']		= 8000;

					$upload = load_lib('upload', $configs);

					if ( ! $upload->do_upload('meta_image'))
					{
						if ($_FILES['meta_image']['error'] != 4)
						{	
							echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
							exit;
						}

						$meta_image = $row_metatag['metatag_image'];
						$status_upload = 1;
					}
					else 
					{
						if (file_exists($row_metatag['metatag_image']))
						{
							unlink($row_metatag['metatag_image']);
						}

						$status_upload = 0;
						$meta_image = $x_folder.$upload->data('file_name');
					}
				}

				$status_upload = 0;

				$data = [
					'metatag_image' 		=> $meta_image,
					'metatag_title' 		=> $this->input->post('meta_title'),
					'metatag_description'	=> $this->input->post('meta_description')
				];
				
				if ($status_upload == 0)
				{
					$this->db->sql_update($data, 'ml_metatag_article', ['article_id' => $article_id, 'type' => 'event']);

					echo json_encode(['status' => 'success', 'url' => site_url('manage_event')]);
					exit;
				}
			}
		}
	}

	public function setcustomfield($id)
	{
		$res = $this->db->sql_prepare("select * from ml_event_article where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['id'] = isset($row['id']) ? $row['id'] : NULL;

		$get_vars = json_decode($row['vars'], true);

		if ( ! $row['id'] || ! is_numeric($id))
		{
			echo json_encode(['status' => 'failed', 'message' => 'Invalid ID Article']);
			exit;
		}

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->input->post('text') !== null)
			{
				$get_total1 = count(json_decode(json_encode($this->input->post('text')), true));

				if ( ! empty($get_vars['custom_field']['text']))
				{
					$get_total2 = count($get_vars['custom_field']['text']);
				}
				else
				{
					$get_total2 = 0;
				}

				$get_vars['custom_field']['text'] = $this->input->post('text');

				$data_vars = [
					'vars' => json_encode($get_vars)
				];

				$this->db->sql_update($data_vars, 'ml_event_article', ['id' => $row['id']]);
				
			}

			if ($this->input->post('image') !== null)
			{
				$is_upload = 0;

				$reDecodeEncodeVars = json_decode(json_encode($this->input->post('image')), true);

				if (is_array($this->input->post('image')))
				{
					foreach ($this->input->post('image') as $key => $value) 
					{
						if ( ! empty($_FILES['image']['name'][$key]['value']))
						{							
							$_FILES['file_image']['name'] 		= $_FILES['image']['name'][$key]['value'];
							$_FILES['file_image']['type'] 		= $_FILES['image']['type'][$key]['value'];
							$_FILES['file_image']['tmp_name'] 	= $_FILES['image']['tmp_name'][$key]['value'];
							$_FILES['file_image']['error'] 		= $_FILES['image']['error'][$key]['value'];
							$_FILES['file_image']['size'] 		= $_FILES['image']['size'][$key]['value'];

							$dir = date("Ym", time());
							$s_folder = './contents/userfiles/customfield/'.$dir.'/';

							// For database only without dot and slash at the front folder
							$x_folder = 'contents/userfiles/customfield/'.$dir.'/';

							if ( ! is_dir($s_folder)) 
							{
								mkdir($s_folder, 0777);
							}

							$configs['upload_path']		= $s_folder;
							$configs['allowed_types']	= 'jpg|jpeg|png|gif';
							$configs['overwrite']		= TRUE;
							$configs['remove_spaces']	= TRUE;
							$configs['encrypt_name']	= TRUE;
							$configs['max_size']		= 8000;

							$upload = load_lib('upload', $configs);

							if ( ! $upload->do_upload('file_image'))
							{
								if ($_FILES['file_image']['error'] != 4)
								{
									echo json_encode(['status' => 'failed', 'message' => $upload->display_errors('<span>', '</span>')]);
									exit;
								}

								$reDecodeEncodeVars[$key]['value'] = false;
							}
							else 
							{
								if (isset($get_vars['custom_field']['image'][$key]['value']) && 
									file_exists($get_vars['custom_field']['image'][$key]['value']))
								{
									unlink($get_vars['custom_field']['image'][$key]['value']);
								}

								$reDecodeEncodeVars[$key]['value'] = $x_folder.$upload->data('file_name');
							}

							$is_upload = 1;
						}
						else
						{
							if (isset($get_vars['custom_field']['image'][$key]['value']) && 
								file_exists($get_vars['custom_field']['image'][$key]['value']))
							{
								$reDecodeEncodeVars[$key]['value'] = $get_vars['custom_field']['image'][$key]['value'];
							}
							else
							{
								$reDecodeEncodeVars[$key]['value'] = '';
							}

							$is_upload = 1;
						}
					}
				}

				if ($is_upload == 0)
				{
					$get_vars['custom_field']['image'] = $this->input->post('image');
				}
				elseif ($is_upload == 1)
				{
					$get_vars['custom_field']['image'] = $reDecodeEncodeVars;
				}

				$data_vars = [
					'vars' => json_encode($get_vars)
				];

				$this->db->sql_update($data_vars, 'ml_event_article', ['id' => $row['id']]);
			}

			if ($this->input->post('image') == null)
			{
				$data_vars = [
					'vars' => json_encode($this->input->post('image'))
				];

				$this->db->sql_update($data_vars, 'ml_event_article', ['id' => $row['id']]);
			}

			if ($this->input->post('text') == null)
			{
				$data_vars = [
					'vars' => json_encode($this->input->post('text'))
				];

				$this->db->sql_update($data_vars, 'ml_event_article', ['id' => $row['id']]);
			}

			echo json_encode(['status' => 'success', 'message' => 'Success']);
			exit;
		}
	}

	public function layout()
	{
		set_title('Layout News Settings');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$res_layout = $this->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam_layout = $this->db->sql_bindParam(['page' => 'event', 'section' => 'main_content'], $res_layout);
		$row_layout = $this->db->sql_fetch_single($bindParam_layout);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		$row_layout['content_title'] = isset($row_layout['content_title']) ? $row_layout['content_title'] : '';
		$row_layout['content_description'] = isset($row_layout['content_description']) ? $row_layout['content_description'] : '';

		$view_type[0] = (isset($row_layout['view_type']) && $row_layout['view_type'] == 'list') ? 'selected' : FALSE;
		$view_type[1] = (isset($row_layout['view_type']) && $row_layout['view_type'] == 'grid') ? 'selected' : FALSE;

		$is_hide_category[0] = (isset($row_layout['is_hide_category']) && $row_layout['is_hide_category'] == 0) ? 'selected' : FALSE;
		$is_hide_category[1] = (isset($row_layout['is_hide_category']) && $row_layout['is_hide_category'] == 1) ? 'selected' : FALSE;

		$is_hide_sidebar[0] = (isset($row_layout['is_hide_sidebar']) && $row_layout['is_hide_sidebar'] == 0) ? 'selected' : FALSE;
		$is_hide_sidebar[1] = (isset($row_layout['is_hide_sidebar']) && $row_layout['is_hide_sidebar'] == 1) ? 'selected' : FALSE;

		$sidebar_position[0] = (isset($row_layout['sidebar_position']) && $row_layout['sidebar_position'] == 'left') ? 'selected' : FALSE;
		$sidebar_position[1] = (isset($row_layout['sidebar_position']) && $row_layout['sidebar_position'] == 'right') ? 'selected' : FALSE;

		$disable_sidebar_position = (isset($row_layout['is_hide_sidebar']) && $row_layout['is_hide_sidebar'] == 1) ? 'disabled' : 'disabled';
		$notice_disable_sidebar_position = (isset($row_layout['is_hide_sidebar']) && $row_layout['is_hide_sidebar'] == 1) ? '<div class="text-small text-danger mt-1">This form select Position Sidebar is disabled because sidebar hide setting is active</div>' : '';

		$this->form_validation->set_rules('view_type', 'View Type', 'required');
		$this->form_validation->set_rules('is_hide_category', 'Hide Category', 'required');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(['status' => 'failed', 'message' => $this->form_validation->validation_errors('<div class="mb-2">- ', '</div>')]);
				exit;
			}
			else
			{
				$sidebar_position = ($this->input->post('sidebar_position') !== NULL) ? $this->input->post('sidebar_position') : '';
				$is_hide_sidebar = ($this->input->post('is_hide_sidebar') !== NULL) ? $this->input->post('is_hide_sidebar') : '';

				$layout_data = [
					'page'					=> 'event',
					'section'				=> 'main_content',
					'view_type'				=> $this->input->post('view_type'),
					'is_hide_category'		=> $this->input->post('is_hide_category'),
					'is_hide_sidebar'		=> $is_hide_sidebar,
					'sidebar_position'		=> $sidebar_position,
					'created'				=> time()
				];

				if ( ! $this->db->sql_counts($bindParam_layout))
				{
					$this->db->sql_insert($layout_data, 'ml_layout');
				}
				else
				{
					$this->db->sql_update($layout_data, 'ml_layout', ['id' => $row_layout['id']]);
				}

				echo json_encode(['status' => 'success', 'message' => 'Success']);
				exit;
			}
		}

		$data['row_layout']							= $row_layout;
		$data['view_type'] 							= $view_type;
		$data['is_hide_category']					= $is_hide_category;
		$data['is_hide_sidebar']					= $is_hide_sidebar;
		$data['sidebar_position']					= $sidebar_position;
		$data['disable_sidebar_position'] 			= $disable_sidebar_position;
		$data['notice_disable_sidebar_position'] 	= $notice_disable_sidebar_position;
		$data['csrf_name'] 							= $this->csrf['name'];
		$data['csrf_hash'] 							= $this->csrf['hash'];

		return view('layout', $data);
	}

	public function getListPosts()
	{
		$timezone  = +7;

		$res_getTotal = $this->db->sql_prepare("select count(*) as num from ml_event_article where (cid like :cid and title like :title)");
		$bindParam_getTotal = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%'], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_event_article where (cid like :cid and title like :title) order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumb_s2'] 	 	= ( ! empty($row['thumb_s'])) ? (file_exists($row['thumb_s2']) ? base_url($row['thumb_s2']) : 'undefined') : '';
			$row['content'] 	 	= strip_tags(ellipsize($row['content'], 50, 1, '...'));
			$row['content'] 	 	= preg_replace("/&#?[a-z0-9]+;/i",'', $row['content']);
			$row['get_user']	 	= user_function()->get_other_user($row['userid'], 'fullname');
			$row['get_created']  	= get_date($row['created']);
			$row['get_status']	 	= get_status_article($row['status'], TRUE);
			$row['scheduled']	 	= ($row['schedule_pub'] !== 0) ? '<span class="badge bg-success">'.gmdate("M jS Y, g:i a", $row['schedule_pub']+$timezone*3600).'</span>' : '-';

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No article'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function getDetailPost($id)
	{
		$res = $this->db->sql_prepare("select * from ml_event_article where id = :id");
		$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['get_thumbnail'] = base_url($row['thumb_l']);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getDetailMetatag($article_id)
	{
		$res = $this->db->sql_prepare("select * from ml_metatag_article where article_id = :article_id and type = :type");
		$bindParam = $this->db->sql_bindParam(['article_id' => $article_id, 'type' => 'event'], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['get_thumbnail'] = base_url($row['metatag_image']);

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data'];
		}

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function deletepost($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_event_article", "", ['id' => $id]);
		$check_metatag = $this->db->num_rows("ml_metatag_article", "", ['article_id' => $id, 'type' => 'event']);

		if ($check)
		{
			$res = $this->db->sql_prepare("select thumb_l, thumb_s, thumb_s2 from ml_event_article where id = :id");
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

			if (file_exists($row['thumb_s2']))
			{
				unlink($row['thumb_s2']);
			}

			$this->db->sql_delete("ml_event_article", ['id' => $id]);

			if ($check_metatag)
			{
				$res_metatag = $this->db->sql_prepare("select metatag_image from ml_metatag_article where article_id = :article_id and type = :type");
				$bindParam_metatag = $this->db->sql_bindParam(['article_id' => $id, 'type' => 'event'], $res_metatag);
				$row_metatag = $this->db->sql_fetch_single($bindParam_metatag);

				if (file_exists($row_metatag['metatag_image']))
				{
					unlink($row_metatag['metatag_image']);
				}
			
				$this->db->sql_delete("ml_metatag_article", ['article_id' => $id, 'type' => 'event']);
			}
			
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
		$res = $this->db->sql_select("select * from ml_event_category order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No data'];
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

		$check = $this->db->num_rows("ml_event_category", "", ['id' => $id]);

		if ($check)
		{
			$this->db->sql_delete("ml_event_category", ['id' => $id]);
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

	public function get_vars($uri = '')
	{
		$res = $this->db->sql_prepare("select * from ml_event_article where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		$get_vars = json_decode($row['vars'], true);

		$this->output->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($get_vars, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function deletefield($type, $index, $id)
	{
		$check = $this->db->num_rows("ml_event_article", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select * from ml_event_article where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			$get_vars = json_decode($row['vars'], true);

			if ($type == 'image')
			{
				if (isset($get_vars['custom_field']['image'][$index]['value']) && 
					file_exists($get_vars['custom_field']['image'][$index]['value']))
				{
					unlink($get_vars['custom_field']['image'][$index]['value']);
				}		
			}
			else
			{
				unset($get_vars['custom_field']['text'][$index]);
			}

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

	public function asd()
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		// section_content('<i class="fas fa-user-circle"></i>');

		echo user_function()->get_avatar_user_alt(1, 'extra-small');
		echo user_function()->get_avatar_user_alt(100, 'small');
		
		echo $this->uri->segment(2);

		exit;
	}
}

?>