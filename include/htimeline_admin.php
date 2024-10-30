<?php  
include('variables.php');
 
        if($_POST['htimeline_hidden'] == 'Y') {  
			//Form data sent  
			$regex = $_POST['regex'];
			$output_format = $_POST['output_format'];
			$order = $_POST['order'];
			$css = $_POST['css'];
			$bc_suffix = $_POST['bc_suffix'];
			$ac_suffix = $_POST['ac_suffix'];
			update_option('htimeline_regex', $regex);
			update_option('htimeline_output_format', $output_format); 
			update_option('htimeline_order', $order);
			update_option('htimeline_css', $css);
			update_option('htimeline_bc_suffix', $bc_suffix);
			update_option('htimeline_ac_suffix', $ac_suffix );
        ?>  
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php  
     } else {  
        	$regex = get_option('htimeline_regex');
			$output_format = get_option('htimeline_output_format');
			$order = get_option('htimeline_order');
			$css = get_option('htimeline_css');
			$bc_suffix = get_option('htimeline_bc_suffix');
			$ac_suffix = get_option('htimeline_ac_suffix');
    }  
 ?>  

<div class="wrap">
    <h2 style="font-size: 33px;">History Timeline</h2>
<table class="widefat">
	<tbody>
	<tr>
	<td scope="col">
		<div style="position: relative; float: left; width: 80%;">
			<h2>How to use history timeline</h2>
			<p class="tagcode">
				Copy and paste this code in your article, page or widget content.<br/>
			</p>
			<span style="font-size: 14px;"><b>[history_timeline]</b></span><br><br>
			<p class="tagcode">
				You can also specify 3 additional parameter <b>limit</b>,<b>category</b> and <b>exlcude</b>.<br/>
			</p>
                        <span style="font-size: 14px;"><b>[history_timeline limit=10 category=12,45 exclude=12345,6432]</b></span><br>
                        This code will limit the result to ten, fetch the posts only from the cetegories with id 12 and 45
                        and also exclude the posts with id 12345 and 6432<br><br>
			<h2>General options</h2>
			<form name="htimeline_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
			<p><input type="hidden" name="htimeline_hidden" value="Y">
			<?php _e("Input date format: " ); ?>
			&nbsp;
			<select name="regex">
			<? foreach($date_formats_list as $format){
				if($format['regex']==$regex) echo "<option value=\"".$format['regex']."\" selected>".$format['date']."</option>";
				else echo "<option value=\"".$format['regex']."\">".$format['date']."</option>";
			}
			?>
			</select> 
			<i>You must write the tag in the selected format, for <b>before christ</b> date add BC in upper case (ex: 0001 BC)</i>
			</p>
			<p>
			<?php _e("Output date format: " ); ?>
			&nbsp;
			<select name="output_format">
			<? foreach($date_print_formats as $label => $format){
				if($format==$output_format) echo "<option value=\"".$format."\" selected>".$label."</option>";
				else echo "<option value=\"".$format."\">".$label."</option>";
			}
			?>
			</select>
			<p>
			<?php _e("Order: " ); ?>
			&nbsp;
			<select name="order">
				<option <? if($order=="sort") echo "selected"; ?> value="sort">lowest to highest</option>			
				<option <? if($order=="rsort") echo "selected"; ?> value="rsort">highest to lowest</option>
			</select>
			 <i>The diplay order of the timeline</i>
			</p>
			<h2>Before and after christ suffix</h2>
			<p>
			<?php _e("Before christ suffix: " ); ?>
			&nbsp;	
			<input type="text" name="bc_suffix" size="10" <? if($bc_suffix==""){ echo "value=\"BC\"";} else{ echo "value=\"".$bc_suffix."\"";} ?>>
			</p>
			<p>
			<?php _e("After christ suffix: " ); ?>
			&nbsp;	
			<input type="text" name="ac_suffix" size="10" <? if($ac_suffix!="") echo "value=\"".$ac_suffix."\""; ?>>
			</p>
			<h2>Stylesheet</h2>
                        <p>
			<textarea name="css" cols="60" rows="15"><? if($css=="") echo $default_css;
                           else echo $css;	
			?></textarea>
			</p>				
			<p class="submit">
			&nbsp;<input type="submit" class="button-primary" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
			</p>
			</form>
			<p>
			</p>
		</div>
	</td>
	</tr>
	</tbody>
	</table>
</div>
