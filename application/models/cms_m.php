<?php 

class Cms_m extends CI_Model{
	private $tb_cms_articles = 'cms_article';
	private $tb_articles = 'article';



	public function __construct()
	{
		$this->load->database();
	}

	public function getArticles($user_id, $order_by = '', $order = '', $offset = 0, $limit = 100){
		$cms_article = $this->tb_cms_articles;
		$article = $this->tb_articles;

		$query_string = "SELECT article.title, article.id, article.pub_date, authors.id as auth_id, authors.name, cms_article.pub_status, cms_article.del_status 
						FROM article, authors, cms_article  
						WHERE article.auth_id = {$user_id} AND article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.del_status = '0' ";
	
		if($order_by != '' && $order != '')
		{
			$append_query = " ORDER BY ".$order_by." ".$order;
			$query_string  .= $append_query;
		}
		else
		{
			$append_query = " ORDER BY article.pub_date DESC";
			$query_string .= $append_query;
		}

		//add offset and limit if any
		$query_string .= " LIMIT {$offset}, {$limit} ";
		$query_result = $this->db->query($query_string);
		if($query_result->num_rows >= 1)
			return $query_result->result_array();
		return false;
	}



	  //search model for the search form in cms.php
	public function search($search_option, $search_value, $access_levels ,  $order_by = '', $order = ''){
		$search_value = trim($search_value);
		$query_string = "SELECT article.title, article.id, article.pub_date, authors.id as auth_id, authors.name, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and article.auth_id = authors.id and del_status = '0'  and  ";
		if($search_option == "author name")
			$query_string .=  " authors.name LIKE   '%$search_value%' ";
		else if($search_option == "article title")
			$query_string .= " article.title  LIKE '%$search_value%'";
		else if($search_option == "article published date")
			$query_string .= " article.pub_date = '$search_option'";
		else  if($search_option == "")
			$query_string .= " article.title  = ''";

		if($order_by != '' && $order != '')
		{
			$append_query = " ORDER BY ".$order_by." ".$order;
		}
		else
		{
			if($search_option == "author name")
				$append_query = "  ORDER BY authors.name DESC";
			else if($search_option == "article title")
				$append_query = " ORDER BY article.title DESC";
			else if($search_option == "article published date")
				$append_query = " ORDER BY article.pub_date DESC";
			else
				$append_query = " ORDER BY article.title DESC";

		}
		$query_string  .= $append_query;
		$query_result = $this->db->query($query_string);
		return $query_result->result_array();
	}





	public function get_published($user_id, $access_levels,  $order_by = '', $order = '', $offset = 0, $limit= 100){
		$article = $this->tb_articles;
		if($access_levels >= 1)
			$query_string = "SELECT article.title, article.id,  article.pub_date , authors.name, authors.id as auth_id, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id  and del_status = '0' and pub_status = '1' and article.auth_id = authors.id  and article.auth_id = '$user_id' and pub_status = '1'";
		else if($access_levels == 0 )
			$query_string = "SELECT article.title, article.id, article.pub_date ,  authors.name,  authors.id as auth_id ,cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and del_status = '0' and pub_status = '1'  and article.auth_id = authors.id ";

		if($order_by != '' && $order != '')
		{
			$append_query = " ORDER BY ".$order_by." ".$order;
			$query_string  .= $append_query;
		}
		else
		{
			$append_query = "ORDER BY article.id DESC";
			$query_string .= $append_query;
		}

		$query_string .= " LIMIT {$offset}, {$limit}";
		$query_result = $this->db->query($query_string);
		return $query_result->result_array();
	}


	public function get_unpublished($user_id , $access_levels, $order_by = '', $order = ''){
		$article = $this->tb_articles;
		if($access_levels >= 1)
			$query_string = "SELECT article.title, article.id, article.pub_date, authors.name, authors.id  as auth_id, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and del_status = '0' and article.auth_id = authors.id and article.auth_id = '$user_id' and pub_status = '0'";
		else if($access_levels == 0)
			$query_string = "SELECT article.title, article.id, article.pub_date, authors.name, authors.id  as auth_id, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and del_status = '0' and article.auth_id = authors.id  and pub_status = '0'";

		if($order_by != '' && $order != '')
		{
			$append_query = " ORDER BY ".$order_by." ".$order;
			$query_string  .= $append_query;
		}
		else
		{
			$append_query = "ORDER BY article.id DESC";
			$query_string .= $append_query;
		}
		$query_result = $this->db->query($query_string);
		return $query_result->result_array();
	}


