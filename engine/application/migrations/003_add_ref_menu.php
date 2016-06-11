<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Migration_add_ref_menu
 *
 * @author marwansaleh
 */
class Migration_add_ref_menu extends MY_Migration {
    protected $_table_name = 'ref_mainmenu';
    protected $_primary_key = 'id';
    protected $_index_keys = array('link');
    protected $_fields = array(
        'id'    => array (
            'type'  => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'parent'    => array (
            'type'  => 'INT',
            'constraint' => 11,
            'null' => TRUE,
            'default' => 0
        ),
        'caption'   => array(
            'type'  => 'VARCHAR',
            'constraint' => 50,
            'null' => TRUE
        ),
        'title' => array(
            'type'  => 'VARCHAR',
            'constraint' => 254,
            'null' => TRUE
        ),
        'icon'   => array(
            'type'  => 'VARCHAR',
            'constraint' => 50,
            'null' => TRUE
        ),
        'link'   => array(
            'type'  => 'VARCHAR',
            'constraint' => 254,
            'null' => TRUE
        ),
        'sort'   => array(
            'type'  => 'INT',
            'constraint' => 3,
            'default' => 0
        ),
        'hidden'   => array(
            'type'  => 'TINYINT',
            'constraint' => 1,
            'default' => 0,
            'null' =>TRUE
        )
    );
    
    function up() {
        parent::up();
        
        $main_menu = array(
            array(
                'caption'   => 'Surat Masuk',
                'title'     => 'Incoming',
                'icon'      => NULL,
                'link'      => 'incoming',
                'sort'      => 0,
                'hidden'    => 0
            ),
            array(
                'caption'   => 'Surat Keluar',
                'title'     => 'Outgoing',
                'icon'      => NULL,
                'link'      => 'outgoing',
                'sort'      => 1,
                'hidden'    => 0
            ),
            array(
                'caption'   => 'Nota Dinas',
                'title'     => 'Nota dinas',
                'icon'      => NULL,
                'link'      => 'nodin',
                'sort'      => 2,
                'hidden'    => 0
            ),
            array(
                'caption'   => 'Settings',
                'title'     => 'Settings',
                'icon'      => NULL,
                'link'      => '#',
                'sort'      => 3,
                'hidden'    => 0,
                'children'  => array(
                    array(
                        'caption'   => 'Accounts',
                        'title'     => 'User account',
                        'icon'      => NULL,
                        'link'      => 'auth/user',
                        'sort'      => 0,
                        'hidden'    => 0,
                    ),
                    array(
                        'caption'   => 'Groups',
                        'title'     => 'User groups',
                        'icon'      => NULL,
                        'link'      => 'auth/group',
                        'sort'      => 1,
                        'hidden'    => 0,
                    )
                )
            ),
        );
        
        $this->_seed_extend($main_menu,0,'parent');
    }
}

/*
 * filename : 003_add_ref_menu.php
 * location : /application/migrations/003_add_ref_menu.php
 */
