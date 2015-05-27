<?php

class Cms extends CI_Controller{
	private $data = array();
	private $order_by = '';
	private $order = '';
	private $tb_name = '';
	private $user_id;
	private $access_level;
	private $resouces = array();
	private $mysqli;

	public function __construct(){
		parent::__construct();
		$this->load->model('cms_m');
		$this->load->library('prep_html');
		$this->data['current'] = 'cms';
		$this->load->model('article');
		$this->load->model('paginate');
		$this->load->helper('custom_helper');
		$this->mysqli = mysqli_inst();
		require 'vendor/autoload.php';

	}


	public function index(){
		$this->view_all();

	}

	public function add_article(){
		$hrefs = array( 'asset/css/cms/add_article.css');
		$this->data['resources'] =   $this->prep_html->prep_resources($hrefs, 'css');

		$this->init();
		//add an article;
		if(!$this->input->post())
		{
			//login page has just been loaded for the first time
			$this->load->view('cms_templates/inc2/head', $this->data);
			$this->load->view('cms_templates/add_article', $this->data);
			return; 
		}

		$this->insert_article_db();

	}

	public function insert_article_db(){
		$this->init();
		$this->load->library('form_validation');

		//assign the values obtained through http post method
		if(isset($_POST))
		{
			$author = $this->input->post('author');
			$auth_id = $this->input->post('auth_id');
			$title = $this->input->post('title');
			$summary = $this->input->post('summary');
			$message = $this->input->post('message');
			$slug = $this->input->post('slug');
			$tags = $this->input->post('tags');
			$pub_status = $this->input->post('pub_status');
			$carousel_article_active = $this->input->post('carousel-article-active');
			if($pub_status == 'y')
				$pub_date = date('Y-m-d h:m:s', time());
			else
				$pub_date = $this->input->post('pub_date');
			$thumbnail_alt = $this->input->post('thumbnail_alt');

			if($carousel_article_active == 'y'){
				//author wants to use the carousel feature
				$carousel_article =  array(
					'carousel_active' 	=> $carousel_article_active,
					'description' 		=> $this->input->post('carousel-article-description'),
					'title' 		    => $title,
					'title_color' 		=> '#'.$this->input->post('carousel-article-title-color'),
					'description_color' => '#'.$this->input->post('carousel-article-description-color'),
					'link_color' 		=> '#'.$this->input->post('carousel-article-link-color'),
					'link'			    => site_url('articles').'/'.$slug,
					'action' 			=> 'insert'
					);

			}			




		}

		

		$post_data = array(
			'author' 		=> $author, 
			'auth_id' 		=> $auth_id, 
			'title' 		=> $title, 
			'message'		=> $message, 
			'summary' 		=>  ($this->input->post('summary'))? $this->input->post('summary') : substr($this->input->post('message'), 0, 450),
			'slug' 			=> $slug, 
			'tags' 			=> $tags, 
			'pub_status' 	=> $pub_status, 
			'pub_date' 		=> $pub_date, 
			'thumbnail_alt' => $thumbnail_alt
			);
	//prep received data to check if they meet requirement
		$this->form_validation->set_rules('title', 'Title', 'required|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|trim');
		$this->form_validation->set_rules('slug', 'Slug', 'required|trim');
		$this->form_validation->set_rules('tags', 'Tags', 'required|trim');

		if($this->form_validation->run() && !empty($pub_date))
		{
				//upload thumbnail to server
			if($thumbnail_data = $this->thumbnail_upload("thumbnail"))
			{

				$data = array($post_data, $thumbnail_data);
				
			//insert new article into databaes
				$article_id = $this->cms_m->insert_new_article($data);
				if($article_id )
					$this->data['add_success_status'] = "Successfully added a new article";
				else
					$this->data['add_fail_status'] = "Failed to add a new article. Try Again!";

				if(isset($this->data['add_success_status']) && $carousel_article_active == 'y'){
					//time to add carousel-article to database
					//add thumbnail name to carousel_article array
					$thumbnail_data = $this->thumbnail_upload('thumbnail', 'asset/img/carousel');
					$carousel_article['thumbnail'] = $thumbnail_data['file_name'];
					$carousel_article['article_id'] = $article_id;
					
					//call add_carousel_add_carousel_article_data method @para $carousel_article;
					$this->cms_m->add_carousel_article_data($carousel_article);

					
				}
			}
			else
			{
				$this->data['add_fail_status'] = $thumbnail_data;
			}
		}
		else
		{
			//create an empty array;
			$warning = array();
			//if validation failed, check for failed fields
			if(empty($title)){
				$warning['title'] = "title";
			}

			if(empty($message)){
				$warning['message'] = "message";
			}
			if(empty($slug)){
				$warning['slug'] = "slug";
			}

			if(empty($tags)){
				$warning['tags'] = "tags";
			}

			if(empty($pub_date)){
				$warning['pub_date'] = "pub_date";
			}

			//used to hightlight the empty fields
			$this->data['warning'] = $warning;

			//set an error message
			$this->data['add_fail_status'] = "All highlighted fields are required.";
		}

       // $this->data['pub_status'] = $post_data['pub_status'];
		$this->data['set_values'] = array(
			'pub_status' => $pub_status,
			'thumbnail' => isset($carousel_article['thumbnail'] )? $carousel_article['thumbnail']  : "",
			'thumbnail_alt' => $thumbnail_alt,
			'carousel_article' => isset($carousel_article)? $carousel_article : ''
			);

		//show add article page

		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/add_article', $this->data);
	}


