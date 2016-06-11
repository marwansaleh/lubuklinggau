<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Migration_add_ref_bidang
 *
 * @author marwansaleh
 */
class Migration_add_ref_bidang extends MY_Migration {
    protected $_table_name = 'ref_bidang';
    protected $_primary_key = 'id';
    protected $_index_keys = array('nama');
    protected $_fields = array(
        'id'    => array (
            'type'  => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'nama' => array(
            'type' => 'VARCHAR',
            'constraint' => 50,
            'null' => FALSE
        )
    );
    
    public function up(){
        parent::up();
        //Need seeding ?
        $this->_seed(array(
            array(
                'id'            => 1,
                'nama'          => 'Direksi'
            ),
            array(
                'id'            => 2,
                'nama'          => 'Marketing'
            ),
            array(
                'id'            => 3,
                'nama'          => 'Tehnik'
            ),
            array(
                'id'            => 4,
                'nama'          => 'Klaim'
            ),
            array(
                'id'            => 5,
                'nama'          => 'Keuangan'
            ),
            array(
                'id'            => 6,
                'nama'          => 'Umum'
            ),
            array(
                'id'            => 7,
                'nama'          => 'Electronic Data Processing'
            ),
            array(
                'id'            => 8,
                'nama'          => 'Satuan Pengawas Intern'
            ),
            array(
                'id'            => 9,
                'nama'          => 'Kantor Cabang'
            ),
            array(
                'id'            => 10,
                'nama'          => 'SDM'
            ),
            array(
                'id'            => 11,
                'nama'          => 'Komisaris'
            )
        ));
    }
}

/*
 * filename : 001_add_ref_bidang.php
 * location : /application/migrations/001_add_ref_bidang.php
 */
