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
if (!defined('IN_CMS')) { exit(); }

class MenuTitleController extends PluginController {

    const VIEW_FOLDER = "../../plugins/menu_title/views/";
    
    public function __construct() {
        
        AuthUser::load();
        if (!(AuthUser::isLoggedIn())) {
            redirect(get_url('login'));
        }
    }

    public static function Callback_view_page_edit_tab_links($page)
    {
        echo '<li class="tab"><a href="#'.MENUTITLE_CSS_ID.'">'. __('Menu Title') . '</a></li>';
    }

    public static function Callback_view_page_edit_tabs(&$page) 
    {
        global $__CMS_CONN__;

        $sql = 'SELECT menu_title FROM '.TABLE_PREFIX.'page WHERE id=?';
        $stmt = $__CMS_CONN__->prepare($sql);
        
        $stmt->execute(array($page->id));

        $menutitle = $stmt->fetchColumn();
        
        // $this->display('menu_title/views/menu_title_content', array(
        //     'menutitle' => $menutitle,
        // ));
        // echo new View(self::VIEW_FOLDER.'menu-title-content', array(
        //     'page_id'   => $page->id,
        //     'menutitle' => $menutitle,
        // ));
    }   

}