	public function edit_article($article_id = ''){
		$this->init();

		$this->data['article_id'] = $article_id;
		if(!$this->input->post())
		{
			//form open to edit an article
			if(!empty($article_id))
			{
				//fetch details of article with id = $article_id to edit
				$this->data['article_details'] = $this->cms_m->get_article($article_id);
				$carousel = $this->cms_m->getCarouselData($article_id);
				
				$this->data['set_values'] = array(
					'carousel_article' => array(
						'carousel_active' => 'n',
						'description'    => $carousel['brief'],
						'description_color' => $carousel['brief_color'],
						'title_color' => $carousel['caption_color'],
						'link_color' => $carousel['link_color']
						)
					);

				if($this->cms_m->getCarouselImg($article_id))
				{
					$this->data['set_values']['carousel_article']['active'] = 'y';
				}
			}
			else
			{
				$this->data['article_details'] = false;
			}
		}
		else
		{
			//post data from form received, do update of article

			$pub_status = $this->input->post('pub_status');
			if($pub_status == "pub")
			{
				$pub_status = "1";
				$pub_date = date('Y-m-d h:m:s', time());

			}
			else
			{
				$pub_status = "0";
				$pub_date = $this->input->post('pub_date');

			}

			$post_data = array(
				"id"             =>  $this->input->post('article_id'),
				"title"          =>  $this->mysqli->real_escape_string($this->input->post('title')),
				"summary" 		 =>  ($this->input->post('summary'))? $this->input->post('summary') : substr($this->input->post('message'), 0, 450),
				"message"		 =>  $this->input->post('message'),
				"slug" 			 =>  $this->input->post('slug'),
				"tags"           =>  $this->input->post('tags'),
				"pub_date"       =>  $pub_date,
				"pub_status"     =>  $pub_status,
				"last_modified"  =>  date('Y-m-d', time()),
				"thumbnail_alt"  =>  $this->input->post('thumbnail_alt'),
				"auth_id"        =>  $this->input->post('auth_id')
				);

			$carousel_article_active = $this->input->post('carousel-article-active');
			if($carousel_article_active == 'y'){
				//author wants to use the carousel feature
				$carousel_article =  array(
					'carousel_active'	 => $carousel_article_active,
					'description'		 => $this->input->post('carousel-article-description'),
					'title'				 =>	$post_data['title'],
					'title_color'		 => '#'.$this->input->post('carousel-article-title-color'),
					'description_color'  => '#'.$this->input->post('carousel-article-description-color'),
					'link_color'		 => '#'.$this->input->post('carousel-article-link-color'),
					'link' 				 => site_url('article').'/'.$post_data['slug'],
					'article_id'         => $post_data['id']

					);
			}		

			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('message', 'Message', 'required|trim');
			$this->form_validation->set_rules('slug', 'Slug', 'required|trim');
			$this->form_validation->set_rules('tags', 'Tags', 'required|trim');

			if(!$this->form_validation->run() || empty($pub_date) )
			{

				//check for empty field
				$warning  = array();
				if(empty($post_data['title']))
					$warning['title'] = 'title';
				if(empty($post_data['message']))
					$warning['message'] = 'message';
				if(empty($post_data['slug']))
					$warning['slug'] = 'slug';
				if(empty($post_data['tags']))
					$warning['tags'] = 'tags';
				if(empty($pub_date))
					$warning['pub_date'] = "pub_date";

				$this->data['warning'] = $warning;
				$this->data['edit_fail_status'] = "All hightlighted fields required";

			   //TODO i would redirect using php headder()

			   //refill form with the data sent in by user
				$this->data['article_details'] = $post_data;
				$this->data['set_values'] = array(
					'carousel_article' => $this->cms_m->getCarouselData($carousel_article['id'])
					);
			}
			else
			{
				//validation passed, continue with update
				$upload_success = false;
				if(isset($_FILES['thumbnail']) && !empty($_FILES['thumbnail']['name']))
				{
					//upload thumbnail to server update article
					if($thumbnail_data = $this->thumbnail_upload("thumbnail"))
						$upload_success = true;
					else
						$this->data['edit_fail_status'] = $thumbnail_data['error'];
				}
				if($upload_success)
				{
                	//image was successfully uploaded to server, prepare data for  both article and thumbnail
					$data = array($post_data, $thumbnail_data);
				}
				else
				{
                	//no imge uploaded, prepare data for just article
					$data = $post_data;
				}
				if(!$this->cms_m->update_article($data)){
					//failed, likely no changes made to current article state.
					$thumbnail_errors = isset($thumbnail_data['error'])? $thumbnail['error'] : "";
					$this->data['edit_fail_status'] = "Failed to update article. ".$thumbnail_errors;
				}
				else
				{
					$this->data['edit_success_status'] = "Successfully edited article";

				}

				if($carousel_article_active== "y"){
					if($thumbnail = $this->cms_m->getCarouselImg($carousel_article['article_id']))
					{
						echo "already existes";
						//already exist in carousel an img for this article
						$carousel_article['action'] = 'update';
						$thumbnail = $thumbnail[0]['carousel_name'];
					}
					else
					{
						echo "doesnt esxist";
						//no existing carousel img for this article. so we use article img 
						$thumbnail = $this->cms_m->getImg($post_data['id']);
						$carousel_article['action'] = 'insert';
					}

					if(isset($thumbnail) && !empty($thumbnail))
					{
						//if an img exist with $article_id, update data
						$carousel_article['active'] = 'y';
						$carousel_article['thumbnail'] = $thumbnail;
						$this->cms_m->add_carousel_article_data($carousel_article);
						$this->data['edit_success_status'] = "Successfully edited article";

					}
					else{
						$this->data['edit_fail_status'] = "No thumbnail selected for carousel feature.";
					}
					
					//refill form with carousel data
					$this->data['set_values'] = array('carousel_article' => $carousel_article);
				}
				$this->data['article_details'] = $this->cms_m->get_article($post_data['id']); 
			}
		}
		$this->data['resources'] =   $this->prep_html->prep_resources('asset/css/cms/edit_article.css', 'css');
		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/edit_article', $this->data);
	}

