<?php
function isWord($string)
{

	$isWord = TRUE;
	$state = 0;
	$str_length = strlen($string);
	for($i=0; $i < $str_length; $i++)
	{
		$char = substr($string, $i, 1);
		// validate each character with ""
		if($char == ' ')
			$state++;
	}

	if($state != 0)
		$isWord = false;

	return $isWord;


}

function humandReadableTimestamp($timestamp){
	$faker = Faker\Factory::create();
	$parsedDate = $faker->parse($timestamp);
	echo $parseDate->diffForHumans();

}


function pre($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function count_inner_arrays($array)
{
	$count = 0;
	foreach($array as $inner_array)
	{
		$count++;
	}
	return $count;
}


function mysqli_inst($server = "localhost", $user = "root" , $password = "" , $db = "ofex"){
	return new mysqli($server, $user, $password, $db);
}

function mysqli(){
	return mysqli_inst();
}

function isEmpty($value)
{
	return empty($value);
}


function stripoff($strip_values, $original){
	if(is_array($strip_values)){
		return str_ireplace($strip_values, " ", $original);
	}


}

function unhyphen($string){
	//unhypen a string of words
	$str_len = strlen($string);
	$new_string = '';
	for($i=0; $i< $str_len; $i++)
	{
		$char = substr($string, $i, 1);
		if($char == '-')
		{
			$new_string .= ' ';
		}
		else
		{
			$new_string .= $char;
		}
	}

	return $new_string;
}


function getDaysRemaining($datetime){
	$past_month = justMonth($datetime);
	$past_day = justDay($datetime);
    $cur_day = date('d', time());  //current day
    $cur_month = date('m', time()); //current month
    if(isSameMonth($cur_month, $past_month))
    {
    	$daysRemaining = ($cur_day - $past_day);
		$daysRemaining = ( $daysRemaining != 0)? $daysRemaining  : 1;
		return $daysRemaining." day(s) ago";

    }
    else if(($cur_month - $past_month) == 1 )
    {

      return (getDaysInMonth($past_month) - $past_day) + $cur_day ." day(s) ago";
    }
    else 
    	return justDate($datetime);
}

function justDate($datetime){
	return substr($datetime, 0, 10);
}

function justDay($datetime){
	return substr($datetime, 8, 2) + 0; //casting it to numerice by adding 0;
}
function justMonth($datetime){
	return substr($datetime, 5, 2) + 0; //casting it to numerice by adding 0;
}
function isSameMonth($month1, $month2){
	if(($month1 - $month2) == 0)
		return true;
	return false;
}

function castToNumeric($val){
	return $val + 0;
}

function getDaysInMonth($month){
	$daysInMonths = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	return $daysInMonths[$month-1];
}


function getSocialNetwork($url){
	$found = false;
	$social_networks = ['twitter', 'facebook', 'gmail'];
	foreach($social_networks as $network){
		if($found === false)
		{
			if(strpos($url, $network) !== false )
				$found = $network; 
		}
	}
	return $found;
}






