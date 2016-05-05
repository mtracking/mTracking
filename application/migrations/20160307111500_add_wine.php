<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_wine extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'auto_increment' => TRUE
                        ),
                        'name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255'
                        ),
                        'expriry_date' => array(
                                'type' => 'DATETIME'
                        ),
                        'storage_temp' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                        ),
                        'quality' => array(
                                'type' => 'TEXT'
                        ),
                        'category_id' => array(
                                'type' => 'INT',
                                'constraint' => 3,
                        ),
                        'created_at' => array(
                                'type' => 'TIMESTAMP'
                        ),
                        'updated_at' => array(
                                'type' => 'TIMESTAMP'
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('wines');
        }

        public function down()
        {
                $this->dbforge->drop_table('wines');
        }
}