	public function view_all($user_id = ''){

		$this->init($user_id);
		$this->init_order_sort();  //set and retun the opposite of the order brought in from the client end
		if(isset($user_id) && is_numeric($user_id))
		{
			//getting data attributed to an unlogged in author
			$this->user_id = $user_id;
			//create a query to get the count for creating the pagination
			$query_string = "SELECT count(*) as count from cms_article,  article, authors where article.id = article_id and article.auth_id = authors.id and del_status = '0'  and article.auth_id = ".$this->user_id;
		}
		else
		{
			//user is a logged in author
			$this->user_id = $_SESSION['user_id']; 
		   //create a query to get the count for creating the pagination
			$query_string = "SELECT COUNT(*) as count
			FROM article, authors, cms_article  
			WHERE article.auth_id = {$this->user_id} AND article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.del_status = '0' ";
		}

		 //set the config fo the pagination
		$page_id = $this->input->get('page');
		$config['rows_per_page'] = 10;
		$config['total_rows']  = $this->paginate->getRows($query_string, "count");
		$config['total_rows'];
		$config['target_url']  = site_url('cms/view_all?page=');
		$config['page_id'] = $page_id;
		$this->paginate->initialize($config);
		$offset = $this->paginate->get_offset();
		$limit = $this->paginate->get_limit();
		$this->data['pagination'] = $this->paginate->create_pagination2(); 	
		 $this->data['cur_page_id'] = $page_id;  //page_id for the page , used in the sort ordering

		//retrieve data from db according to the order requested by user
		 $result = $this->cms_m->getArticles($this->user_id, $this->order_by, $this->order, $offset, $limit);
		 $this->data['results'] = $result;
		 $hrefs = array( 'asset/css/pagination.css');
		 $this->data['resources'] =   $this->prep_html->prep_resources($hrefs, 'css');
		 $this->load->view('cms_templates/inc2/head', $this->data);
		 $this->load->view('cms_templates/index', $this->data);
		}


		public function view_only_published(){
			$this->init();
	$this->init_order_sort();     //set and retun the opposite of the order brought in from the client end
	
	 //get the num_row for the articles for view_only_published
	// $query_string = "SELECT  count(*) as count  from cms_article,  article, authors where article.id = article_id  and del_status = '0' and pub_status = '1' and article.auth_id = authors.id  and article.auth_id = '$this->user_id' and pub_status = '1'";
	$query_string = "SELECT COUNT(*) as count
	FROM article, authors, cms_article  
	WHERE article.auth_id = {$this->user_id} AND article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.del_status = '0' AND cms_article.pub_status = '1'";
	
	 //set the config fo the pagination
	$page_id = $this->input->get('page');
	$config['rows_per_page'] = 10;
	$config['total_rows']  = $this->paginate->getRows($query_string, "count");
	$config['target_url']  = site_url('cms/view_only_published?page=');
	$config['page_id'] = empty($page_id)? 1 : $page_id;
	$this->paginate->initialize($config);
	$offset = $this->paginate->get_offset();
	$limit = $this->paginate->get_limit();
	$this->data['pagination'] = $this->paginate->create_pagination2();
	 $this->data['cur_page_id'] = empty( $page_id) ;  //page_id for the page , used in the sort ordering


	//retrieve data from the database according to the specified order of the user
	 $result = $this->cms_m->get_published($this->user_id, $this->access_level, $this->order_by, $this->order, $offset, $limit);
	 $this->data['results'] = $result;

	 $hrefs = array( 'asset/css/pagination.css' );
	 $this->data['resources'] =   $this->prep_html->prep_resources($hrefs, 'css');
	 $this->load->view('cms_templates/inc2/head', $this->data);
	 $this->load->view('cms_templates/index', $this->data);
	}

	public function view_only_unpublished(){
		$this->init();
		$this->init_order_sort();  //set and retun the opposite of the order brought in from the client end

		 //get the num_row for the articles for view_only_published
		$query_string = "SELECT COUNT(*) as count
		FROM article, authors, cms_article  
		WHERE article.auth_id = {$this->user_id} AND article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.del_status = '0' AND cms_article.pub_status = '0'";
		
		 //set the config fo the pagination
		$page_id = $this->input->get('page');
		$config['rows_per_page'] = 15;
		$config['total_rows']  = $this->paginate->getRows($query_string, "count");
		$config['target_url']  = site_url('cms/view_only_unpublished?page=');
		$config['page_id'] = empty($page_id)? 1 : $page_id;
		$this->paginate->initialize($config);
		$offset = $this->paginate->get_offset();
		$limit = $this->paginate->get_limit();
		$this->data['pagination'] = $this->paginate->create_pagination2();
		 $this->data['cur_page_id'] = $page_id;  //page_id for the page , used in the sort ordering

		//retrieve data from the database according to the specified order of the user
		 $result = $this->cms_m->get_unpublished($this->user_id, $this->access_level,  $this->order_by, $this->order, $offset, $limit);
		 $this->data['results'] = $result;
		 $hrefs = array( 'asset/css/pagination.css');
		 $this->data['resources'] =   $this->prep_html->prep_resources($hrefs, 'css');
		 
		 $this->load->view('cms_templates/inc2/head', $this->data);
		 $this->load->view('cms_templates/index', $this->data);

		}


