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

class manage_gallery extends Aruna_Controller
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

		// Check active page
		check_active_page('manage_gallery');

		// Only role page with role user
		check_role_page('manage_gallery');

		// Check user has login or not
		has_login();
	}

	public function index()
	{
		set_title('Manage Gallery');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$this->form_validation->set_rules('newcategory', 'Category', 'required|min_length[3]|regex_match[/^[&\/A-Za-z0-9 ]+$/i]');

		if ($this->input->post('step') && $this->input->post('step') == 'post')
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
				
				$this->db->sql_insert($data, 'ml_image_category');

				echo json_encode(['status' => 'success', 'msg' => 'New category added!']);
				exit;
			}
		}

		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('index', $data);
	}

	public function editcategory($id)
	{
		set_title('Edit Category');

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);
		
		$res = $this->db->sql_prepare("select id, name from ml_image_category where id = :id");
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
				echo json_encode(['status' => 'failed', 'msg' => $this->form_validation->validation_errors('<div class="mb-2">', '</div>')]);
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
				
				$this->db->sql_update($data, 'ml_image_category', ['id' => $id]);

				echo json_encode(['status' => 'success', 'url' => site_url('manage_gallery')]);
				exit;
			}
		}

		$data['id']		   = $row['id'];
		$data['name']	   = $row['name'];
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];
		
		return view('editcategory', $data);
	}

	public function gallery($code)
	{
		set_title('List of Images');

		$res = $this->db->sql_prepare("select * from ml_image_category where code = :code");
		$bindParam = $this->db->sql_bindParam(['code' => $code], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['code'] = isset($row['code']) ? $row['code'] : '';

		if ( ! $row['code'] || ! is_string($row['code']))
		{
			error_page();
		}

		register_js([
			'<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>',
			'
			<script>
			Dropzone.options.myGreatDropzone = { // camelized version of the `id`
				paramName: "images", // The name that will be used to transfer the file
				maxFilesize: 8, // MB
				uploadMultiple: true,
				parallelUploads: 3,
				maxFiles: 10,
				init: function() 
				{
					this.on("sending", (file, xhr, formData) => 
					{
						formData.append(document.getElementsByClassName("btn-gallery")[0].getAttribute("name"), document.getElementsByClassName("btn-gallery")[0].getAttribute("value"));
						formData.append(document.getElementsByClassName("btn-token-submit")[0].getAttribute("name"), document.getElementsByClassName("btn-token-submit")[0].getAttribute("value"));
					});

					this.on("complete", file => 
					{
						document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", Cookies.get("csrf_phoenix_cms_2023"));
					});

					this.on("error", (file, response) => 
					{
						if (file.previewElement) 
						{
							file.previewElement.classList.add("dz-error");

							if (typeof response !== "string" && response.msg) 
							{
								message = response.msg;
							}
							
							for (let node of file.previewElement.querySelectorAll("[data-dz-errormessage]")) 
							{
								node.textContent = message;
							}
						}
					});
				}
			};
			</script>'
		]);

		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$data['row'] = $row;
		$data['csrf_name'] = $this->csrf['name'];
		$data['csrf_hash'] = $this->csrf['hash'];

		return view('gallery', $data);
	}

	public function upload_images()
	{
		$total = $this->db->num_rows('ml_images', 'num', ['cid' => $this->input->post('getcatid')]);

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
			if ( ! empty($_FILES['images']) && count($_FILES['images']['name']) > 0)
			{
				for ($i = 0; $i < count($_FILES['images']['name']); $i++)
				{
					$dir_yearmonth	= date("Ym", time());
					$subdir_date	= 'date_'.date("d", time());

					// For database only with dot and slash at the front folder
					$s_parentfolder = './contents/userfiles/gallery/'.$dir_yearmonth.'/';
					$s_subfolder = './contents/userfiles/gallery/'.$dir_yearmonth.'/'.$subdir_date.'/';

					// For database only without dot and slash at the front folder
					$x_folder = 'contents/userfiles/gallery/'.$dir_yearmonth.'/'.$subdir_date.'/';

					if ( ! is_dir($s_parentfolder)) 
					{
						mkdir($s_parentfolder, 0777);
					}

					if ( ! is_dir($s_subfolder)) 
					{
						mkdir($s_subfolder, 0777);
					}
					
					$_FILES['file']['name'] 	= $_FILES['images']['name'][$i];
					$_FILES['file']['type'] 	= $_FILES['images']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
					$_FILES['file']['error'] 	= $_FILES['images']['error'][$i];
					$_FILES['file']['size'] 	= $_FILES['images']['size'][$i];

					$configs['upload_path']		= $s_subfolder;
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

						$status_upload = 1;

						$images  = FALSE;
						$thumb1  = FALSE;
						$thumb2  = FALSE;
					}
					else 
					{
						$status_upload = 0;

						$images = $x_folder.$upload->data('file_name');
						$thumb1  = $x_folder.$upload->data('raw_name').'_thumb'.$upload->data('file_ext');
						$thumb2  = $x_folder.$upload->data('raw_name').'_thumb2'.$upload->data('file_ext');

						$cfg_img['image_library']	= 'gd2';
						$cfg_img['source_image']	= $images;
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
						$cfg_img2['source_image']		= $images;
						$cfg_img2['new_image']			= $thumb2;
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
						$image_lib2->clear();
					}

					if ($status_upload == 0)
					{
						$data = [
							'cid'			=> $this->input->post('getcatid'),
							'uri'			=> $images,
							'thumbnail'		=> $thumb1,
							'thumbnail2'	=> $thumb2,
							'created'		=> time()
						];

						$this->db->sql_insert($data, 'ml_images');
					}
				}
			
				$this->output->set_content_type('application/json', 'utf-8')
							 ->set_header('Access-Control-Allow-Origin: '.site_url())
							 ->set_output(json_encode(['status' => 'success', 'msg' => 'Success'], JSON_PRETTY_PRINT))
							 ->_display();
				exit;
			}
			else
			{
				$this->output->set_content_type('application/json', 'utf-8')
							 ->set_header('Access-Control-Allow-Origin: '.site_url())
							 ->set_header('HTTP/1.0 400 Bad Request')
							 ->set_output(json_encode(['status' => 'failed', 'msg' => 'Upload failed'], JSON_PRETTY_PRINT))
							 ->_display();
				exit;
			}
		}
	}

	public function getListImages($cid)
	{
		$this->num_per_page = 16;

		$count_page = $this->db->num_rows('ml_images', '', ['cid' => $cid]);
		$totalpage = ceil($count_page/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_images where cid = :cid order by id desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => $cid], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumbnail2'] = ( ! empty($row['thumbnail2'])) ? (file_exists($row['thumbnail2']) ? base_url($row['thumbnail2']) : 'undefined') : '';

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No image'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output->set_content_type('application/json', 'utf-8')
					 ->set_header('Access-Control-Allow-Origin: '.site_url())
					 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
					 ->_display();
		exit;
	}

	public function getListCategories()
	{
		$res = $this->db->sql_select("select * from ml_image_category order by id desc");
		while ($row = $this->db->sql_fetch_single($res))
		{
			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No data'];
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

		$check = $this->db->num_rows("ml_image_category", "", ['id' => $id]);

		if ($check)
		{
			$this->db->sql_delete("ml_image_category", ['id' => $id]);
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

	public function deleteimage($id)
	{
		load_extend_view('default', ['header_dash_page', 'footer_dash_page']);

		$check = $this->db->num_rows("ml_images", "", ['id' => $id]);

		if ($check)
		{
			$res = $this->db->sql_prepare("select thumbnail, thumbnail2, uri from ml_images where id = :id");
			$bindParam = $this->db->sql_bindParam(['id' => $id], $res);
			$row = $this->db->sql_fetch_single($bindParam);

			if (file_exists($row['thumbnail']))
			{
				unlink($row['thumbnail']);
			}

			if (file_exists($row['thumbnail2']))
			{
				unlink($row['thumbnail2']);
			}

			if (file_exists($row['uri']))
			{
				unlink($row['uri']);
			}

			$this->db->sql_delete("ml_images", ['id' => $id]);

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
}

?>