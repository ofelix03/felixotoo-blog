<?php

class Search extends CI_Controller{
	private $search = '';
	private $search_term = '';
	private $data = array();
	private $mysqli;

	public function __construct(){
		parent::__construct();
		$html = $this->load->library('prep_html');
		$this->load->helper('custom_helper');
		$this->load->model('article');
		$this->load->model('archive_m');
		$this->load->model('wisdom_dose');
		$this->load->model('search_m');
		$this->data['archiveYears'] = $this->archive_m->archiveList(2014);
		$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/pagination.css', 'asset/css/articles.css'), 'css');
		//get the lastest article headlines
		$result = $this->article->getLatest(4);
		$this->data['latest_article_headlines'] = ($result)? $result : false;
		$this->mysqli = mysqli_inst($this->config->item('server'), $this->config->item('user'), $this->config->item('password'), $this->config->item('dbname'));

		//loading extra resources
		$this->data['resources'] =  $this->prep_html->prep_resources( array('asset/css/search.css', 'asset/css/articles.css', 'asset/css/pagination.css'), 'css');
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())? $this->config->item('wisdom_dose') : $this->wisdom_dose->getDose();
	}



	public function term($keyword = ''){
            $page_id =  $this->input->get('page');
			$search = $this->mysqli->real_escape_string(trim($this->input->get('search', TRUE)));
			$search = !empty($search)? $search : trim($keyword);
			$search_term = urldecode(unhyphen($search));

	        $accepted_keywords = $this->search_m->filter_search_term($search_term);
	        $this->data['pagination'] = false;


			if(empty($search_term) || $search_term == ' ')
			{
				$this->data['search_term'] =  $search_term;
				$this->data['search_results'] = false;
				$this->data['returned_num_rows'] = 0;
				
				// $paths = array('inc/header', 'templates/search_results', 'inc/footer');
				// $data = array($this->data, $this->data, '');
				// article_template($paths, $data);

			}
            else if($this->search_m->getData($search_term))
			{
				$this->data['search_results'] = $this->search_m->getData($search_term, $page_id);
                $search_term = stripslashes($search_term);
				$this->data['returned_num_rows'] = $this->search_m->num_rows;
	            $this->data['search_term'] = stripoff(array('[removed]'), $search_term);
	            $this->data['accepted_keywords']  = $accepted_keywords;
				$this->data['pagination'] = $this->search_m->pagination_markup;

			}
			// else
			// {
   //              $search_term = stripslashes($search_term);
			// 	$this->data['search_results'] = false;
			// 	$this->data['search_term'] = stripoff(array('[removed]'), $search_term);
			// 	$this->data['returned_num_rows'] = 0;
			// }
			$paths = array('inc/header',  'templates/search_results', 'inc/footer');
			$data = array($this->data, $this->data, '');
			article_template($paths, $data);
	}


	function page($page_id = 0){
		print_r($this->search_m->result_ids);
	}

}