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

class portofolio extends Aruna_Controller
{
	protected $offset;

	protected $num_per_page;

	public function __construct() 
	{
		parent::__construct();

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		page_function()->check_active_page(['style_class_name' => 'm-5']);
	}

	public function index()
	{
		set_title(t('Portofolio'));

		set_meta(site_url('portofolio'), 'Portofolio', 'List of Our Portofolio', NULL);

		if (get_layout('portofolio', 'view_type') == 'grid')
		{
			$data['layout_view'] = $this->grid_view();
		}
		elseif (get_layout('portofolio', 'view_type') == 'grid_box')
		{
			$data['layout_view'] = $this->grid_box_view();
		}
		elseif (get_layout('portofolio', 'view_type') == 'list')
		{
			$data['layout_view'] = $this->list_view();
		}
		else
		{
			$data['layout_view'] = $this->list_view();
		}

		return view('index', $data);
	}

	public function grid_view()
	{
		$res_category = $this->db->sql_select("select * from ml_portofolio_category order by id asc");
		$row_category = $this->db->sql_fetch($res_category);

		$data['category'] = $row_category;

		return view('grid_view', $data, FALSE, TRUE);
	}

	public function grid_box_view()
	{
		$res_category = $this->db->sql_select("select * from ml_portofolio_category order by id asc");
		$row_category = $this->db->sql_fetch($res_category);

		$data['category'] = $row_category;

		return view('grid_box_view', $data, FALSE, TRUE);
	}

	public function list_view()
	{
		$res_category = $this->db->sql_select("select * from ml_portofolio_category order by id asc");
		$row_category = $this->db->sql_fetch($res_category);

		$data['category'] = $row_category;

		return view('list_view', $data, FALSE, TRUE);
	}

	public function detail($uri = '')
	{
		register_js([
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/highlight.min.js"></script>',
			'<script>hljs.initHighlightingOnLoad();</script>'
		]);

		$res = $this->db->sql_prepare("select * from ml_portofolio_article where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prportofolio from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['id'] = isset($row['id']) ? $row['id'] : '';
		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';
		$row['title'] = isset($row['title']) ? $row['title'] : '';
		$row['content'] = isset($row['content']) ? $row['content'] : '';
		$row['created'] = isset($row['created']) ? $row['created'] : time();

		set_title($row['title']);

		auto_set_meta('portofolio', $row['id']);

		if ( ! $row['uri'])
		{
			error_page('Article not found', ['style_class_name' => 'm-5']);
		}

		$row['get_date'] 	= ( ! empty($row['schedule_pub'])) ? get_date($row['schedule_pub'], 'date') : get_date($row['created'], 'date');
		$row['thumb_ori'] 	= ( ! empty($row['thumb_l'])) ? $row['thumb_l'] : '';
		$row['thumb_l'] 	= ( ! empty($row['thumb_l'])) ? '<img src="'.base_url($row['thumb_l']).'" class="img-fluid rounded">' : '';
		$row['content'] 	= str_replace("<oembed url", '<div class="embed-responsive embed-responsive-16by9 mb-2"><iframe class="embed-responsive-item ar-iframe" src', $row['content']);
		$content 			= str_replace("></oembed>", ' allowfullscreen></iframe></div>', $row['content']);
		$content 			= str_replace("<img", '<img class="rounded shadow-sm"', $content);
		$content 			= str_replace("<figcaption", '<figcaption class="figure-caption"', $content);

		$data['row'] = $row;
		$data['content'] = $content;
		$data['uri'] = $this->uri;

		return view('detail', $data);
	}

	public function getListPosts()
	{
		$res_getTotal = $this->db->sql_prepare("select count(id) as num from ml_portofolio_article where (cid like :cid and title like :title) and status = :status and schedule_pub <= :time");
		$bindParam_getTotal = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%', 'status' => 0, 'time' => time()], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_portofolio_article where (cid like :cid and title like :title) and status = :status and schedule_pub <= :time order by schedule_pub desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%', 'status' => 0, 'time' => time()], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumb_s'] 	= ( ! empty($row['thumb_s'])) ? (file_exists($row['thumb_s']) ? base_url($row['thumb_s']) : 'undefined') : '';
			$row['title']		= ellipsize($row['title'], 100);
			$row['content'] 	= strip_tags(ellipsize($row['content'], 150));
			$row['content'] 	= preg_replace("/&#?[a-z0-9]+;/i", '', $row['content']).'...';
			$row['avatar'] 		= user_function()->get_avatar_user($row['userid']);
			$row['user'] 		= user_function()->get_other_user($row['userid'], 'fullname');
			$row['category']	= get_category($row['cid'], 'portofolio');
			$row['get_date']	= ( ! empty($row['schedule_pub'])) ? get_date($row['schedule_pub'], 'date') : get_date($row['created'], 'date');

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'message' => 'No article'];
		}

		$output[]['getDataPage'] = ['current_page' => $currentpage, 'total' => $totalpage, 'num_per_page' => $this->num_per_page];

		$this->output
				 ->set_status_header(200)
				 ->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($output, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}

	public function getDetail()
	{
		register_js([
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/highlight.min.js"></script>',
			'<script>hljs.initHighlightingOnLoad();</script>'
		]);

		$res = $this->db->sql_prepare("select * from ml_portofolio_article where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $this->input->get('uri')], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prportofolio from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';
		$row['title'] = isset($row['title']) ? $row['title'] : '';
		$row['content'] = isset($row['content']) ? $row['content'] : '';
		$row['created'] = isset($row['created']) ? $row['created'] : time();

		$row['get_date'] 			= ( ! empty($row['schedule_pub'])) ? get_date($row['schedule_pub'], 'date') : get_date($row['created'], 'date');
		$row['thumb_ori'] 			= ( ! empty($row['thumb_l'])) ? $row['thumb_l'] : '';
		$row['thumb_l'] 			= ( ! empty($row['thumb_l'])) ? '<img src="'.base_url($row['thumb_l']).'" class="img-fluid rounded">' : '';
		$row['content'] 			= str_replace("<oembed url", '<div class="embed-responsive embed-responsive-16by9 mb-2"><iframe class="embed-responsive-item ar-iframe" src', $row['content']);
		$content 					= str_replace("></oembed>", ' allowfullscreen></iframe></div>', $row['content']);
		$content 					= str_replace("<img", '<img class="rounded shadow-sm"', $content);
		$content 					= str_replace("<figcaption", '<figcaption class="figure-caption"', $content);
		$row['converted_content'] 	= $content;

		if ($row['uri'])
		{
			$data[] = $row;
		}
		else
		{
			$data[] = ['status' => 'failed', 'message' => 'Article not found'];
		}

		$this->output
				 ->set_status_header(200)
				 ->set_content_type('application/json', 'utf-8')
				 ->set_header('Access-Control-Allow-Origin: '.site_url())
				 ->set_output(json_encode($data, JSON_PRETTY_PRINT))
				 ->_display();
		exit;
	}
}

?>