		public function view_trashed(){
			$this->init();
			if($this->input->get('order') != '' && $this->input->get('order_by') != '' && $this->input->get('tb_name') != '')
			{
				$this->order_by = $this->input->get('order_by');
				$this->order = $this->input->get('order');
				$this->tb_name = $this->input->get('tb_name');
			}


		//returning the order and the tb_name
			if($this->order == 'desc')
				$this->data['order'] = 'asc';
			else if($this->order == 'asc')
				$this->data['order'] = 'desc';

			$this->data['tb_name'] = $this->tb_name;
			$this->data['order_by'] = $this->order_by;


			$query_string = "SELECT COUNT(*) as count
			FROM article, authors, cms_article  
			WHERE article.auth_id = {$this->user_id} AND article.auth_id = authors.id AND article.id = cms_article.article_id AND cms_article.del_status = '0' AND cms_article.pub_status = '0'";
			
		 //set the config fo the pagination
			$page_id = $this->input->get('page');
			$config['rows_per_page'] = 10;
			$config['total_rows']  = $this->paginate->getRows($query_string, "count");
			$config['target_url']  = site_url('cms/view_only_published?page=');
			$config['page_id'] = empty($page_id)? 1 : $page_id;
			$this->paginate->initialize($config);
			$offset = $this->paginate->get_offset();
			$limit = $this->paginate->get_limit();
			$this->data['pagination'] = $this->paginate->create_pagination2();
		 $this->data['cur_page_id'] = empty( $page_id) ;  //page_id for the page , used in the sort ordering


		//retrieve data from the database according to the specified order of the user
		 $result = $this->cms_m->get_trashed($this->user_id, $this->access_level,  $this->order_by, $this->order, $offset, $limit);
		 $this->data['results'] = $result;
		 $this->load->view('cms_templates/trashed', $this->data);

		}


		function search(){
			$this->init();
			$search_option = $this->input->get('search_option');
			$search_value =  !empty( $this->input->get("search_value"))?  $this->input->get("search_value") : "--";

			$search_option = strtolower($search_option);
			$search_value =  !empty($search_value) ? strtolower($search_value) : "";

			switch ($search_option) {
				case 'author name':
				$this->data['results'] = $this->cms_m->search($search_option, $search_value, $_SESSION['access_level']);
				break;
				case 'article title':
				$this->data['results'] = $this->cms_m->search($search_option, $search_value, $_SESSION['access_level']);
				break;
				case 'article published date':
				$this->data['results'] = $this->cms_m->search($search_option, $search_value, $_SESSION['access_level']);
				break;
				default: 
				$this->data['results'] = $this->cms_m->search("", "", $_SESSION['access_level']);
				break;
			}

			$this->init_order_sort();
			$this->load->view('cms_templates/inc2/head', $this->data);
			$this->load->view('cms_templates/index', $this->data);



		}


		public function init_order_sort(){
			$order = $this->input->get('order');
			$order_by = $this->input->get('order_by');
			$tb_name = $this->input->get('tb_name');

			if($order != '' && $order_by != '' &&  $tb_name  != '')
			{
				$this->order_by = $this->input->get('order_by');
				$this->order = $this->input->get('order');
				$this->tb_name = $this->input->get('tb_name');
			}

			//returning the order and the tb_name
			if($this->order == 'desc')
				$this->data['order'] = 'asc';
			else if($this->order == 'asc')
				$this->data['order'] = 'desc';

			$this->data['tb_name'] = $this->tb_name;
			$this->data['order_by'] = $this->order_by;

		}


		public function delete(){
			$this->init();
			$ids = $this->input->post('ids');
			$result = $this->cms_m->delete($ids);

			if($result['failed_ids'] === FALSE)
			{
			//delete was successful
				echo json_encode(array('status' => 'success', 'ids' => $ids, 'action' => 'delete' ));
			}
			else
				echo json_encode(array('status' => 'fail', 'ids' => $ids, 'failed_ids' => $result , 'action' => 'delete' ));
		}

		public function permanent_delete(){
			$this->init();
			$ids = $this->input->post('ids');

		$this->cms_m->delArticleImgs($ids); //delete article thumbnail on server
		$this->cms_m->delCarousel($ids, $this->cms_m->getCarouselImg($ids)); //delete article carousel imgs if any
		$result = $this->cms_m->permanent_delete($ids);
		if($result === true)
		{
			echo json_encode(array('status' => 'success', 'ids' => $ids, 'action' => 'delete' ));
		}
		else
			echo json_encode(array('status' => 'fail', 'ids' => $ids, 'failed_ids' => $result , 'action' => 'delete' ));
	}

	public function undelete(){
		$this->init();
		$ids = $this->input->post('ids');
		$result = $this->cms_m->undelete($ids);

		if($result === "true")
		{
			//delete was successful
			echo json_encode(array('status' => 'success', 'ids' => $ids, 'action' => 'undelete' ));
		}
		else
			echo json_encode(array('status' => 'fail', 'ids' => $ids, 'failed_ids' => $result , 'action' => 'undelete' ));
	}



