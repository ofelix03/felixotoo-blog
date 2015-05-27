<?php

class Article extends CI_Model{
	protected $tb_article = 'article';
	protected $tb_authors = 'authors';
	private $mysqli;


	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('custom_helper');
		$html = $this->load->library('prep_html');
		
		$this->mysqli = mysqli_inst($this->config->item('server'), $this->config->item('user'), $this->config->item('password'), $this->config->item('dbname'));
		

	}

	public function getDetailed($slug){
		$namespace = $this->tb_article;
		$query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug , $namespace.message, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt, $namespace.auth_id,  $namespace.tags, authors.name 
		FROM article, authors, cms_article
		WHERE $namespace.slug = '$slug' AND $namespace.auth_id= authors.id  AND cms_article.pub_status = '1' LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array();

		return false;
	}

	public function getTitle($id){
		$namespace = $this->tb_article;
		$query_string = "SELECT $namespace.title FROM article
		WHERE id  = '$id'  LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['title'];

		return false;

	}

	public function getDetailedById($id){
		$namespace = $this->tb_article;
		$query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug , $namespace.message, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt, $namespace.auth_id,  $namespace.tags, authors.name 
		FROM article, authors, cms_article
		WHERE $namespace.id = '$id' AND $namespace.auth_id= authors.id  AND cms_article.pub_status = '1' LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array();

		return false;

	}


	// public function addSlug(){
	// 	$query_string = "SELECT title from $this->tb_article";
	// 	$query_result = $this->db->query($query_string);
	// 	$result = $query_result->result_array();

	// 	foreach($result as $index => $value)
	// 	{
	// 		$res[$index] = $value['title'];
	// 		$slug[$index] = substr(url_title($value['title'], '-', TRUE), 0, 50);
	// 	}

	// 	foreach($slug as  $index => $sl)
	// 	{
	// 		$word = $res[$index];
	// 		$query_string = "UPDATE article SET slug = '$sl' WHERE title = ".$word;
	// 		$result = $this->db->query($query_string);
	// 	}
	// }

	public function getRelatedArticles($tags, $title, $limit = 25){
		$title = $this->mysqli->real_escape_string($title);
		$title = unhyphen($title);
		$query_string  = "SELECT title, pub_date, authors.name, authors.id, slug, thumb_name 
		FROM $this->tb_article, cms_article, authors 
		WHERE MATCH(tags) AGAINST('$tags') AND title NOT LIKE '$title' 
		AND  article.id = cms_article.article_id  AND article.auth_id = authors.id 
		AND cms_article.pub_status = '1' ORDER BY article.pub_date  DESC LIMIT 0, {$limit}";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();

		return false;
	}

	public function getAll($offset=0, $limit=25){
		if(!is_numeric($offset) && !is_numeric($limit))
			return false;
		//articles are returned in summary only 
		$namespace = $this->tb_article;
		// $query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt,  $namespace.tags, authors.id as auth_id, authors.name 
		// 				FROM article LEFT JOIN  authors ON $namespace.auth_id = authors.id  
		// 				ORDER BY $namespace.pub_date";
		$query_string = "SELECT article.id, article.title, article.summary, article.thumb_name, article.pub_date, article.img_alt, article.tags,  article.slug, authors.id as auth_id, authors.name from article, authors, cms_article where article.auth_id = authors.id
		and article.id = cms_article.article_id  and cms_article.pub_status = '1'";
		$query_string .= " ORDER BY pub_date DESC , title DESC   LIMIT {$offset}, {$limit}";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();

		return false;
	}



	public function getSummary($limit, $tags, $offset){
		//articles are returned in summary only
		$namespace = $this->tb_article;
		if(trim($tags) != '')
		{
			if(is_string($tags))
			{
				$tags = urldecode($tags);
				$query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt,  $namespace.tags, $namespace.auth_id , authors.name 
				FROM article, authors, cms_article WHERE article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.pub_status = '1'  
				AND match(tags) against('$tags')  ";
				
				$query_string .= " ORDER BY pub_date DESC, title ASC ";
			}

			if(isset($limit) AND is_numeric($limit) AND isset($offset) AND is_numeric($offset))
			{
				//append limit and offset to the $query_string genereated above
				$query_string .= "LIMIT ".$offset.",".$limit;
			}

			$query_result = $this->db->query($query_string);
			
			if($query_result->num_rows() >= 1)
			{
				return $query_result->result_array();
			}

			return false;
		}	
	}


	public function getArticlesByPubDate($offset = 0, $limit = 25, $pub_date = ''){
		//articles are returned in summary only 
		$namespace = $this->tb_article;
		// $query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt,  $namespace.tags, authors.id as auth_id, authors.name 
		// 				FROM article LEFT JOIN  authors ON $namespace.auth_id = authors.id  
		// 				ORDER BY $namespace.pub_date";
		$query_string = "SELECT article.id, article.title, article.summary, article.thumb_name, article.pub_date, article.img_alt, article.tags,  article.slug, authors.id as auth_id, authors.name from article, authors, cms_article where article.auth_id = authors.id
		and article.id = cms_article.article_id  and cms_article.pub_status = '1' ";
		if($pub_date != '')
			$query_string .= " AND article.pub_date LIKE '$pub_date%' ORDER BY pub_date DESC , title DESC  LIMIT {$offset}, {$limit}";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();

		return false;

	}


	public function getPublishedArticlesIds(){
		$query_string = "SELECT article.id  FROM article, cms_article WHERE article.id = cms_article.article_id AND cms_article.pub_status = '1'  ";
		$query_string .= " ORDER BY pub_date DESC, title DESC ";
		$results = $this->db->query($query_string);
		$results = $results->result_array();
		$id_list = array();

		foreach($results as $index => $result){
			$id_list[$index]  = $result['id'];
		}

		return $id_list;
	}


	public function getLatest($limit){
		//articles are returned in summary only
		$namespace = $this->tb_article;

		$query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug, $namespace.auth_id , authors.name 
		FROM article, authors, cms_article WHERE article.auth_id = authors.id AND article.id = cms_article.article_id AND
		cms_article.pub_status = '1' ";
		$query_string .= " ORDER BY pub_date DESC ";
		$query_string .= "LIMIT ".$limit;

		$query_result = $this->db->query($query_string);
		
		if($query_result->num_rows() >= 1)
		{
			return $query_result->result_array();
		}

		return false;
	}




	public function countTags($tags){
		if(!is_string($tags))
			return false;
		$query_string = "SELECT count(*) as count FROM article WHERE match(tags) against('".$tags."')";
		
		$count = $this->db->query($query_string)->result_array()[0]['count'];
		if($count)
			return $count;

		return false;
	}


    //get the total rows from a table
	public function getCount($query_string)
	{
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();
		
		return false;
	}


	public function getArticleTitles($auth_id, $limit)
	{
		$query_string = "SELECT $this->tb_article.title FROM article, cms_article  WHERE article.auth_id = '$auth_id' AND article.id = cms_article.article_id AND cms_article.pub_status = '1' LIMIT 0,".$limit;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();


		return false;
	}



	public function getByAuthor($id, $offset = 0, $limit = 25)
	{

		$namespace = 'article';
		if(!is_numeric($id))
		{
			return false;
		}

		$query_string = "SELECT $namespace.id, $namespace.title, $namespace.slug, $namespace.summary, $namespace.thumb_name, $namespace.pub_date, $namespace.img_alt,  $namespace.tags, $namespace.auth_id , authors.name 
		FROM article, authors WHERE $namespace.auth_id = '$id' AND '$id' = authors.id ORDER BY article.pub_date DESC LIMIT ".$offset.",".$limit;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() >= 1)
			return $query_result->result_array();


		return false;
	}




	public function tags_exploder($tags){
		$exploded_tags = explode(',', $tags);
	}


	public function create_slug($title){
		return url_title($title);
	}


	function search_array($haystack, $array, $filter = "prev"){
		$return_item;
		$count = count($array);
		
		if($filter == "prev")
		{
			for($i = 0; $i < $count; $i++)
			{
				if($array[$i] == $haystack && $i != 0)
					$return_item = $array[$i - 1];
				else if($array[$i]  && $i == 0)
				{
			    	//item is the first on the array list return the same item
					$return_item = $array[$i];
				}

			}
		}
		else if($filter == "next")
		{
			for($i = 0; $i < $count; $i++)
			{
				if($array[$i] == $haystack && $i != ($count - 1))
				{
					$return_item = $array[$i + 1]; 
				}
				else if($array[$i]  == $haystack && $i == ($count - 1)){
					$return_item = $array[$i];
				}

			}
		}

		if(empty($return_item))
			return false;

		return $return_item;
	}


	function getPrevArticleId($cur_article_id){
		$ids = $this->getPublishedArticlesIds();  //get all article ids that are pubilshed
		$prev_item_id = $this->search_array($cur_article_id, $ids);
		if($prev_item_id == $cur_article_id)
		{
		 	//there is no prev item
			return false;
		}

		return $prev_item_id;

	}


	function getNextArticleId($cur_article_id){
		$ids = $this->getPublishedArticlesIds();  //get all article ids that are pubilshed
		$next_item_id = $this->search_array($cur_article_id, $ids, "next");
		if($next_item_id == $cur_article_id)
		{
		 	//there is no prev item
			return false;
		}

		return $next_item_id;

	}

	

	public function getPreviousArticleTitle($cur_article_id){
		$namespace = $this->tb_article;
		$id = $this->getPrevArticleId($cur_article_id);
		$query_string = "SELECT $namespace.title FROM article
		WHERE id  = '$id'  LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['title'];

		return false;

	}

	public function getNextArticleTitle($cur_article_id){
		$namespace = $this->tb_article;
		$id = $this->getNextArticleId($cur_article_id);
		$query_string = "SELECT $namespace.title FROM article
		WHERE id  = '$id'  LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['title'];

		return false;

	}

	public function getPreviousArticleSlug($cur_article_id){
		$namespace = $this->tb_article;
		$id = $this->getPrevArticleId($cur_article_id);
		$query_string = "SELECT $namespace.slug FROM article
		WHERE id  = '$id'  LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['slug'];

		return false;

	}


	public function getNextArticleSlug($cur_article_id){
		$namespace = $this->tb_article;
		$id = $this->getNextArticleId($cur_article_id);
		$query_string = "SELECT $namespace.slug FROM article
		WHERE id  = '$id'  LIMIT 1" ;
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows() == 1)
			return $query_result->result_array()[0]['slug'];

		return false;

	}






	function getPrevious($prev_item_id){
		$query_string = "SELECT article.id, article.title, article.message, article.thumb_name, article.pub_date, article.img_alt, article.tags,  article.slug, authors.id as auth_id, authors.name from article, authors, cms_article where article.id = '$prev_item_id' AND article.auth_id = authors.id
		and article.id = cms_article.article_id  and cms_article.pub_status = '1' ";
		$result = $this->db->query($query_string);
		$result = $result->result_array();
		return $result;

		
	}

	function getNext($next_item_id){
		//get all article ids that are pubilshed
		// $ids = $this->getPublishedArticlesIds();
		// $next_item_id = $this->search_array($article_id, $ids, "next");
		$query_string = "SELECT article.id, article.title, article.message, article.thumb_name, article.pub_date, article.img_alt, article.tags,  article.slug, authors.id as auth_id, authors.name from article, authors, cms_article where article.id = '$next_item_id' AND article.auth_id = authors.id
		and article.id = cms_article.article_id  and cms_article.pub_status = '1' ";
		$result = $this->db->query($query_string);
		$result = $result->result_array();
		return $result;

		
	}

	function getImg($article_id){
		$query_string = "SELECT thumb_name FROM article WHERE id = '$article_id'";
		$result = $this->db->query($query_string);
		if($result->num_rows() == 1)
			return $result->result_array()[0]['thumb_name'];

	}

}