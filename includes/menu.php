<?php 
@$page = $_GET['page'];
?>
<ul class="app-menu">
		
	<li><a class="app-menu__item <?php if($page=='santri' || $page=='add-santri' || $page=='edit_santri')echo "active"; ?>" href="?page=santri"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Data Santri</span></a></li>
	
</ul>