	public function get_trashed($user_id , $access_levels, $order_by = '', $order = '', $offset= 0, $limit = 25){
		$article = $this->tb_articles;
		if($access_levels >= 1)
			$query_string = "SELECT article.title, article.id, authors.name, authors.id as auth_id, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and del_status = '1' and article.auth_id = authors.id and article.auth_id = '$user_id' and pub_status = '0'";
		else if($access_levels == 0)
			$query_string = "SELECT article.title, article.id, authors.name, authors.id as auth_id, cms_article.pub_status, cms_article.del_status from cms_article,  article, authors where article.id = article_id and del_status = '1' and article.auth_id = authors.id  and pub_status = '0'";

		if($order_by != '' && $order != '')
		{
			$append_query = " ORDER BY ".$order_by." ".$order;
			$query_string  .= $append_query;
		}
		else
		{
			$append_query = "ORDER BY article.id DESC";
			$query_string .= $append_query;
		}

		$query_string .= " LIMIT ".$offset.','.$limit;
		$query_result = $this->db->query($query_string);
		return $query_result->result_array();
	}



	public function publish($ids = array()){
		$failed_ids = array();
		// if(is_array($ids))
		// {

		//  //loop through ids to implement publish 
		//  foreach($ids as $index => $id)
		//  {
		//      $query_string = "UPDATE cms_article SET pub_status = '1'  WHERE article_id = ".$id;
		//      $query_result  = $this->db->query($query_string);
		//      if($this->db->affected_rows() != 1)
		//      {
		//          $failed_ids[$index] = $id;
		//      }
		//  }

		//  if(count($failed_ids) >= 1)
		//      return $failed_ids;
		// }
		// else
		// {
		//  $query_string = "UPDATE cms_article SET pub_status = '1' WHERE article_id = '$ids' LIMIT 1";
		//  $query_result  = $this->db->query($query_string);
		//  if($this->db->affected_rows() != 1)
		//      return $ids;
		// }


		if(is_array($ids))
		{

			//select all ids that are already published i.e with a pub_status = '1'
			$query_string = "SELECT cms_article.article_id from cms_article where ";
			foreach($ids as $index => $id){
				if($index == 0)
				{
					$query_string .= " cms_article.pub_status = '1'  AND cms_article.del_status = '0' AND cms_article.article_id = '$id' ";
				}
				else
					$query_string .= " OR cms_article.pub_status = '1' AND cms_article.del_status = '0' AND cms_article.article_id = '$id' ";
			}
			
			$result = $this->db->query($query_string);
			$result = $result->result_array();
			//iterate throught mulit-dimensional array to fetch the ids
			foreach($result as $index => $row){
				foreach($row as $article_id){
					$failed_ids[$index] = $article_id;  //stores already published article's id
				}
			}


			//loop through ids to implement publish 
			$query_string = "UPDATE cms_article  SET pub_status = '1', del_status = '0' WHERE ";
			foreach($ids as $index => $id)
			{
				if($index == 0)
				  $query_string .= " article_id = '$id' ";
			  else
				$query_string .= " OR article_id = '$id' ";

		}
		$query_result  = $this->db->query($query_string);

		$pub_date = date('Y-m-d', time());
			//loop through ids to update the pub_date 
		$query_string = "UPDATE article  SET pub_date = '$pub_date'  WHERE ";
		foreach($ids as $index => $id)
		{
			if($index == 0)
			  $query_string .= " article.id = '$id' ";
		  else
			$query_string .= " OR article.id = '$id' ";

	}
	$query_result  = $this->db->query($query_string);


	if(count($failed_ids) >= 1)
		return array('success_sate'  => TRUE , 'failed_ids' => $failed_ids);
	
}
else
{

	$pub_date = date('Y-m-d', time());

	$query_string = "UPDATE cms_article SET  pub_status = '1', del_status = '0' WHERE article_id = '$ids' LIMIT 1";
	$query_result  = $this->db->query($query_string);
	if($this->db->affected_rows() != 1)
	{
		return array('failed_ids' => $ids);
	}


			//update the publish date of the article
	$pub_date = date('Y-m-d', time());
	$query_string = "UPDATE article SET pub_date = '$pub_date' WHERE article.id = '$ids' LIMIT 1";
	$query_result = $this->db->query($query_string);
}


return TRUE;

}


public function get_article($article_id){
	$query_string = "SELECT article.* , authors.name, cms_article.pub_status FROM article, authors, cms_article WHERE article.id = '$article_id' AND auth_id = authors.id and article.id = cms_article.article_id ";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0];

