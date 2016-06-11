<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Controller inherit from CI_Controller 
 * which will be the base controller for all controllers used
 * in this application
 *
 * @author marwansaleh 5:42:25 PM
 */
class MY_Controller extends CI_Controller {
    public $data = array();
    
    function __construct() {
        parent::__construct();
        
        if (!isset($this->session)){
            $this->load->library('session') or die('Can not load library Session');
        }
    }
}

class Admin_Controller extends MY_Controller {
    private static $_menu_level_deep = 0;
    private static $_menu_level_base_parent = 0;
    
    function __construct() {
        parent::__construct();
        
        //load neccessary models
        $this->load->model(array('auth_user_m','mainmenu_m'));
        //load helper
        $this->load->library('form_validation');
        //init breadcumb
        $this->data['breadcumb'] = array();
        //set mainmenu
        $this->data['mainmenus'] = $this->get_user_menu();
    }
    
    protected function get_user_menu(){
        
        $result = $this->userlib->get_user_menu();
        if ($result){
            $menu_array = array('parents' => array(),'items' => array());
            foreach ($result as $menu_item){
                if (!$menu_item->granted){
                    continue;
                }
                $menu_array['parents'][$menu_item->parent][] = $menu_item->id;
                $menu_array['items'][$menu_item->id] = $menu_item;
            }
            
            return $this->_hierarchy_menus($menu_array); //start level deep from 0
        }else{
            return NULL;
        }
    }
    
    private function _hierarchy_menus($menus, $parent=0, $level_deep=0){
        $menulist = array();
        if (isset($menus['parents'][$parent])){
            
            //get menu item for each id where parent = $parent
            foreach ($menus['parents'][$parent] as $menu_id){
                $menuitem = $menus['items'][$menu_id];
                //jika parent sama dengan base, kembalikan level ke 0
                if (self::$_menu_level_deep > 0 && $menuitem->parent == self::$_menu_level_base_parent){
                    $level_deep = 1;
                }
                //apakah sudah sampai pada level yang diinginkan
                if (self::$_menu_level_deep > 0 && $level_deep >= self::$_menu_level_deep){
                    //echo 'level:'.$level_deep.' counter:'.self::$menu_level_deep;exit;
                    $menuitem->children = NULL;
                }else{
                    //does menu has submenu ?
                    if (isset($menus['parents'][$menuitem->id])){
                        $menuitem->children = $this->_hierarchy_menus($menus, $menuitem->id, ($level_deep+1));
                    }else{
                        $menuitem->children = NULL;
                    }
                }
                
                
                $menulist[] = $menuitem;
            }
        }
        
        return $menulist;
    }
    
}

/**
 * Filename : MY_Controller.php
 * Location : applications/core/MY_Controller.php
 */
