<?php 

class Search_m extends CI_Controller{
	private $tb_article = 'article';
	private  $tb_authors = "authors";
    public $result_ids;
    public $num_rows ;
    public $pagination_markup;

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('custom_helper');
		$this->load->model('paginate');
	}

	
	public function getData($keyword, $page_id = 1)
	{
		
		$namespace  = $this->tb_article;
		$keyword_clone = $keyword;
		$keyword = unhyphen($keyword);
		$return_value = false;
		$page_id = $this->input->get('page');

		$pub_ids = array();
		$query_str = "SELECT article_id from cms_article where pub_status ='1'";
			$result = $this->db->query($query_str);
			$results = $result->result_array();
			$where_clause = " AND (article.id = ";
			foreach($results  as $index => $result)
			{
				$pub_ids[$index] = $result['article_id'];
				if($index == 0)
					$where_clause .= $pub_ids[$index];
				else
					$where_clause .= " OR article.id = ".$pub_ids[$index];
			}

		$where_clause .=")";
        $GLOBALS['where_clause']  = $where_clause;

		if(isWord($keyword))
		{
            if($this->not_allowed($keyword))
			  return false;

			

			$query_str = "SELECT count(*)  as count FROM article LEFT JOIN authors ON $namespace.auth_id = authors.id
			WHERE ( article.title LIKE '$keyword' 
			OR article.title LIKE '$keyword%' 
			OR article.title LIKE '%$keyword' 
			OR article.message LIKE '$keyword'
			OR article.message LIKE '%$keyword'
			OR article.message LIKE '$keyword%' 
			OR MATCH(tags) AGAINST('".$keyword."') ) ";
			$query_str .= $where_clause;

			//pagination created
			$config['rows_per_page'] = 5;
			$config['total_rows']  = $this->paginate->getRows($query_str, "count");
			$config['target_url']  = site_url('search/term').'/'.url_title($keyword_clone, '-');
			$config['page_id'] = $page_id;
			$this->paginate->initialize($config);
			$offset = $this->paginate->get_offset();
			$limit = $this->paginate->get_limit();
			$this->pagination_markup = $this->paginate->create_pagination3();
			$this->num_rows = $config['total_rows'];

			


			$namespace = $this->tb_article;
			$query_string = "SELECT $namespace.id, $namespace.title, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, 
			$namespace.img_alt,  $namespace.tags, $namespace.auth_id, authors.name
			FROM article LEFT JOIN authors ON $namespace.auth_id = authors.id
			WHERE ( article.title LIKE '$keyword' 
			OR article.title LIKE '$keyword%' 
			OR article.title LIKE '%$keyword' 
			OR article.message LIKE '$keyword'
			OR article.message LIKE '%$keyword'
			OR article.message LIKE '$keyword%' 
			OR MATCH(tags) AGAINST('".$keyword."'))
			";

			$query_string .= $where_clause;

			if(isset($offset) && isset($limit) && is_numeric($offset) && is_numeric($limit))
			{
				//append the LIMIT to the query_string;
				$query_string .= " LIMIT {$offset}, {$limit}";
			}
			$query_result = $this->db->query($query_string);
			if($query_result->num_rows() >= 1)
				$return_value = $query_result->result_array();
	
			return $return_value;
		}
		
	//At this point the $keyword is a string of words
	// So we explode it into array

	  $accepted_keywords = $this->get_accepted_keywords($keyword);

	  // Obtain unique ids for the articles
	  $unique_ids = $this->get_unique_ids($accepted_keywords);
	  if($unique_ids == null || empty($unique_ids))
	  	return false;

	  $this->result_ids = $unique_ids;
	  $this->num_rows = count($unique_ids);


	    $config['rows_per_page'] = 5;
		$config['total_rows']  = count($unique_ids);
		$config['target_url']  = site_url('search/term').'/'.url_title($keyword_clone, '-');
		$config['page_id'] = $page_id;
		$this->paginate->initialize($config);
		$offset = $this->paginate->get_offset();
		$limit = $this->paginate->get_limit();
		$this->pagination_markup = $this->paginate->create_pagination3();


	  $query_string = "SELECT $namespace.id, $namespace.title, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, 
						$namespace.img_alt,  $namespace.tags, $namespace.auth_id, authors.name
						FROM article LEFT JOIN authors ON article.auth_id = authors.id 
						WHERE ";
					
						//append the following to the above query_string
						foreach($unique_ids as $index => $id)
						{
							if($index == 0)
								$query_string .= "article.id = ".$id;
							else
                                $query_string .= " OR article.id = ".$id;
						}
		   	$query_string .= " ORDER BY article.pub_date DESC ";
		    $query_string .= " LIMIT {$offset}, {$limit}";

		return $this->db->query($query_string)->result_array();


	}



	public function not_allowed($value){
		$disallowed  = array(',', ';', '/' , '\"', '\" \"', "\'" , "\' \'", 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q','r', 's', 't','u', 'v', 'w', 'x', 'y', 'z',
			                   '[removed]', 'the', 'and', 'there', 'those', 'where', 'them', 'that', 'how', 'where', 'what');
		$double_letters = array();
		$status = false;

        //two characters of unallowed concatenated
		for($i = 0; $i < count($disallowed); $i++)
		{
			for($j = 0; $j < count($disallowed); $j++)
			{
				 $double_letters[$i][$j] = $disallowed[$i].''.$disallowed[$j];
			}
		}
	
		if(in_array($value, $disallowed))
			$status = true;
		else
		{
			$true_val = 0;
			
			foreach($double_letters as $letters)
			{
				foreach($letters as $val)
				{
					if($value == $val)
					$true_val++;
				}
			}

			if($true_val >= 1)
				$status = true;
		}

		return $status;
	}
	
	public function getIDs($search){

		if(isWord($search))
		{
			$query_string = "SELECT article.id FROM article
							WHERE (article.title LIKE '$search' 
							OR article.title LIKE '$search%' 
							OR article.title LIKE '%$search' 
							OR article.message LIKE '$search'
							OR article.message LIKE '%$search'
							OR article.message LIKE '$search%' 
							OR MATCH(tags) AGAINST('".$search."') )";
            $query_string .= $GLOBALS['where_clause'];
		   	$query_string .= " ORDER BY article.pub_date DESC";

			$query_result = $this->db->query($query_string);
			if($query_result->num_rows() >= 1)
				return $query_result->result_array();
		}

		return false;

	}


	public function get_unique_ids($accepted_keywords){
		$ids = array();  //ids in the array may be equal eg. [1, 2, 3, 1, 1, 3]. Therefore $ids are not distinct
		$stashed_ids = array();

		foreach($accepted_keywords as $index => $search_key)
		{
			if($this->getIDs($search_key))
				$ids[$index] =  $this->getIDs($search_key);  //getIDs function returns a 2-dimensional array, hence $ids becomes a 3-dimensional array
	           
		}
        

         $count = 0;
        foreach($ids as $id){
        	foreach($id as $list)
        	{
        	   $stashed_ids[$count]  = $list['id'];
        	   $count++;
        	}
        }

        return array_unique($stashed_ids);

	}

   public function get_accepted_keywords($keywords){
	   	$keywords = explode(' ', $keywords);
        $accepted_keywords = array();
        $count = 0;
        foreach ($keywords as $index => $keyword){
        	if(!$this->not_allowed($keyword))
			 {
			 	$accepted_keywords[$count] = $keyword;
			  }
			  $count++;
        }

        return $accepted_keywords;



   }


  function filter_search_term($search_term){
  	    $accepted_keywords = array();
        $count = 0;
        foreach (explode(' ', $search_term) as $index => $keyword){
        	if(!$this->not_allowed($keyword))
			 {
			 	$accepted_keywords[$count] = $keyword;
			  }
			  $count++;
        }

       return implode(" ", $accepted_keywords);

  }

	

	
}