	return false;
}

public function unpublish($ids = array()){
	$failed_ids = array();
		// if(is_array($ids))
		// {
		//  //loop through ids to implement publish 
		//  foreach($ids as $index => $id)
		//  {
		//      $query_string = "UPDATE cms_article SET pub_status = '0' WHERE article_id = ".$id;
		//      $query_result  = $this->db->query($query_string);
		//      if($this->db->affected_rows() == 0)
		//      {
		//          $failed_ids[$index] = $id;
		//      }
		//  }

		//  if(count($failed_ids) >= 1)
		//      return $failed_ids;
		// }
		// else
		// {
		//  $query_string = "UPDATE cms_article SET pub_status = '0' WHERE article_id = '$ids' ";
		//  $query_result  = $this->db->query($query_string);
		//  if($this->db->affected_rows() == 0)
		//      return $ids;
		// }


	if(is_array($ids))
	{

			//select all ids that are already unpublished i.e with a pub_status = '0'
		$query_string = "SELECT cms_article.article_id from cms_article where ";
		foreach($ids as $index => $id){
			if($index == 0)
			{
				$query_string .= " cms_article.pub_status = '0' AND  cms_article.article_id = ".$id;
			}
			else
				$query_string .= " OR cms_article.pub_status = '0' AND   cms_article.article_id = ".$id;
		}
		
		$result = $this->db->query($query_string);
		$result = $result->result_array();
			//iterate throught mulit-dimensional array to fetch the ids
		foreach($result as $index => $row){
			foreach($row as $article_id){
					$failed_ids[$index] = $article_id;  //stores already published article's id
				}
			}





			//loop through ids to implement unpublish 
			$query_string = "UPDATE cms_article SET pub_status = '0' WHERE ";
			foreach($ids as $index => $id)
			{
				if($index == 0)
				  $query_string .= " article_id = '$id' ";
			  else
				$query_string .= " OR article_id = '$id' ";
		}

		$query_result  = $this->db->query($query_string);
		
		if(count($failed_ids) >= 1)
			return array('success_sate'  => TRUE , 'failed_ids' => $failed_ids);
	}
	else
	{
		$query_string = "UPDATE cms_article SET pub_status = '0' WHERE article_id = '$ids' LIMIT 1";
		$query_result  = $this->db->query($query_string);
		if($this->db->affected_rows() != 1)
			return array('failed_ids' => $ids);
	}

	return TRUE;

}



	//set the delete status of an article to 1 ie. Temporarily delete an article.
