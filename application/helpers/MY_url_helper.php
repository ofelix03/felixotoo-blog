<?php



 function article_template($paths, $data){
 		$object = get_instance();


		if(is_array($paths) and is_array($data))
		{
			$header_path = array_shift($paths);
			$content_path = array_shift($paths);
			$footer_path = $paths[0];

			$header_data = array_shift($data);
			$content_data = array_shift($data);
			$footer_data = $data[0];

		}

		$object->load->view($header_path, $header_data);
		$object->load->view($content_path, $content_data);
		$object->load->view($footer_path, $footer_data);
	}


function template($paths, $data)
{
	$this->article_template($path, $data);
}


