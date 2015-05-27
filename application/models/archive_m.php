<?php

class Archive_m extends CI_Model{


    private $start_year = 2010;
    private $cur_year;
	private $archive = array();
	private $years = array();
	public $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


	public function __construct($current_year = ""){
		if(!empty($current_year)){
			$this->cur_year = $current_year;
		}
 
	}

	public function archiveList($current_year){
		$this->cur_year = $current_year;
		$diff  = $current_year - $this->start_year;
		
		for($i = 0; $i <= $diff; $i++)
		{
			//get the years
			if($i == 0)
				$current_year = $current_year;
			else
				$current_year = $current_year - 1;
            
			$this->years[$i] = $current_year;			
		}

		return $this->years;

	}

	public function getYearData($year){
		if(empty($year) || !is_numeric($year))
			return false;
		$data = array();
		foreach($this->months as $index => $month){
			$data[$index] = $this->getMonthData($index + 1, $year);
		}

		return $data;

	}

	public function getYearDataCount($year){
		$data = $this->getYearData($year);
		$count = array();
		foreach($data as $index => $item){
			$count[$index] = count($item);
		}
		return $count;

	}


	public function getMonthData($month, $year){
		$this->cur_year = $year;
		$data = array();
		$digits = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
	    if(in_array($month, $digits))
	 	    $month = "0".$month;
	    // $query_string  = "SELECT title, slug, pub_date FROM article  LEFT JOIN cms_article ON article.id = cms_article.article_id 
	    // WHERE cms_article.pub_status = '1' AND pub_date LIKE '".$year."-".$month."%' ORDER BY pub_date ASC";
	   	
	   	$query_string  = "SELECT title, pub_date, authors.name, authors.id, slug, thumb_name 
							FROM article, cms_article, authors 
							WHERE article.id = cms_article.article_id  AND article.auth_id = authors.id 
							AND cms_article.pub_status = '1' AND pub_date LIKE '".$year."-".$month."%' ORDER BY pub_date ASC";

	   	
	    $result = $this->db->query($query_string);
	    $result = $result->result_array();
	    return $result;

	}


	
}
