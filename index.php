<?php
/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008,2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package wolf
 * @subpackage plugin.comment
 *
 * @author Okke de Nijs <odenijs@gmail.com>
 * @version 0.1
 * @since Wolf version 0.6.0
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 License
 * @copyright Philippe Archambault & Martijn van der Kleijn, 2008
 */

Plugin::setInfos(array(
				'id' 					=> 'menu_title',
				'title' 			=> __('Menu Title'),
				'description' => __('Adds an extra field for storing a menu title.'),
				'license'			=> 'GPL',
				'version' 		=> '0.1',
				'website' 		=> ''
));

// Add the plugin's tab and controller
//Plugin::addController('menu_title', __('Menu_Title'));
//Plugin::addController('menu_title', __('Menu_Title'), 'administrator', true);

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
	
	if (empty($menutitle))  {
	 	return $pagetitle;
	 } else {
	 	return $menutitle;
	 }
}


