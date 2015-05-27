<?php

class PageNotFound extends CI_Controller{
	public $data = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->library('prep_html');
		$this->load->model('wisdom_dose');
		$this->load->model('article');
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())? "The Fear of the Lord is the Beginning of Wisdom" : $this->wisdom_dose->getDose();
		$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/page_not_found.css'), 'css');
		$this->data['page_title'] = 'Ofex.com | 404 - Page Not Found';
	}

	public function index(){
		$this->output->set_status_header('404');
		$result = $this->article->getLatest(4);
		$this->data['latest_article_headlines'] = ($result)? $result : false;
		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/page_not_found', $this->data);
		$this->load->view('inc/footer');
	}
}