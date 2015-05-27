<?php

class Portfolio extends CI_Controller{
	private $data = array();

	function __construct(){
		parent::__construct();
		$this->load->library('prep_html');
		$this->data['resources'] = $this->prep_html->prep_resources(base_url('asset/css/portfolio/portfolio.css'), 'css');

	}

	function index(){
		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/portfolio');
		$this->load->view('inc/footer');
	}
}