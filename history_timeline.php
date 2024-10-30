<?php  
/* 
    Plugin Name: History timeline
    Plugin URI: http://historytimeline.toforge.com
    Description: Plugin for display an history timeline based on tags. You can discriminate the tags, for build timeline, by a regular expression, for each tag this plugin extract a random post from all related posts.
    Author: Mauro Rocco
    Version: 0.7.2
    Author URI: http://www.toforge.com

    Copyright 2009  Mauro Rocco  (email : fireantology@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function print_timeline($atts,$widget) {
require_once('include/functions.php'); 
include('include/variables.php');
extract(shortcode_atts(array(
		'limit' => false,
                'category' => false,
                'exclude' => false,
	), $atts));

global $wpdb;

$limit = "{$limit}";
$categories = "{$categories}";
$exclude = "{$exclude}";

$string_category="";
$string_exclude="";
if($category) $string_category="&category=".$category;
if($exclude) $string_exclude="&exclude=".$exclude;

$regex=get_option('htimeline_regex');
$output_format=get_option('htimeline_output_format');
$display_order=get_option('htimeline_order');
$date_format="";

foreach($date_formats_list as $format){
	if($format['regex']==$regex) $date_format=$format['date'];
}

$allTags=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."terms WHERE name REGEXP '$regex' ");
$already_viewed=array();
$keys=array();
$matrix=array();
foreach($allTags as $thisTags) {

  $tag=get_object_vars($thisTags);
	$related=get_posts('tag='.$tag['slug'].$string_category.$string_exclude);
        if($related==null) continue;
	$i=0;
	$post_t=get_object_vars($related[0]);
	$print=true;
	shuffle($related);
	for($i;$i<=count($related);$i++){
		$post_t=get_object_vars($related[$i]);
		if($i==count($related)) $print=false;
		if(!in_array($post_t['ID'],$already_viewed)) break;
	}


	if($print){
                $already_viewed[]=$post_t['ID'];
                $article=array();
                $article['post']=$post_t;

                $datetime=stringToDate($tag['name'],$date_format);
                $keys[]=$datetime;

                $article['tag']=$tag;
                $matrix[$datetime->format('Y-m-d')]=$article;
                
	}  
        if($widget) $string="<div id=\"history_timeline_widget\">";
        else $string="<div id=\"history_timeline\"><ul>";

        $alt=0;

        if($display_order=="sort") sort($keys);
        else rsort($keys);

        foreach($keys as $key){
                $article=$matrix[$key->format('Y-m-d')];
                $tag_name=niceDatePrint($key,$output_format);
                $post_t=$article['post'];
                if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){
                  $post_t = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($post_t);
                }
                $tag=$article['tag'];
                $titolo=substr($post_t['post_title'],0,42);

                if(strlen($post_t['post_title'])>42) $titolo.="...";
                $link=get_permalink($post_t['ID']);

                if($widget){
                        $string.="<li><span class=\"timeline_widget_tag\">".$tag_name."</span>: <span class=\"timeline_widget_title\"><a href=\"".$link."\">".$titolo."</a></span></li>";
                }
                else{
                        $string.="<div class=\"timeline_row\">";
                        $thumbnail = "";
                        if($alt%2==0){
                                if(has_post_thumbnail($post_t['ID'])){
                                  $thumbnail = get_the_post_thumbnail($post_t['ID'], 'thumbnail', array('class'=> 'history_timeline_thumbnail right_aligned'));
                                }  
                                  $string.="<div class=\"timeline_left\"><span class=\"timeline_tag\"><a href=\"".get_bloginfo('url')."/tag/".$tag['slug']."/\">".$tag_name."</a></span></div><div class=\"timeline_right\"><a href=\"".$link."\">".$titolo."</a>".$thumbnail."</div>";
                                
                        }
                        else{
                                if(has_post_thumbnail($post_t['ID'])){
                                  $thumbnail = get_the_post_thumbnail($post_t['ID'], 'thumbnail', array('class'=> 'history_timeline_thumbnail left_aligned'));
                                }
                                $string.="<div class=\"timeline_left\">".$thumbnail."<a href=\"".$link."\">".$titolo."</a></div><div class=\"timeline_right\"><span class=\"timeline_tag\"><a href=\"".get_bloginfo('url')."/tag/".$tag['slug']."/\">".$tag_name."</a></span></div>";
                        }
                        $string.="<div class=\"timeline_clear\"></div></div>";
                }

                $alt++;
                if($limit && $limit==$alt) break;
        }
}
if($widget) $string.="</ul><div style=\"clear: both; display:block;\"></div></div>";
else $string.="<div style=\"clear: both; display:block;\"></div></div>";
return $string;
}

add_shortcode('history_timeline', 'print_timeline');

function history_timeline_css() {
$css=get_option('htimeline_css');
echo "<style type=\"text/css\">\n";
echo $css;
echo "\n</style>";
}

add_action('wp_head', 'history_timeline_css');

function history_timeline_admin_actions() {  
     add_options_page("History Timeline", "History Timeline", "manage_options", "HistoryTimeline", "htimeline_admin");  
}  

function htimeline_admin() {  
     include('include/htimeline_admin.php');  
}  
   
add_action('admin_menu', 'history_timeline_admin_actions'); 

/* WIDGET FUNCTIONS */

function history_timeline_widget($args) {
  extract($args);
  echo $before_widget;
  echo $before_title."Timeline".$after_title;
  echo print_timeline('[history_timeline]',true); 
  echo $after_widget;	
}
 
function init_history_timeline_widget()
{
  register_sidebar_widget(__('History Timeline'), 'history_timeline_widget');
}

add_action("plugins_loaded", "init_history_timeline_widget"); 

?>
