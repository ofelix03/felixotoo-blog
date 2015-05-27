<?php 

class Blog extends CI_Controller{

	public function index(){
		$this->load->model('article');
		$this->data['articles'] = $this->article->getAll();
		$this->data['wallpaper'] = "tumblr_nbk7bzHUrh1st5lhmo1_1280.jpg";

		$this->load->view('inc/header', $this->data);
		$this->load->view('templates/blog', $this->data);
		$this->load->view('inc/footer');
	}
}