public function delete($ids = '')
{
	if(!empty($ids) && !is_array($ids)){
			$id = $ids; //this is a single id, not an array of ids
			$query_string = "UPDATE cms_article SET del_status = '1' , pub_status = '0' WHERE cms_article.article_id = '$id'  ";
			$this->db->query($query_string);
			if($this->db->affected_rows() == 0 )
				$failed_ids = $id;
		}
		else
		{
			//an arrays  of article ids used here
			$del_status = false;
			$count = 0;
			foreach($ids as $id){
				$query_string = "UPDATE cms_article SET del_status = '1' , pub_status = '0' WHERE cms_article.article_id = '$id'  ";
				$this->db->query($query_string);
				if(!$this->db->affected_rows() == 1)
				{
					$failed_ids[$count] = $id;
					$count++;
				}
			}
		}

		if(isset($failed_ids) && count($failed_ids) >= 1)
			return array('failed_ids' => $failed_ids);
		else
			return array('failed_ids' => FALSE);

		// if(isset($failed_ids) && count($failed_ids) >= 1)
		//  return $failed_ids;  //ids that couldnt be updated
		// else
		//  return "true"; // if all ids were updatedSET

	}
	

	//set the del status of an article to 0 ie (undelete an article )
	public function undelete($ids = '')
	{
		if(!empty($ids) && !is_array($ids)){
			$id = $ids;
			$query_string = "UPDATE cms_article SET del_status = '0' , pub_status = '0' WHERE cms_article.article_id = '$id'  ";
			$this->db->query($query_string);
			if($this->db->affected_rows() == 0 )
				$failed_ids = $id;
		}
		else{
			$del_status = false;
			$count = 0;
			foreach($ids as $id){
				$query_string = "UPDATE cms_article SET del_status = '0' , pub_status = '0' WHERE cms_article.article_id = '$id'  ";
				$this->db->query($query_string);
				if(!$this->db->affected_rows() == 1)
				{
					$failed_ids[$count] = $id;
					$count++;
				}
			}
		}

		if(isset($failed_ids) && count($failed_ids) >= 1)
			return $failed_ids;  //ids that couldnt be updated
		else
			return "true"; // if all ids were updatedSET

	}

	
   //permanently delete an article
	public function permanent_delete($ids = '')
	{
		if(!empty($ids) && !is_array($ids)){
			$query_string = "DELETE FROM article WHERE article.id = '$ids' ";
			$this->db->query($query_string);
			if($this->db->affected_rows() == 0 )
				$failed_ids = $id;
		}
		else
		{
			$del_status = false;
			$count = 0;
			foreach($ids as $id){
				$query_string = "DELETE FROM  article WHERE article.id = '$id' ";
				$this->db->query($query_string);
				if(!$this->db->affected_rows() == 1)
				{
					$failed_ids[$count] = $id;
					$count++;
				}
			}
		}

		if(isset($failed_ids) && count($failed_ids) >= 1)
			return $failed_ids;  //ids that couldnt be updated
		else
			return true; // if all ids were updatedSET

	}

	function delete_author($ids){
		$query_string = "DELETE FROM authors WHERE ";
		if(!is_array($ids))
			$query_string .= " id = '$ids'";
		else
		{
			foreach($ids as $id)
				$query_string .= " || id = '$id' ";
		}
		$this->db->query($query_string);
		if($this->db->affected_rows() >= 1)
			return true;
		return false;

	}

	public function published_num_rows($user_id){
		$query_string = "SELECT count(title) as count FROM article LEFT JOIN  cms_article ON article.id = cms_article.article_id AND article.auth_id = '$user_id' WHERE pub_status = '1'  and del_status = '0'";
		
		$result = $this->db->query($query_string);
		return $result->result_array()[0]['count'];
	}

	public function unpublished_num_rows($user_id){
		$query_string = "SELECT count(title) as count FROM article LEFT JOIN  cms_article ON article.id = cms_article.article_id AND article.auth_id = '$user_id' WHERE pub_status = '0' and del_status = '0' ";
		
		$result = $this->db->query($query_string);
		return $result->result_array()[0]['count'];
	}

	public function trashed_num_rows($user_id){
		$query_string = "SELECT count(title) as count FROM article LEFT JOIN  cms_article ON article.id = cms_article.article_id AND article.auth_id = '$user_id' WHERE pub_status = '0' and del_status = '1' ";
		
		$result = $this->db->query($query_string);
		return $result->result_array()[0]['count'];
	}

	public function view_all_num_rows($user_id){
		$query_string = "SELECT count(title) as count FROM article LEFT JOIN  cms_article ON article.id = cms_article.article_id AND article.auth_id = '$user_id' WHERE del_status = '0' and (pub_status = '0' OR  pub_status = '1') ";
		
		$result = $this->db->query($query_string);
		return $result->result_array()[0]['count'];
	}

	public function insert_new_article($data){

		$return_status = false;
		$article = $data[0];
		$thumbnail = $data[1];
		$auth_id = $article['auth_id'];
		$title = mysqli()->real_escape_string($article['title']);
		$summary = mysqli()->real_escape_string($article['summary']);
		$message = mysqli()->real_escape_string($article['message']);
		$pub_date = $article['pub_date'];
		$pub_status = $article['pub_status'];
		$slug = strtolower($article['slug']);
		$tags = strtolower($article['tags']);
		$thumb_alt = isset($article['thumb_alt'])? $article['thumb_alt'] : NULL;


		$thumb_name = isset($thumbnail['file_name'])? $thumbnail['file_name'] : NULL;
		$thumb_width =isset($thumbnail['image_width'])? $thumbnail['image_width'] : NULL;
		$thumb_height =isset($thumbnail['image_height'])? $thumbnail['image_height'] : NULL;
		$thumb_mime = isset($thumbnail['image_type'])? $thumbnail['image_type'] : NULL;
		$thumb_size = isset($thumbnail['file_size'])? $thumbnail['file_size'] : NULL;

		//insert article and related thumbnail data into database
		$query_string = "INSERT into article (auth_id, title, summary, message, pub_date, slug, tags,  thumb_name, img_alt, thumb_width, thumb_height, thumb_size)
		values('$auth_id', '$title', '$summary', '$message', '$pub_date', '$slug', '$tags', '$thumb_name', '$thumb_alt', '$thumb_width', '$thumb_height',
			'$thumb_size')";
$this->db->query($query_string);
if($this->db->affected_rows() == 1)
{
					//retrieve last article_ insert_id
	$last_insertion_id = $this->db->insert_id();
	if($pub_status  == 'y')
		$pub_status = '1';
	else
		$pub_status = '0'; 
	$query_string = "INSERT into cms_article(article_id, pub_status, del_status) values('$last_insertion_id', '$pub_status', '0')";
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
		$return_status = $last_insertion_id;

}

return $return_status;
}



