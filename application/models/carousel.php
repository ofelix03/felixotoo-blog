<?php 

class Carousel extends CI_Model{
	public $carousel_name = '';


	public function __construct(){
		parent::__construct();
		$this->load->database();

	}

	public function getCarousels(){ 
		$query_string = "SELECT carousel_name, brief, link, caption, brief_color, caption_color, link_color  FROM carousel";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();

	}
	

}