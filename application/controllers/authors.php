<?php 

class Authors extends CI_Controller{
	private $auth_id;
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->library('prep_html');
		$this->load->model('article');
		$this->load->model('wisdom_dose');
		$this->load->model('author');
		$this->load->helper('custom_helper');
		$this->load->model('paginate');
		$this->load->model('archive_m');
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())? $this->config->item('wisdom_dose') : $this->wisdom_dose->getDose();
		$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/authors/authors.css', 'asset/css/articles.css'), 'css');
		//get the lastest article headlines
		$result = $this->article->getLatest(6);
		$this->data['latest_article_headlines'] = ($result)? $result : false;

		$this->data['page_title'] = $this->config->item('page_title').' | Author';
	}

	public function author($id){
		if(isset($id) && is_numeric($id))
		{
			$this->data['author'] = ($this->author->getAuthor($id, 3)[0])? $this->author->getAuthor($id, 3)[0] : false;
			$this->data['page_title'] .= " - ".$this->data['author']['name'];
			$this->data['auth_article_titles'] = ($this->article->getArticleTitles($id, 4))? $this->article->getArticleTitles($id, 4) : false;
			$this->data['other_authors'] = $this->author->getAuthors()['data'];
			$this->data['articles_count']  = $this->author->getAuthors()['count'];

			//load view
			$data = array($this->data, $this->data, '');
			$path = array('inc/header', 'templates/author_details', 'inc/footer');
			article_template($path, $data);
		}
	}

	public function get(){
		echo json_encode(array(
			array('name'=>'Felix Otoo', 'age'=>22, 'sex'=>'Male'),
			array('name'=>'Samuel Mensah', 'age'=>24, 'sex'=>'Male'),
			array('name'=>'Christabel Brew Daniels', 'age'=>24, 'sex'=>'Female')
			));
	}

	public function loadMoreArticles(){
		$page_id_ajax = $this->input->get('page_id');
		$auth_id_ajax = $this->input->get('auth_id');
		$total_articles = $this->input->get('total_articles');
		$status = true;
		if($page_id_ajax == 1)
			return false;

		if($page_id_ajax >= ceil($total_articles / 5)){
			$status = false;
		}

		$articles = $this->author_articles($auth_id_ajax, $page_id_ajax);
		$template = "";

		foreach($articles as $article){
			$article_id = $article['id'];
			$article_auth = $article['name'];
			$article_auth_id = $article['auth_id'];
			$article_pub_date = $article['pub_date'];
			$article_slug = $article['slug'];
			$article_title = $article['title'];
			$article_title_url = url_title($article_title, '-', TRUE);
			$article_message = html_entity_decode($article['summary']);
			$article_pic = $article['thumb_name'];
			$article_pic_alt = $article['img_alt'];
			$tags = $article['tags'];
			$article_tags = array_map('trim', $tags );
			$article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;

			$template .= "<article>";
			$template .= "<header><h1><a href='". site_url('articles').'/'.$article_slug."'>".$article_title."</a></h1></header>";
			$template .= "<div class='header-meta'><span><i class='fa fa-clock-o'></i>&nbsp;".$article_pub_date."&nbsp;</span>";
			$template .=  "<span><i class='fa fa-user'></i><a href='".site_url('authors').'/'.$article_auth_id."'>".$article_auth."</a></span>";
			$template .= "<span>&nbsp;<i class='fa fa-comment'></i><a href='".site_url('articles').'/'.url_title($article_title, '-', TRUE).'#disqus_thread'."'></a> </span></div>";
			if($article_pic !== '')
				$template .= "<a href='".site_url('articles').'/'.$article_slug."'><img class='article-img' src='".$article_path."' alt='".$article_pic_alt."'/></a>";
			$template .= "<div id='summary'>".$article_message."</div>";
			$template .= "<span class='more-btn'><a href='".site_url('articles').'/'.$article_slug."'>Continue reading <i class='fa fa-long-arrow-right'></i></a></span>";
			$template .= "<p class='clear'></p>";
			$template .= "<ul class='article-tags'>";
			foreach($article_tags as $tag)
			{
				$template .= "<li><a href='".site_url('articles/tags').'/'.url_title($tag)."'>".url_title($tag)."</a></li>";
			}
			$template .= "</ul>";
			$template .= "<p class='clear'></p>";
			$template .= "</article>";

		}
		echo json_encode(array('status' => $status, 'template' => $template, 'auth_id' => 1, 'page_id' => ($page_id_ajax+1)));
	}

	public function author_articles($auth_id = "", $page_id = ""){
		$limit = 5; 
		if($page_id != "" && $auth_id != ""){
			$offset = ($page_id - 1) * $limit;
			$results = ($this->article->getByAuthor($auth_id, $offset, $limit)) ? $this->article->getByAuthor($auth_id, $offset, $limit) : false;
			if($results === false)
				return false;
			$data = array();
			foreach($results as $index => $result){
				$result['summary'] = html_entity_decode($result['summary']);
				$result['tags'] =  explode(",", $result['tags']);
				$data[$index] = $result;
			}
			return $data;
		}
		else
		{
			$this->data['articles'] = ($this->article->getByAuthor($auth_id, 0, $limit)) ? $this->article->getByAuthor($auth_id, 0, $limit) : false;
		}

		$this->data['total_articles'] = ($this->article->getByAuthor($auth_id)) ? count_inner_arrays($this->article->getByAuthor($auth_id)) : 0;
		$this->data['auth_name'] = ($this->author->getName($auth_id))?  $this->author->getName($auth_id) : false;
		$this->data['auth_id'] = $auth_id;
		$path = array('inc/header', 'templates/author_articles', 'inc/footer');
		$data = array($this->data, $this->data, '');
		article_template($path, $data);
	}

	function load_more(){
		$this->load->view('templates/author_articles_load_more');
	}



}