public function update_article($data){

	$return_status = false;
	if(count($data) == 2){
		$article = $data[0];
		$thumbnail = $data[1];

		$thumb_name = isset($thumbnail['file_name'])? $thumbnail['file_name'] : NULL;
		$thumb_width =isset($thumbnail['image_width'])? $thumbnail['image_width'] : NULL;
		$thumb_height =isset($thumbnail['image_height'])? $thumbnail['image_height'] : NULL;
		$thumb_mime = isset($thumbnail['image_type'])? $thumbnail['image_type'] : NULL;
		$thumb_size = isset($thumbnail['file_size'])? $thumbnail['file_size'] : NULL;

	}
	else
	{
		$article = $data;
	}

	$auth_id = $article['auth_id'];
	$article_id = $article['id'];
	$title = $this->db->escape($article['title']);
	$summary = htmlentities( $this->db->escape($article['summary']));
	$message =  htmlentities($this->db->escape( $article['message']));
	$pub_date = $article['pub_date'];
	$pub_status = $article['pub_status'];
	$slug = strtolower( $article['slug']);
	$tags = strtolower($article['tags']);
	$last_modified_date = $article['last_modified'];
	$thumb_alt = isset($article['thumbnail_alt'])? $article['thumbnail_alt'] : NULL;

	


		//Continue to update the datbase with $data
	$query_string = "UPDATE article, cms_article 
	SET article.title= $title, article.summary = $summary ,  article.message = $message, article.slug = '$slug', 
	article.tags = '$tags', img_alt = '$thumb_alt',  article.last_modified = '$last_modified_date', article.pub_date = '$pub_date', cms_article.pub_status = '$pub_status' ";
	if(isset($thumbnail))
		$query_string .= " ,thumb_name = '$thumb_name', thumb_width = '$thumb_width', thumb_height = '$thumb_height', thumb_mime = '$thumb_mime', thumb_size = '$thumb_size' ";

	$query_string .= " where article.id = '$article_id' and cms_article.article_id = article.id";

	$this->db->query($query_string);
	if($this->db->affected_rows() >= 1 && $this->db->affected_rows() <= 2)
		return true;

	return false;
}

public function validate_login_details($data){

		//query the database 
	if(isset($data['field']))
	{
		$col_name = $data['field'];
		$keyword = $data['field_val'];
		if(substr($col_name, 0, 1) == 'u')
			$query_string = "select * from cms_user where username = '$keyword' limit 1";
		else if(substr($col_name, 0, 1) == 'p')
			$query_string = "select * from cms_user where password = '$keyword' limit 1";
	}
	else
	{
		$username = $data['username'];
		$password = $data['password'];
		$query_string = "select user_id, username, name as fullname, access_level from cms_user, authors where username='$username' AND password = '$password'  AND cms_user.user_id = authors.id limit 1";
	}
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0];

	return false;

}


public function author_delete($ids){
	$failed_ids = array();


	if(!is_array($ids))
		$ids = array($ids);



	foreach($ids as $index => $id){
		$query_string = "DELETE FROM authors WHERE id = '$id'";
		$this->db->query($query_string);
		if($this->db->affected_rows() != 1)
			$failed_ids[$index] = $id;
	}

	if(count($failed_ids) >= 1)
		return $failed_ids;





	return "TRUE";

}

public function get_authors($order_by = '', $order){
	$query_string = "SELECT * FROM cms_user ";
	if(!empty($order_by) && !empty($order)){
		$query_string .= "ORDER BY ". $order_by . " ".$order;
	}
	$result = $this->db->query($query_string);
	if($result->num_rows() >= 1)
		return $result->result_array();

	return false;

}


public function get_article_num($id){
	$query_string = "select count(*) as count from article where auth_id = '$id'";
	$result = $this->db->query($query_string);
	$result = $result->result_array()[0]['count'];
	return $result;
}

public function get_author_profile($id){
	$query_string = "SELECT authors.*, cms_user.username, cms_user.password, auth_thumb_details.* FROM authors, cms_user, auth_thumb_details where id = '$id' and authors.id = cms_user.user_id and auth_thumb_details.authors_id = '$id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() >= 1)
	{
		$result = $result->result_array();
		return $result[0];
	}

	return false;

}

