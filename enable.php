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

if (!defined('IN_CMS')) { exit(); }

$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

// Add menu title field to main table
if ($driver == 'mysql')
{
    $PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD menu_title varchar(255) NULL default NULL");
}
else if ($driver == 'sqlite')
{
	//someday will add this option if needed
	//$PDO->exec("CREATE INDEX comment_page_id ON comment (page_id)");
	//$PDO->exec("CREATE INDEX comment_created_on ON comment (created_on)");
    
    //$PDO->exec("ALTER TABLE page ADD comment_status tinyint(1) NOT NULL default '0'");
    //$PDO->exec("ALTER TABLE comment ADD ip char(100) NOT NULL default '0'");	
}

// $settings = Plugin::getAllSettings('menutitle');
// var_dump($settings);
}