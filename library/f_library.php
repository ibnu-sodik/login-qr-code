<?php 

function sanitize($text){
	global $mysqli;
	$safetext = $mysqli->real_escape_string(stripslashes(strip_tags(htmlspecialchars($text,ENT_QUOTES))));
	return $safetext;
}

function display_errors($errors){
	$display='';
	foreach ($errors as $error) {
   $display .= '<div class="alert alert-warning alert-dismissable" role="alert">';
   $display .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
   $display .= '<p class="text-left">'.$error.'</p>';
   $display .= '</div>';
 }
 return $display;
}

 ?>