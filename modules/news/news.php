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

class news extends Aruna_Controller
{
	protected $offset;

	protected $num_per_page;

	public function __construct() 
	{
		parent::__construct();

		$this->offset = offset();

		$this->num_per_page = num_per_page();

		// Check active page
		check_active_page('news', ['style_class_name' => 'm-5']);
	}

	public function index()
	{
		set_title(t('News'));

		if (get_layout('news', 'view_type') == 'grid')
		{
			$data['layout_view'] = $this->grid_view();
		}
		elseif (get_layout('news', 'view_type') == 'grid_box')
		{
			$data['layout_view'] = $this->grid_box_view();
		}
		elseif (get_layout('news', 'view_type') == 'list')
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
		$res_category = $this->db->sql_select("select * from ml_news_category order by id asc");
		$row_category = $this->db->sql_fetch($res_category);

		$data['category'] = $row_category;

		return view('grid_view', $data, FALSE, TRUE);
	}

	public function grid_box_view()
	{
		$res_category = $this->db->sql_select("select * from ml_news_category order by id asc");
		$row_category = $this->db->sql_fetch($res_category);

		$data['category'] = $row_category;

		return view('grid_box_view', $data, FALSE, TRUE);
	}

	public function list_view()
	{
		$res_category = $this->db->sql_select("select * from ml_news_category order by id asc");
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

		$res = $this->db->sql_prepare("select * from ml_news_article where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['uri'] = isset($row['uri']) ? $row['uri'] : '';
		$row['title'] = isset($row['title']) ? $row['title'] : '';
		$row['content'] = isset($row['content']) ? $row['content'] : '';
		$row['created'] = isset($row['created']) ? $row['created'] : time();

		set_title($row['title']);

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
		$res_getTotal = $this->db->sql_prepare("select count(id) as num from ml_news_article where (cid like :cid and title like :title) and schedule_pub <= :time");
		$bindParam_getTotal = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%', 'time' => time()], $res_getTotal);
		$row_getTotal = $this->db->sql_fetch_single($bindParam_getTotal);

		$totalpage = ceil($row_getTotal['num']/$this->num_per_page);

		$currentpage = ($this->input->get('page') == 1) ? '' : $this->input->get('page');
		$currentpage = ($this->input->get('page') != null) ? $this->input->get('page') : 1;

		$res = $this->db->sql_prepare("select * from ml_news_article where (cid like :cid and title like :title) and schedule_pub <= :time order by schedule_pub desc limit $this->offset, $this->num_per_page");
		$bindParam = $this->db->sql_bindParam(['cid' => '%'.$this->input->get('category').'%', 'title' => '%'.$this->input->get('search').'%', 'time' => time()], $res);
		while ($row = $this->db->sql_fetch_single($bindParam))
		{
			$row['thumb_s'] 	 	= ( ! empty($row['thumb_s'])) ? (file_exists($row['thumb_s']) ? base_url($row['thumb_s']) : 'undefined') : '';
			$row['title']		 	= ellipsize($row['title'], 100);
			$row['content'] 	 	= strip_tags(ellipsize($row['content'], 150));
			$row['content'] 	 	= preg_replace("/&#?[a-z0-9]+;/i", '', $row['content']).'...';
			$row['avatar'] 		 	= avatar($row['userid']);
			$row['user'] 		 	= get_client($row['userid'], 'fullname');
			$row['category']	 	= get_category($row['cid']);
			$row['get_date']		= ( ! empty($row['schedule_pub'])) ? get_date($row['schedule_pub'], 'date') : get_date($row['created'], 'date');

			$output[] = $row;
		}

		if ( ! $this->db->sql_counts($res))
		{
			$output[] = ['status' => 'failed', 'msg' => 'No article'];
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
}

?>