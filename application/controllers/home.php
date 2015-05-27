<?php

class Home extends CI_Controller{
	public $data = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->library('prep_html');
		$this->load->library('email');
		$this->load->model('wisdom_dose');
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())? $this->config->item('wisdom_dose') : $this->wisdom_dose->getDose();
		$this->load->model(array('article', 'carousel', 'archive_m'));
		$this->data['resources'] = $this->prep_html->prep_resources(
			array('asset/css/index_extra.css',
				  'asset/css/owl.carousel.css',
				  'asset/css/owl.theme.css'
				  ), 'css');
		$this->data['resources'] .= $this->prep_html->prep_resources(array('asset/js/owlCarousel/owl.carousel.js'), 'js');
	
		$this->data['current'] = 'home';
	}


	public function index(){
		
		$this->data['carousel_imgs'] = $this->carousel->getCarousels();
		$this->data['articles'] = $this->article->getAll();
		$result = $this->article->getLatest(4);
		$this->data['latest_article_headlines'] = ($result)? $result : false;
		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/index', $this->data);
		$this->load->view('inc/footer');
	}
}