	public function publish(){
		//This relies on an ajax post call from the client
		$this->init();
		$ids = $this->input->post('ids');
		$ids_count = count($ids);


		$result = $this->cms_m->publish($ids);
		if($result === TRUE)
		{
			echo json_encode(array('status' => 'success', 'ids' => $ids , 'action' => 'publish',  "ids_count" => $ids_count));
		}
		else
		{
			$failed_ids = $result['failed_ids'];
			$success_ids = array();
			$count = 0;
			foreach($ids as $id){
				if(!in_array($id, $failed_ids))
				{
					$success_ids[$count] = $id;
					$count++;
				}
				
			}
			//remove redudnat ids;
			$success_ids = array_unique($success_ids);

			echo json_encode(array('status' => 'fail', 'ids' => $success_ids , 'action' => 'publish', 'failed_ids' => $failed_ids, 'ids_count' => $ids_count));

		}

	}


	public function unpublish(){
	//This is dependent on an ajax post call from the client
		$this->init();
		$ids = $this->input->post('ids');
		$ids_count = count($ids);
		$result = $this->cms_m->unpublish($ids);
		if($result === TRUE)
			echo json_encode(array('status' => 'success', 'ids' => $ids , 'action' =>'unpublish',  "ids_count" => $ids_count));
		else
		{    
			$failed_ids = $result['failed_ids'];
			$success_ids = array();
			$count = 0;
			foreach($ids as $id){
				if(!in_array($id, $failed_ids))
				{
					$success_ids[$count] = $id;
					$count++;
				}
				
			}
			//remove redudnat ids;
			$success_ids = array_unique($success_ids);
			echo json_encode(array('status' => 'fail', 'ids' => $success_ids , 'action' => 'unpublish', 'failed_ids' => $failed_ids, 'ids_count' => $ids_count));

		}

	}


	
	public function thumbnail_upload($thumbnail, $rel_address = 'asset/img/article_thumbnails'){
		//check if an image has been uploaded  and process it
		$config['upload_path'] = $rel_address;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['overwrite'] = true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);


		if ( !$this->upload->do_upload($thumbnail))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data['upload_data'];
		}

	}


	public function create_slug(){
		//use on the client side to create a slug of an article title on the fly
		$this->init();
		echo strtolower( url_title($this->input->get('text')));
	}

	public function login(){
		$this->load->helper('form');
		if(!$this->input->post())
		{
			//login page has been loaded for the first time
			$this->load->view('cms_templates/login');
			return; 
		}

	   //At this point the load form has been submitted or an ajax call has been trigger on the input fields
	   //receive post data from ajax post call
		$request_type = $this->input->post('request_type');
		if($request_type)
		{
		//request came from an ajax post type call
		//store post array element values
			$field = $this->input->post('field');
			$field_val = $this->input->post('field_val');
			$data = array('field' => $field, 'field_val' => $field_val);

		//validate the data received against the cms_user table
			if($this->cms_m->validate_login_details($data)){
				echo json_encode(array('status' => true));
			}
			else
				echo json_encode(array('status' => false));

	   return; //end the execution of the script here
	}
	else
	{
		//fallback for user_credential validation when javascript is turned off
		//or when the submit button has been clicked
		$username = $this->input->post('username');
		$password = $this->input->post('password');
	//load the form_validation class
		$this->load->library('form_validation');


		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if($this->form_validation->run())
		{
			$data = array('username' => $username, 'password' => $password);
			//crosscheck data with cms_user table data
			if($data = $this->cms_m->validate_login_details($data)){
				//validity of data guranteed, continue 
				//start session
				session_start();
				session_regenerate_id();
				//store some details of current user
				$_SESSION['username'] = $data['username'];
				$_SESSION['access_level'] = $data['access_level'];
				$_SESSION['user_id'] = $data['user_id'];
				$_SESSION['fullname'] = $data['fullname'];
				$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

				//redirect to dashboard 
				$redirect_url = "Location:".  site_url('cms/view_all');
				header($redirect_url);


			}
			else
			{
				//validity of data not quaranteed, set error messages and  get back to login page
				$this->data['login_fail_status'] = "";

				//now validate the two fields(username and password) oen by one
				$username_data = array('field' => 'username' , 'field_val' => $username);
				$password_data = array('field' => 'password' , 'field_val' => $password);

				$warning = array();
				if(!$this->cms_m->validate_login_details($username_data))
				{
					$warning['username'] = "username";
					$this->data['login_fail_status'] .= "Username & ";
				}


				$warning['password'] = 'password';

				$this->data['login_fail_status'] .= "Password Incorrect. Try Again!";

				$this->data['warning'] = $warning;
			}


		}
		else
		{
			//form_validaton->run() failed, we get back to form for re-sbumit of data
			$this->data['login_fail_status'] = "All fields are required";

			$warning = array();
			if(empty($username)){
				$warning['username'] = 'username';
			}
			else
			{
				//username not empty but its data could be invalid.
				//validate username against database user list
				$data = array('field' => 'username', 'field_val' => $username);

				if(!$this->cms_m->validate_login_details($data))
				{
					//username cross checked against cms_user == invalid
					$this->data['login_fail_status'] .= ", Username is invalid";
					$warning['username'] = "username";
				}
			}

			if(empty($password))
			{
				$warning['password'] = 'password';
			}

			$this->data['warning'] = $warning;
		}

			//reload the login page

		$this->load->view('cms_templates/login', $this->data);

	}



}

