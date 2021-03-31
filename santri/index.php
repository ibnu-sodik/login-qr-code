<?php 

include 'header.php';

@$page = $_GET['page'];
if ($page=="" || $page=="dashboard") {
	include 'pages/dashboard.php';
}
elseif ($page=="profil") {
	include 'pages/profil.php';
}

include 'footer.php';

 ?>