<?php
/**
 * Menu title Plugin for Wolf CMS
 * 
 * Once created it for a project using Frog CMS, converted it for Wolf CMS
 *
 * Copyright (C) 2010 Okke de Nijs <odenijs@gmail.com>
 * 
 * Licensed under the GPL (gpl-license.txt) licenses.
**/

Plugin::setInfos(array(
				'id' 			=> 'menu_title',
				'title' 		=> __('Menu Title'),
				'description'	=> __('Adds an extra field for storing a menu title.'),
				'license'		=> 'GPL',
				'version' 		=> '0.1',
				'website' 		=> 'http://okkedenijs.nl',
				'url'			=> 'http://github.com/odenijs/Menu-Title-Wolf-CMS'
));

// Add the plugin's tab and controller
Observer::observe('view_page_edit_tabs', 'page_edit');

function page_edit(&$page) {

	global $__CMS_CONN__;

	$sql = 'SELECT menu_title FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));

	$menutitle = $stmt->fetchColumn();
	
 	echo "<div id=\"div-menutitle\" title=\"Menu titel\" name=\"Menu Title\" class=\"title\" style=\"margin-bottom:20px; margin-top:0.3em; padding: 20px;\">";
	echo "	<input id=\"page_menutitle\" class=\"textbox\" type=\"text\" value=\"".$menutitle."\" size=\"255\" name=\"page[menu_title]\" maxlength=\"255\" />";	
		//return $sub;
	echo "</div>";
}

Observer::observe('page_edit_after_save', 'menutitle_save');

function menutitle_save(&$page) 
{
    /* update the menutitle */
	global $__CMS_CONN__;
	
	$sql =	"UPDATE ".TABLE_PREFIX."page SET menu_title = '".$page->menu_title."' WHERE id=?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	//$__CMS_CONN__->exec($sql)
}

function menutitle($id) 
{	
	global $__CMS_CONN__;
	$sql = "SELECT menu_title,title FROM ".TABLE_PREFIX."page WHERE id = ?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($id));
	
	$obj = $stmt->fetchObject();
	
	$menutitle = $obj->menu_title;
	$pagetitle = $obj->title;
	
	if (empty($menutitle)) {
	 	return $pagetitle;
	 } else {
	 	return $menutitle;
	 }
}


