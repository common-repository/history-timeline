<?

function stringToDate($string, $option){

	$separator="-";
	$bc ="";
	if(strpos($string ," BC")){	
		$string=str_replace(" BC" , "",$string);
		$bc ="-";
	}
	
	if(substr($option,0,1)=="Y")
	  {
	  if(strlen($option)>1){
		list($y, $m, $d) = explode($separator, $string);
	  }
	  else {
	          $d="01";
		  $m="01";
		  $y=$string;			
		}
	   }
	if(substr($option,0,1)=="d")  list($d, $m, $y) = explode($separator, $string);
	if(substr($option,0,1)=="m"){
		$d="01";	  
		list($m, $y) = explode($separator, $string);
	}


	$date = new DateTime($bc.$y.'-'.$m.'-'.$d);
	return $date;
}

function niceDatePrint($date,$output_format){
	$date_string =  $date->format($output_format);
	if($output_format=="y") $year = $date->format("y");
	else $year = $date->format("Y");
	$absolute_year = str_replace("-","",$year);
	if($year==$absolute_year){
		return 	str_replace($year,(int)$absolute_year,$date_string)." ".get_option('htimeline_ac_suffix');
	}
	else{
		return  str_replace($year,(int)$absolute_year,$date_string)." ".get_option('htimeline_bc_suffix');
	}
}

?>