public function get_authors_grid(){
	$query_string = "SELECT cms_user.user_id, cms_user.username,  auth_thumb_details.thumb_name FROM  cms_user LEFT JOIN  auth_thumb_details ON cms_user.user_id =  auth_thumb_details.authors_id";
	$results = $this->db->query($query_string);
	if($results->num_rows() >= 1)
	{
		$results = $results->result_array();
		$final_results = array();
		foreach($results as $index => $result){
			$auth_id = $result['user_id'];
			$query_string = "select count(*) as article_num from article where auth_id = '$auth_id'";
			$count = $this->db->query($query_string);
			if($count->num_rows() == 1)
			{
				$count = $count->result_array()[0]['article_num'];
				$result['article_num'] = $count;
				$final_results[$index] = $result;
			}
		}
		return $final_results;
	}

	return false;

}


public function get_auth_thumb($id){
	$query_string = "SELECT auth_thumb from authors where id = '$id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0]['auth_thumb'];

	return '';

}


public function update_author($data){
	$return_statsu = false;
	if(count($data) == 2){
		$author = $data[0];
		$thumbnail = $data[1];

		$thumb_name = isset($thumbnail['file_name'])? $thumbnail['file_name'] : NULL;
		$thumb_width =isset($thumbnail['image_width'])? $thumbnail['image_width'] : NULL;
		$thumb_height =isset($thumbnail['image_height'])? $thumbnail['image_height'] : NULL;
		$thumb_mime = isset($thumbnail['image_type'])? $thumbnail['image_type'] : NULL;
		$thumb_size = isset($thumbnail['file_size'])? $thumbnail['file_size'] : NULL;

	}
	else
	{
		$author = $data;
	}

	$user_id = $author['user_id'];
	$username = $author['username'];
	$password = $author['password'];
	$name = $author['name'];
	$sex = $author['sex'];
	$age = $author['age'];
	$profession = $author['profession'];
	$in_brief = $author['in_brief'];
	$social_networks = $author['social_networks'];
	$websites = $author['websites'];
	$thumb_alt = isset($article['thumbnail_alt'])? $article['thumbnail_alt'] : NULL;


	$thumbnail_update_status = false;
	$author_update_status = false;
	//Continue to update the datbase with $data
	$query_string = "UPDATE authors, cms_user  SET cms_user.username = '$username', cms_user.password = '$password', name = '$name', age = '$age', sex = '$sex', profession = '$profession', in_brief = '$in_brief', social_networks = '$social_networks',
	websites = '$websites' ";
	$query_string .= " WHERE id = '$user_id' AND cms_user.user_id = '$user_id' ";

	$this->db->query($query_string);
	if($this->db->affected_rows()  == 1 )
	{
		$author_update_status = true;
	}

	if(isset($thumbnail))
	{
		//update of author details successful.
		//now upate author thumbnail details
		$query_string = "UPDATE auth_thumb_details SET thumb_name = '$thumb_name', thumb_width = '$thumb_width', thumb_height='$thumb_height', thumb_mime = '$thumb_mime', thumb_size = '$thumb_size' WHERE authors_id = '$user_id'";
		$this->db->query($query_string);
		if($this->db->affected_rows() == 1)
		{
			$thumbnail_update_status = true;
		}
	}

	if($thumbnail_update_status === true || $author_update_status === true)
	   return true;

   return false;
}


