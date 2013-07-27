<?php
/**
* Menu title Plugin for Wolf CMS
* 
* Once created it for a project using Frog CMS, converted it for Wolf CMS
*
* @author Okke de Nijs <odenijs@gmail.com>
* @package Wolf
* @subpackage plugin.menutitle
* @version 0.2
* @licence http://www.gnu.org/licenses/gpl.html
* @copyright 2010 Okke de Nijs
*
**/

/* Security measure */
///if (!defined('IN_CMS')) { exit(); }

Plugin::setInfos(array(
				'id' 					=> 'menu_title',
				'title' 				=> __('Menu Title'),
				'description'			=> __('Adds an extra field for storing a menu title.'),
				'version' 				=> '0.2',
				'license'				=> 'GPLv3',
				'author'        		=> 'Okke de Nijs',				
				'website' 				=> 'http://okkedenijs.nl',
				'url'					=> 'http://github.com/odenijs/Menu-Title-Wolf-CMS',
				'require_wolf_version'  => '0.7.0',
    			'type'					=> 'both'
));

define('MENUTITLE_CSS_ID', 'menu_title');

Plugin::addController('menu_title', __('Menu Title'), 'administrator', false);

// Add the plugin's tab and controller
//Observer::observe('view_page_edit_tab_links', 'page_edit');
Observer::observe('view_page_edit_tab_links', 'MenuTitleController::Callback_view_page_edit_tab_links');
Observer::observe('view_page_edit_tabs', 'page_edit');
// Observer::observe('view_page_edit_tabs', 'MenuTitleController::Callback_view_page_edit_tabs'); 
Observer::observe('page_edit_after_save', 'menutitle_save');

function page_edit($page) {

	global $__CMS_CONN__;

	$sql = 'SELECT menu_title FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	
	$stmt->execute(array($page->id));

	$menutitle = $stmt->fetchColumn();

	echo '<div id="menu_title" class="page">';
	echo '	<div id="div-menutitle" title="Menu titel" class="title">';
	echo '		<input id="page_menutitle" class="textbox" type="text" value="'.$menutitle.'" size="255" name="page[menu_title]" maxlength="255" />';	
	echo '	</div>';
	echo '</div>';
}


function menutitle_save($page) 
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


