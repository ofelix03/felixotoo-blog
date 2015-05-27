<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prep_HTML {

   public function prep_resources($addresses, $type){
		$resources = '';
		switch (strtolower($type)) {
			case 'css':
				//generates css link with the passed array of addresses;
				if(!is_array($addresses))
					return $resources .= "<link rel='stylesheet' type='text/css' href='".base_url($addresses)."' />";

				foreach($addresses as $address)
				{
					$resources .= "<link rel='stylesheet' type='text/css' href='".base_url($address)."' />";
				}

				break;

			case 'js':
				//generates js script with the passed array of addresses;
				foreach($addresses as $address)
				{
					$resources .= "<script type='text/javascript' src='".base_url($address)."'></script>";
				}
				break;

		}
		return $resources;


	}
}