public function insert_new_author($data){


	$return_statsu   = false;
	$author 		 = $data[0];
	$thumbnail 	  	 = $data[1];
	$username 		 =  $author['username'];
	$password		 = $author['password'];
	$access_levels   =  $author['access_level'];
	$name 			 = isset($author['name'])? $author['name'] : null;
	$age 			 = isset($author['age'])? $author['age'] : null;
	$sex 			 = isset($author['sex'])? $author['sex'] : null;
	$profession		 = isset($author['profession'])? $author['profession'] : null;
	$in_brief 		 = isset( $author['in_brief'])?  $author['in_brief'] : null;
	$social_networks = isset($author['social_networks'])? $author['social_networks'] : null;
	$websites 		 = isset($author['websites'])? $author['websites'] : null;


	$thumb_name 	 = isset($thumbnail['file_name'])? $thumbnail['file_name'] : NULL;
	$thumb_width	 =isset($thumbnail['image_width'])? $thumbnail['image_width'] : NULL;
	$thumb_height	 =isset($thumbnail['image_height'])? $thumbnail['image_height'] : NULL;
	$thumb_mime 	 = isset($thumbnail['image_type'])? $thumbnail['image_type'] : NULL;
	$thumb_size 	 = isset($thumbnail['file_size'])? $thumbnail['file_size'] : NULL;
	$thumb_alt 		 = isset($thumbnail['thumb_alt'])? $thumbnail['thumb_alt'] : NULL;

		//insert article and related thumbnail data into database
	$query_string = "INSERT into authors (name, age, sex, profession, in_brief, social_networks, websites)
	values('$name', '$age', '$sex', '$profession', '$in_brief', '$social_networks', '$websites')";
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
	{
	   $author_id = $this->db->insert_id();
			 //insert thumbnial details
	   $query_string = "INSERT INTO auth_thumb_details (authors_id, thumb_name, thumb_width, thumb_height, thumb_mime, thumb_size)
	   values('$author_id', '$thumb_name', '$thumb_width', '$thumb_height', '$thumb_mime', '$thumb_size')";
	   $this->db->query($query_string);    


			 //update authors cms_user details
	   $query_string = "INSERT into cms_user (user_id, username, password, access_level)
	   values('$author_id', '$username', '$password', '$access_level')";
	   $this->db->query($query_string);

	   if($this->db->affected_rows() == 1)
		return true;

}



return false;
}




public function add_new_author_credentials($data){
	print_r($data);

}

public function add_carousel_article_data($data = array()){
	$brief = mysqli()->real_escape_string($data['description']);
	$caption = mysqli()->real_escape_string($data['title']);
	$thumbnail  = $data['thumbnail'];
	$caption_color = mysqli()->real_escape_string($data['title_color']);
	$brief_color = mysqli()->real_escape_string($data['description_color']);
	$link_color = mysqli()->real_escape_string($data['link_color']);
	$link = mysqli()->real_escape_string($data['link']);
	$article_id = $data['article_id'];
	$action = $data['action'];

	if($action == 'insert')
	{

		//copy article img to carousel img directory
		$source = FCPATH.'asset/img/article_thumbnails/'.$thumbnail;
		$dest = FCPATH.'asset/img/carousel/'.$thumbnail;
		copy($source, $dest);
	    $query_string = "INSERT INTO carousel(carousel_name, article_id, caption, brief, link, link_color, caption_color, brief_color) 
	    				VALUES('$thumbnail', '$article_id', '$caption', '$brief', '$link', '$link_color', '$caption_color', '$brief_color'); ";
	}
	else if($action == 'update')
	{
		$query_string = "UPDATE carousel 
						SET carousel_name='$thumbnail', caption='$caption', brief='$brief', link='$link', link_color='$link_color', caption_color='$caption_color', brief_color='$brief_color'
						WHERE article_id='$article_id'";    
	}
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
		return true;
	
	false;


}
public function getArticleImgs($ids){
	//error here that needs to be fixed:
	//ERROR : no data retrieved with select statement
   $query_string = "SELECT * FROM article where id = ";
	$where = "";

	if(is_array($ids)){
		foreach($ids as  $index => $id)
		{
			if($index == 0)
				$where .= $id;
			else
				$where .= " OR id = ".$id;
		}
	}
	else{
		$where .= $ids;
	}

	$query_string .= $where;
	$query_string .= " ;";

	$result = $this->db->query($query_string);
	if($result->num_rows() >= 1)
	{
		return $result->result_array();
	}

	return false;
}

public function getImg($id){
	$query_string = "SELECT thumb_name FROM article WHERE id='$id'"; 
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0]['thumb_name'];

	return false;
}



public function delArticleImgs($ids){
	if(is_array($ids)){
		foreach($ids as $index => $id)
		{
		   if($path = $this->getImg($id))
		   {
				 $path =   FCPATH.'asset/img/article_thumbnails/'.$path;
				 $this->unlink_file($path);				   }
		   }
   }
   else
   {
		//single article
	   if($path = $this->getImg($ids))
	   {
			$path =   FCPATH.'asset/img/article_thumbnails/'.$path;
		 	$this->unlink_file($path);
	   }
	  
	}


	// return $return_value;
}

