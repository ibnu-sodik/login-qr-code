<?php 

include 'includes/header.php'; 

@$page = $_GET['page'];
if ($page=="" || $page=="santri") {
	include 'pages/santri/data.php';
}
elseif ($page=="add_santri") {
	include 'pages/santri/add.php';
}elseif ($page=='edit_santri') {
	include 'pages/santri/edit.php';
}elseif ($page=='delete_santri') {
	include 'pages/santri/delete.php';
}
include 'includes/footer.php';

 ?>