<?php

class Articles extends CI_Controller{
	public $data = array();
	public $faker;

	public function __construct(){
		parent::__construct();
		$this->load->library('prep_html');
		$this->load->model('article');
		$this->load->model('wisdom_dose');
		$this->load->model('paginate');
		$this->load->model('archive_m');
		$this->data['current'] = 'articles';
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())? $this->config->item('wisdom_dose') : $this->wisdom_dose->getDose();
		$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/pagination.css', 'asset/css/articles.css'), 'css');
		//get the lastest article headlines
		$result = $this->article->getLatest(4);
		$this->data['latest_article_headlines'] = ($result)? $result : false;
		//default page_title
		$this->data['page_title'] = 'Ofex.com | Articles';

		// require_once 'asset/libraries/autoload.php';

	}

	public function seed(){
		echo $this->faker->imgUrl($width = 640, $height = 480);

		// for($i = 0; $i <= 100; $i++)
		// {
		// 	$title = $this->faker->title;
		// 	$summary = $this->faker->summary;
		// 	$message = $this->faker->message;

		// 	$query_string = "INSERT INTO articles('"
		// }


	}


	public function index(){
		$this->list_articles();
	}

	public function page($title = '', $article_id = -1)
	{
		//set the text for the title element int the template page
		$title = url_title($title, '-', TRUE);
		$this->data['page_title'] .= " - ". str_ireplace("-", " ", ucwords( $title ));
		$this->data['breadcrumb'] = str_ireplace("-", " ", strtolower( $title ));

		//user clicked on a article summary to get here
		$this->data['articles'] = ($this->article->getDetailed($title)) ? $this->article->getDetailed($title) : false;
		$article_id = $this->data['articles'][0]['id'];	

		//prep data for next/prev navigation	
		$this->data['prev_article_title'] = $this->article->getPreviousArticleTitle($article_id);
		$this->data['next_article_title'] = $this->article->getNextArticleTitle($article_id);
		$this->data['prev_article_slug'] = $this->article->getPreviousArticleSlug($article_id);
		$this->data['next_article_slug'] = $this->article->getNextArticleSlug($article_id);
		
		$tags = $this->data['articles'][0]['tags'];
		$title = $this->data['articles'][0]['title'];
		$this->data['related_articles'] = $this->article->getRelatedArticles($tags, $title, 9);

		$path = array('inc/header', 'templates/full_article', 'inc/footer');
		$data = array($this->data, $this->data, '');
		article_template($path, $data);
	}

	public function list_articles($tag = '', $page_id = 1){
		if(!empty($tag) && !is_numeric($tag))
		{
			//a tag has been selected 
			$config['rows_per_page'] = 5;
			$config['total_rows']  = $this->article->countTags($tag);
			$config['target_url']  = site_url('articles/list_articles').'/'.$tag;
			$config['page_id'] = $page_id;
			$this->paginate->initialize($config);
			$offset = $this->paginate->get_offset();
			$limit = $limit = $this->paginate->get_limit();
			$result = ($this->article->getSummary($limit, $tag,$offset)) ? $this->article->getSummary($limit, $tag,$offset) : false;
			if($result)
			{
				$this->data['articles'] = $result;
				$this->data['breadcrumb'] = $tag;
				$this->data['pagination'] = $this->paginate->create_pagination();
			}
			else
				$this->data['articles'] = false;
		}
		else
		{
			//no tag value was submitted. Hence the passed tag is a page_id
			$page_id = $tag;
			$config['rows_per_page'] = 5;
			$query_string = "SELECT count(*) as count FROM article, cms_article where article.id = cms_article.article_id and cms_article.pub_status = '1'";
			$config['total_rows']  = $this->article->getCount($query_string)[0]['count'];
			$config['target_url']  = site_url("article/page");
			$config['page_id'] = empty($this->input->get('page'))?  $page_id : $this->input->get('page') ;
			$this->paginate->initialize($config);
			$offset = $this->paginate->get_offset();
			$limit = $this->paginate->get_limit();

			$result = ($this->article->getAll($offset, $limit))? $this->article->getAll($offset, $limit) : false;
			$this->data['articles'] = $result;
			//create the pagianation
			$this->data['pagination'] = $this->paginate->create_pagination3();
		}

		$path = array('inc/header', 'templates/articles', 'inc/footer');
		$data = array($this->data, $this->data, '');
		article_template($path, $data);
	}
}