public function getCarouselImg($ids){
	// $id = $id[0];
	$query_string = "SELECT carousel_name FROM carousel WHERE article_id = ";
	$where = "";

	if(is_array($ids)){
		foreach($ids as  $index => $id)
		{
			if($index == 0)
				$where .= $id;
			else
				$where .= " OR article_id = ".$id;
			
		}

	}
	else{
		$where .= $ids;
	}

	$query_string .= $where;
	$query_string .= " ;";

	$result = $this->db->query($query_string);
	if($result->num_rows() >= 1)
	{
		return $result->result_array();
	}

	return false;
}



public function delCarousel($ids, $file_path = ''){
	if($file_path !== false && is_array($ids)){
	$img_path = FCPATH.'asset/img/carousel/';
		foreach($ids as $index => $id)
		{
			if($this->delCarouselRow($id)){
			   $this->unlink_file($img_path.$file_path[$index]['carousel_name']); //article deleted, delete it carousel img;

		   }
	   }
	   
   }
   else if(!is_array($ids))
   {
		//single article
		if($this->delCarouselRow($ids)){
		   $this->unlink_file($file_path[0]['carousel_name']);
		}
	}
	// return $return_value;
}

public function delCarouselRow($id){
	$query_string = "DELETE FROM carousel WHERE article_id = '$id'";
	

	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)     
		return true;

	return false;

}


public function unlink_file($file_path){
   if($file_path == false || $file_path == "")
	 return false;
   if(unlink($file_path))
	 return true;

	return false;
}

public function getCarouselData($id){
	$query_string = "SELECT brief, link_color, brief_color, caption_color FROM carousel WHERE article_id = '$id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0];
	return false;
}


function addAuthor(){
	//update the parent table authors to prevent foreign key constrant erro
	$query_string = "INSERT INTO authors(name) VALUES('')";
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
		return $this->db->insert_id();
	return false;
}

function addAuthorLoginCredentials($data = array()){
	$auth_id 		= 	$data['auth_id'];
	$username 		= 	$data['username'];
	$password 		= 	$data['password'];
	$access_level 	= 	$data['access_level'];

	$query_string = "INSERT INTO cms_user(user_id, username, password, access_level,  validated) 
					VALUES('$auth_id', '$username', '$password', '$access_level', '0')";
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
		return true;
	return false;
}

function sendEmail($emailData){
	$message = $emailData['message'];
	$toEmail = $emailData['email'];

	$host = $this->config->item('host');
	$port = $this->config->item('port');
	$senderUsername = $this->config->item('sender_username');
	$senderPassword = $this->config->item('sender_password');
	$encryption = $this->config->item('encryption');

	$transport = Swift_SmtpTransport::newInstance($host , $port, $encryption)->setUsername($senderUsername )->setPassword($senderPassword);
	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance();
	$message->setSubject('CMS authorship, Validate Account Now');
	$message->setBody($message, 'text/html');
	$message->setTo(array($toEmail));
	$message->setFrom(array('ofelix03@gmail.com' => 'Felix Otoo'));
	$message->setReadReceiptTo('ofelix03@gmail.com');

	return $mailer->send($message);
}

function sendSMS($message){
    $api_key = $this->config->item('api_key');
    $phone = $this->config->item('phone');
    $sender_id = $this->config->item('sender_id');
    $message = $message;
    
    $url = "http://sms.nasaramobile.com/api?api_key=$api_key&&sender_id=$sender_id&&phone=$phone&&message=".urlencode($message)."";
    //send message and get response
   @$response = file_get_contents($url);
    if($response == '1801')
    	return true;
	return false;
}




function isValidated($user_id){
	$query_string = "SELECT user_id FROM cms_user WHERE user_id = '$user_id' AND validated = '1'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return true;
	return false;
}


function validate(){
	$query_string = "UPDATE cms_user SET validated = '1'";
	$this->db->query($query_string);
	if($this->db->affected_rows() == 1)
		return true;
	return false;
}

function get_accesslevel($user_id){
	$query_string = "SELECT access_level FROM cms_user WHERE user_id = '$user_id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		$result->result_array()[0]['access_level'];
	return false;

}

function isValid($user_id, $username){
	$query_string = "SELECT * FROM cms_user WHERE user_id = '$user_id' AND username = '$username'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return true;
	return false;
}

function getAuthorAccessLevel($user_id){
	$query_string = "SELECT access_level FROM cms_user WHERE user_id = '$user_id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0]['access_level'];
	return false;
}

function getAuthorField($user_id, $field = ''){
	$query_string = "SELECT {$field} FROM authors WHERE id = '$user_id'";
	$result = $this->db->query($query_string);
	if($result->num_rows() == 1)
		return $result->result_array()[0][$field];
	return false;

}

}