public function init($user_id = ''){
	$this->load->helper('session_helper');
	if(session_isset()){
		$this->user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

	  //retrieve from the database according to the level of the user, admin/publisher
		$this->data['pub_num_rows'] = $this->cms_m->published_num_rows($this->user_id );
		$this->data['unpub_num_rows']  = $this->cms_m->unpublished_num_rows($this->user_id );
		$this->data['view_all_num_rows'] = $this->cms_m->view_all_num_rows($this->user_id );
		$this->data['trashed_num_rows'] = $this->cms_m->trashed_num_rows($this->user_id );
	}
}

public function init_wihout_session($user_id, $access_level){
	$this->user_id = $user_id;
	$this->access_level = $access_level;

	  //retrieve from the database according to the level of the user, admin/publisher
	$this->data['pub_num_rows'] = $this->cms_m->published_num_rows($this->user_id );
	$this->data['unpub_num_rows']  = $this->cms_m->unpublished_num_rows($this->user_id );
	$this->data['view_all_num_rows'] = $this->cms_m->view_all_num_rows($this->user_id );
	$this->data['trashed_num_rows'] = $this->cms_m->trashed_num_rows($this->user_id );

}


public function logout(){
	//destroy sessions and logout
	$this->init();
	session_destroy();
	$this->load->view("cms_templates/login", $this->data);
}


public function authors($view = ''){
	$this->data['current'] = 'authors';
	$this->init();

	if($this->input->get('order') != '' && $this->input->get('order_by') != '' && $this->input->get('tb_name') != '')
	{
		$this->order_by = $this->input->get('order_by');
		$this->order = $this->input->get('order');
		$this->tb_name = $this->input->get('tb_name');
	}

	//returning the order and the tb_name
	if($this->order == 'desc')
		$this->data['order'] = 'asc';
	else if($this->order == 'asc')
		$this->data['order'] = 'desc';

	$this->data['tb_name'] = $this->tb_name;
	$this->data['order_by'] = $this->order_by;

	if(isset($view) && $view == 'grid')
	{
		$this->data['results'] =  $this->cms_m->get_authors_grid();
		$this->data['resources'] = $this->prep_html->prep_resources('asset/css/cms/authors_grid_view.css', 'css');
		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/authors_grid_view', $this->data);
	}
	else
	{
		$results =  $this->cms_m->get_authors($this->order_by, $this->order);
		$this->data['resources'] = $this->prep_html->prep_resources('asset/css/cms/authors_list_view.css', 'css');
		$new_results = array();
		foreach($results as $index => $result){
			$result['article_total'] = $this->cms_m->get_article_num($result['user_id']);
			$new_results[$index] = $result;
		}
		$this->data['results'] = $new_results;

		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/authors_list_view', $this->data);

	}


}



public function  author_delete(){
	$ids = $this->input->post('ids');
	$deletion_state = $this->cms_m->author_delete($ids);
	if( $deletion_state == "TRUE"){
		//deletion successful.
		echo json_encode(array('action' => "delete", 'status' => 'success', 'ids' => $ids));
	}
	else {
		//deletion faileed
		$failed_ids = $deletion_state;
		echo json_encode(array('action' => 'delete', 'status' => 'fail', 'ids' => $ids,  'failed_ids' => $failed_ids));
	}
}


public function get_profile(){
	$profile_id  =  $this->input->post('id');
	$profile_id = isset($profile_id)?   $profile_id : -1;
	$profile =  $this->data['author_profile'] = $this->cms_m->get_author_profile($profile_id);
	if($profile)
		echo json_encode(array('status'=> "success", 'profile' => $profile));
	else
		echo json_encode(array('status' => "fail"));

}


