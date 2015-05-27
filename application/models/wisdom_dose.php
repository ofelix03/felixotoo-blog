<?php

class Wisdom_dose extends CI_Model{
	private $date;

	public function __construct(){
		parent:: __construct();
		$this->load->database();
	}

	public function getDose($date=''){
		if($date)
			$this->date = $date;
		else
			$this->date = date('Y-m-d');

		$query_string = "SELECT dose from wisdom_dose where date = '$this->date'";
		$query_result = $this->db->query($query_string);

		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['dose'];
	}
}