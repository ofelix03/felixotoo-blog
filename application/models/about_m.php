<?php 

class About_m extends CI_Model{
	// public $data = array();
	private $table = 'contribution_box';
	// public function __construct(){
	// 	parent::__construct();
	// 	$this->load->library('form_validation');
	// 	$this->load->library('prep_html');
	// 	$this->data['resources'] = $this->prep_html->prep_resources(array('asset/css/about/about.css', 'asset/css/about/md-device.css', 'asset/css/about/sm-devices.css'), 'css');
	// 	$this->data['current'] = 'about';
	// 	$this->data['wallpaper'] = 'tumblr_mnh0uemhCk1st5lhmo1_1280.jpg';
	// 	$this->load->database();
	// 	$this->data['success'] = FALSE;

	// }
	public function validate($post){
		
		//form preppin
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		if($this->form_validation->run())
		{
			$this->insert_data($post);
			return TRUE;
		}
		
	}

	public function insert_data($data = array()){
		$nsp = $this->table;
		$name = $data['username'];
		$email =  $data['email'];
		$subject = $data['subject'];
		$message = $this->db->escape_str($data['message']);
		$query_string = "INSERT INTO $nsp(name, email, subject, message) VALUES('$name', '$email', '$subject', '$message')";
		$query_result =  $this->db->query($query_string);
		if($query_result)
			return TRUE;

		return FALSE;
	}

	public function escape($value){
		return mysqli_escape_string($value);
	}
}