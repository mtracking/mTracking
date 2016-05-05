<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Product extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'auto_increment' => TRUE
                        ),
                        'serial_no' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                        ),
                        'storage_id' => array(
                                'type' => 'INT',
                        ),
                        'producing_date' => array(
                                'type' => 'DATETIME'
                        ),
                        'status_product' => array(
                                'type' => 'INT',
                                'constraint' => 2,
                        ),
                        'location' => array(
                                'type' => 'TEXT'
                        ),
                        'user_id' => array(
                                'type' => 'INT',
                                'null' => TRUE
                        ),
                        'created_at' => array(
                                'type' => 'TIMESTAMP'
                        ),
                        'updated_at' => array(
                                'type' => 'TIMESTAMP'
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('products');
        }

        public function down()
        {
                $this->dbforge->drop_table('products');
        }
}