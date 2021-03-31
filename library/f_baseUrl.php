<?php 

function base_url($url = null){
	$base_url = "http://localhost/belajar-qrcode";
	// $base_url = "http://192.168.47.23/belajar-qrcode";
	if ($url != null) {
		return $base_url."/".$url;
	}else{
		return $base_url;
	}
}

 ?>