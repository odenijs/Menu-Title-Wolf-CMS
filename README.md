Wolf CMS currently uses a single field for it's page title. Sometimes you want to show different titles in for example the site menu.
This plugin creates an extra database field named "menu_title" and adds an extra tab to Wolf CMS.

Simple example of how to use this field:


	<ul class="menu">	
		<?php 
			$cMenu = $this->find('/');  	
			echo '<li><a href="'.BASE_URL.$areaSlug.'/">'.menutitle($cMenu->id()).'</a></li>';	
	?>

		<?php foreach ($cMenu->children() as $cMenuItems): ?>
			<li>
				<a href="<?php echo $cMenuItems->url(); ?>" title="<?php echo menutitle($cMenuItems->id()); ?>"><?php echo menutitle($cMenuItems->id());?></a>
			</li>		 
		<?php endforeach; ?>	
	</ul>