public  function author_edit($id = ''){
	$this->data['current'] = 'authors';

	$this->init();
	$this->data['resources'] =   $this->prep_html->prep_resources('asset/css/cms/edit_article.css', 'css');

	$author_id = $id;
	$this->data['author_id'] = $author_id;
	if(!$this->input->post())
	{
		if(!empty($author_id))
		{
				//fetch details of article with id = $article_id to edit
			$this->data['author_details'] = $this->cms_m->get_author_profile($author_id);
		}
		else
		{
			$this->data['author_details'] = false;
		}
	}
	else
	{
			//post data from form receive, do update of author
		$password_tampered = $this->input->post('password_tampered');
		$post_data = array(
			"username" =>$this->input->post('username'),
			"password" => $this->input->post('password'),
			"password_confirm" => $this->input->post('password_confirm'),
			"name" => $this->input->post('name'),
			"sex" => $this->input->post('sex'),
			"age" => $this->input->post('age'),
			"profession" => $this->input->post('profession'),
			"in_brief" => $this->input->post('in_brief'),
			"social_networks" =>$this->input->post('social_networks'),
			"auth_thumb" => $this->input->post('thumbnail_alt'),
			"websites" => $this->input->post('websites'),
			"user_id" => $this->input->post('user_id')
			);

		$author_id = $post_data['user_id'];


		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'username', 'required|trim');
		$this->form_validation->set_rules('password', 'password', 'required|trim');
		$this->form_validation->set_rules('password_confirm', 'password_confirm', 'required|trim|matches[password]');
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('sex', 'Sex', 'required|trim');
		$this->form_validation->set_rules('age', 'age', 'required|trim');
		$this->form_validation->set_rules('profession', 'Profession', 'required|trim');
		$this->form_validation->set_rules('in_brief', 'in_brief', 'required|trim');
		
		if(!$this->form_validation->run() )
		{
				//check for empty field
			$warning  = array();
			if(empty($post_data['username']))
				$warning['username'] = 'username';
			if($password_tampered == 1 && (empty($post_data['password']) || empty($post_data['password_confirm'])) || $post_data['password'] != $post_data['password_confirm'])
			{
				$warning['password'] = 'password';
				$warning['password_confirm']= "password_confirm";
			}
			if(empty($post_data['name']))
				$warning['name'] = 'name';
			if(empty($post_data['sex']))
				$warning['sex'] = 'sex';
			if(empty($post_data['age']))
				$warning['age'] = 'age';
			if(empty($post_data['profession']))
				$warning['profession'] = 'profession';
			if(empty($post_data['in_brief']))
				$warning['in_brief'] = 'in_brief';


			

			$this->data['warning'] = $warning;
			$this->data['edit_fail_status'] = "All hightlighted fields required / data input is invalid";


			//refill form with the data sent in by user
			$post_data['auth_thumb'] = $this->cms_m->get_auth_thumb($post_data['user_id']);
			$this->data['author_details'] = $post_data;


		}
		else
		{
				//field requirement met, contnue with update
			if(isset($_FILES['thumbnail']) && !empty($_FILES['thumbnail']['name']))
			{
					//upload thumbnail to server
				if($thumbnail_data = $this->thumbnail_upload("thumbnail", "asset/img/authors_thumbs"))
				{
					$data = array($post_data, $thumbnail_data);
					$this->data['edit_fail_status'] = "";
						//insert new article into databaes
					if($this->cms_m->update_author($data))
						$this->data['edit_success_status'] = "Successfully edited author profile";
					else
						$this->data['edit_fail_status'] = "Failed to edit author profile. Try Again! [Hint : No changes made].";

					if($thumbnail_data['error'])
						$this->data['edit_fail_status'] .= $thumbnail_data['error'];


				}
				
			}
			else
			{
					//insert new article into databaes
				if($this->cms_m->update_author($post_data))
					$this->data['edit_success_status'] = "Successfully edited author profile";
				else
					$this->data['edit_fail_status'] = "Failed to edit author profile. Try Again! [Hint : No changes made].";
			}
			$this->data['author_details'] = $this->cms_m->get_author_profile($author_id);
			// $this->data['author_details'] = $this->cms_m->get_author_profile($author_id);
		}
	}


	$this->load->view('cms_templates/inc2/head', $this->data);
	$this->load->view('cms_templates/edit_author', $this->data);
}



function add_author(){
	$this->data['current'] = 'authors';
	$hrefs = array( 'asset/css/cms/add_article.css');
	$this->data['resources'] =   $this->prep_html->prep_resources($hrefs, 'css');

	$this->init();
	//add an article;
	if(!$this->input->post())
	{
		//login page has just been loaded for the first time
		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/add_author', $this->data);
		return; 
	}

	$this->insert_author_db();
}



