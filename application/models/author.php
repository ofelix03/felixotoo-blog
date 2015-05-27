<?php

class Author extends CI_Model{

	private $data = array();
	private  $tb_authors = 'authors';
	private $tb_articles = 'article';

	public function __construct(){
		parent:: __construct();
		$this->load->database();
	}

	public function getAuthor($id){
		$query_string = 'SELECT id, name, age, sex , profession,  thumb_name AS auth_thumb, social_networks, in_brief 
						FROM '.$this->tb_authors.' LEFT JOIN auth_thumb_details ON '.$this->tb_authors.'.id = auth_thumb_details.authors_id WHERE id = '.$id;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array();

		return false;
	}

	public function getName($auth_id){
		$query_string = "SELECT name FROM authors WHERE authors.id = '$auth_id'";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows == 1)
			return $query_result->result_array()[0]['name'];


		return false;
	}

	public function getAuthors($exception_id = ''){
		$query_string = 'SELECT id, name, sex , profession, thumb_name AS auth_thumb FROM '.$this->tb_authors . ' LEFT JOIN auth_thumb_details  ON '.$this->tb_authors.'.id = auth_thumb_details.authors_id';
		if(isset($exception_id) && is_numeric($exception_id))
		{
			//append WHERE clause
			$query_string .= " WHERE id != {$exception_id}";
		}
		$sums = array();
		$query_result1 = $this->db->query($query_string)->result_array();
		foreach($query_result1 as $index => $value)
		{
			$sums[$value['id']]  = $this->getArticlesSum($value['id']);
		}

		return  array('data' => $query_result1, 'count' => $sums);
		return false;
	}

	public function getArticlesSum($auth_id){
		if(!is_numeric($auth_id))
			return false;
		$query_string = "SELECT count(*) as sum FROM article, cms_article WHERE article.auth_id = '$auth_id' AND article.id = cms_article.article_id AND cms_article.pub_status = '1'";
		$query_result = $this->db->query($query_string);
		return $query_result->result_array()[0]['sum'];
	}

}