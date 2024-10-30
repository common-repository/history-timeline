<?

$date_formats_list=array();
$date_formats=array('date'=>'Y-m-d','regex'=>'^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])([ BC])*$');
$date_formats_list[]=$date_formats;
$date_formats=array('date'=>'d-m-Y','regex'=>'^([0-3][0-9])-([0-1][0-9])-([0-9]{2,4})([ BC])*$');
$date_formats_list[]=$date_formats;
$date_formats=array('date'=>'m-Y','regex'=>'^([0-1][0-9])-([0-9]{2,4})([ BC])*$');
$date_formats_list[]=$date_formats;
$date_formats=array('date'=>'Y','regex'=>'^([0-9]{2,4})([ BC])*$');
$date_formats_list[]=$date_formats;

$date_print_formats=array('Y-m-d (1985-08-06)'=> 'Y-m-d',
			  'd-m-Y (06-08-1985)'=>'d-m-Y',
			  'm-Y (08-1985)'=>'m-Y',
			  'D d M Y (Fri 6 Aug 2010)'=>'D d M Y',
			  'd M Y (6 Aug 2010)'=>'d M Y',
			  'M Y (Aug 2010)'=>'M Y',
			  'Y/m/d (1985/08/06)'=> 'Y/m/d',
			  'd/m/Y (06/08/1985)'=>'d/m/Y',
			  'm/Y (08/1985)'=>'m/Y',  	
			  'Y (1985)'=>'Y',
			  'y (85)'=>'y',);

$default_css="
#history_timeline{
width: 600px; margin: 0 auto;
}

#history_timeline .timeline_row{
clear: both; display:block;
}

#history_timeline .timeline_left{
width: 40%; float: left; text-align: right; margin-right: 10px;
padding-bottom: 10px; padding-top: 10px;
height: 40px;
}

#history_timeline .timeline_right{
width: 40%; float: left; padding-left: 10px;
padding-bottom: 10px; padding-top: 10px;
border-left: 1px solid #000;
height: 40px;
}

#history_timeline .timeline_tag{
font-weight: bold;
}

#history_timeline .timeline_tag a{
text-decoration: none;
color: #000;
}

#history_timeline .timeline_clear{
clear: both; display:block;
}

#history_timeline_widget{
width: 100%;
display:block;
clear: both;
}

#history_timeline_widget .timeline_widget_tag{
font-weight: bold;
}

#history_timeline_widget .timeline_widget_title a{
font-weight: normal;
}

";

?>