public function insert_author_db(){
	$this->init();
	$this->load->library('form_validation');

	//assign the values obtained through http post method
	if(isset($_POST))
	{
		$current_user_level  = $this->input->post('current_user_level');
		if($current_user_level == '0')
		{
			$access_level = ($this->input->post('access_level') == 'admin')? '0' : '1';
			
			$post_data = array(
				"username" => $this->input->post('username', TRUE),
				"email" => $this->input->post('email', TRUE),
				"access_level" => $access_level,
				"password" => md5( '123')
				);

			//prep received data to check if they meet requirement
			$this->load->library('form_validation');
			if($current_user_level == 0){
				$this->form_validation->set_rules('username', 'username', 'required|trim');
				$this->form_validation->set_rules('email', 'email', 'required|trim|email');
				$this->form_validation->set_rules('access_level', 'access_level', 'required|trim');
			}

			if($this->form_validation->run()){ //validation pass
				//insert new author into db
				if($auth_id  = $this->cms_m->addAuthor())
				{
					//save to continue
					$post_data['auth_id'] = $auth_id;
					if($this->cms_m->addAuthorLoginCredentials($post_data))
					{
					    //send randomly generated password to new authors email account.
						$email_message = "Follow this <a href='".site_url('account_validation')."/".$auth_id."/".$post_data['username']."'>link</a> to validate your authorship account. ";
						$sendToEmailData = array('message' => $email_message, 'email' => $post_data['email']);
					  //   if($status = $this->cms_m->sendEmail($sendToEmailData))
					  //   {
					  //   	echo $status;
							// $this->data['add_success_status']  = "We have sent you a temporary password to your email account. Use that to access and edit your account details.";
					  //   }
					  //   else
					  //   {
					  //   	echo $status;
							// $this->data['add_success_status']  = "We tried sending you a temporary password to your email account but it failed. We will keep trying to send it. Keep checking your mail .. [Use that to access and edit your account details]";
					  //   }
						$message = "Please visit your mail ".$post_data['email'].' to access your new authorship account on OFEX.COM';
						if($this->cms_m->sendSMS($message))
						{
							$this->data['add_success_status']  = "We have sent you a temporary password to your email account. Use that to access and edit your account details.";
						}
						else
						{
							$this->data['add_success_status']  = "We tried sending you a temporary password to your email account but it failed. We will keep trying to send it. Keep checking your mail .. [Use that to access and edit your account details]";
						}
					}
					else
						$this->data['add_fail_status'] = "Ooops! sorry something went wrong whiles trying to add you as an author. Try Again.";
				}
			}
			else
			{
				//create an empty array;
				$warning = array();
				//if validation failed, check for failed fields
				if(empty($post_data['username'])){
					$warning['username'] = "username";
				}

				if(empty($post_data['email'])){
					$warning['email'] = "email";
				}

				if(empty($post_data['access_level'])){
					$warning['access_level'] = "access_level";
				}
				//used to hightlight the empty fields
				$this->data['warning'] = $warning;
				$this->data['add_fail_status'] = "All highlighted fields are required.";




			}

		}
		// else
		// {
		// 	$post_data = array(
		// 		"username" =>$this->input->post('username'),
		// 		"password" =>$this->input->post('password'),
		// 		"password_confirm" => $this->input->post('password_confirm'),
		// 		"access_level"  => $this->input->post('access_level'),
		// 		"name" => $this->input->post('name'),
		// 		"sex" => $this->input->post('sex'),
		// 		"age" => $this->input->post('age'),
		// 		"profession" => $this->input->post('profession'),
		// 		"in_brief" => $this->input->post('in_brief'),
		// 		"social_networks" =>$this->input->post('social_networks'),
		// 		"auth_thumb" => $this->input->post('thumbnail_alt'),
		// 		"websites" => $this->input->post('websites'),
		// 		"user_id" => $this->input->post('user_id')
		// 		);
		// }

	}



	// //prep received data to check if they meet requirement

	// $this->load->library('form_validation');
	// if($current_user_level == 0){
	// 	$this->form_validation->set_rules('username', 'username', 'required|trim');
	// 	$this->form_validation->set_rules('email', 'email', 'required|trim|email');

	// 	$this->form_validation->set_rules('access_level', 'access_level', 'required|trim');
	// }
	// else{
	// 	$this->form_validation->set_rules('username', 'username', 'required|trim');
	// 	$this->form_validation->set_rules('password', 'password', 'required|trim');
	// 	$this->form_validation->set_rules('password_confirm', 'password_confirm', 'required|trim|matches[password]');
	// 	$this->form_validation->set_rules('name', 'Name', 'required|trim');
	// 	$this->form_validation->set_rules('sex', 'Sex', 'required|trim');
	// 	$this->form_validation->set_rules('age', 'age', 'required|trim');
	// 	$this->form_validation->set_rules('profession', 'Profession', 'required|trim');
	// 	$this->form_validation->set_rules('in_brief', 'in_brief', 'required|trim');

	// }
	// if($this->form_validation->run() )
	// {
	// 	if($current_user_level == 0)
	// 	{
	// 	//generate password
	// 		$post_data['password'] = "123";
	// 	}
  //upload thumbnail to server
	// 	if($thumbnail_data = $this->thumbnail_upload("thumbnail"))
	// 	{
	// 		$data = array($post_data, $thumbnail_data);

	// 		//insert new article into databaes
	// 		if($this->cms_m->insert_new_author($data))
	// 			$this->data['add_success_status'] = "Successfully added a new author";
	// 		else
	// 			$this->data['add_fail_status'] = "Failed to add a new author. Try Again!";
	// 	}
	// 	else
	// 	{
	// 		$this->data['add_fail_status'] = $thumbnail_data;
	// 	}
	// }
	// else
	// {
	// 	//create an empty array;
	// 	$warning = array();
	// 		//if validation failed, check for failed fields
	// 	if(empty($post_data['username'])){
	// 		$warning['username'] = "username";
	// 	}

	// 	if(empty($post_data['name'])){
	// 		$warning['name'] = "name";
	// 	}

	// 	if(empty($post_data['age'])){
	// 		$warning['age'] = "age";
	// 	}
	// 	if(empty($post_data['sex'])){
	// 		$warning['sex'] = "sex";
	// 	}

	// 	if(empty($post_data['in_brief'])){
	// 		$warning['in_brief'] = "in_brief";
	// 	}

	// 	if(empty($post_data['profession'])){
	// 		$warning['profession'] = "profession";
	// 	}

	// 	if(empty($post_data['password']) || empty($post_data['password_confirm'])){
	// 		$warning['password'] = "password";
	// 		$warning['password_confirm'] = "password_confirm";

	// 	}

	// 	if(empty($post_data['access_level'])){
	// 		$warning['access_level'] = "access_level";
	// 	}


		// 	//used to hightlight the empty fields
		// $this->data['warning'] = $warning;

			//set an error message
		// $this->data['add_fail_status'] = "All highlighted fields are required.";
	// }

		//show add article page

	$this->load->view('cms_templates/inc2/head', $this->data);
	$this->load->view('cms_templates/add_author', $this->data);
}

function account_validation($user_id = '', $username = ''){
	$valid = false;
	if($this->cms_m->isValid($user_id, $username))
	{
		$valid = true;		
	}

	if($valid){		
		$access_level = $this->cms_m->get_accesslevel($user_id);
		//validation link is valid.
		if(!$this->cms_m->isValidated($user_id))
		{
			$response = $this->cms_m->validate($user_id);
			if($response)
			{
				$this->data['feedback'] = "Thank you for validating you authorship account. You can go ahead and edit your account information";
			}
		}
		else
		{
			$this->data['feedback'] = 'You already hold a validated authorship account. No need to be validated again.';
		}
		
		$this->init_wihout_session($user_id, $access_level);
		//start session
		session_start();
		session_regenerate_id();
		//store some details of current user
		$_SESSION['username'] = $username;
		$_SESSION['access_level'] = $access_level;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

		$this->load->view('cms_templates/inc2/head', $this->data);
		$this->load->view('cms_templates/index', $this->data);
	}
	else
	{
		$this->load->view('cms_templates/login', $this->data);
	}

}

function getlist($user_id = 0, $access_level = 100){
	// $this->init();
	// $this->data['results'] = $this->cms_m->getArticles($user_id, $access_level);
	$this->view_all();

}
}