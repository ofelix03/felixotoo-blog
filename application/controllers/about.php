<?php

class About extends CI_Controller{
	public $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->library('prep_html');
		$this->load->model('article');
		$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/about/about.css', 'asset/css/about/md-device.css', 'asset/css/about/sm-devices.css'), 'css');
		$this->data['current'] = 'about';
		$this->load->model('about_m');
		$this->load->model('wisdom_dose');
		$this->data['wisdom_dose'] = empty($this->wisdom_dose->getDose())?  $this->config->item('wisdom_dose') : $this->wisdom_dose->getDose();
        $this->load->model('archive_m');
		$this->data['archiveYears'] = $this->archive_m->archiveList(2015);
		$this->data['success'] = FALSE;

		//get the lastest article headlines
		$result = $this->article->getLatest(4);
		$this->data['latest_article_headlines'] = ($result)? $result : false;
	    $this->data['page_title'] = 'Ofex.com | About Me';
	}

	public function index(){
		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/about_index');
		$this->load->view('inc/footer');

	}

	public function message_submit(){
		$this->load->library('form_validation');
		if($this->about_m->validate($this->input->post()))
		{
			$this->data['success'] =  'Message submitted successfully. Thank you.';
		}
		//creat an achore url 
		$anchor_url = current_url().'#contact';

		//reload the page to the anchored page element
		$script  = "<script type='text/javascript'>";
		$script  .= "
						$(window).load(function(){
							window.location.href='$anchor_url';
						});
					";
		$script   .= "</script>";			
		$this->data['run_script'] = $script;

		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/about_index', $this->data);
		$this->load->view('inc/footer');
	}
}