<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Role extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 1,
                                'auto_increment' => TRUE
                        ),
                        'name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255'
                        ),
                        'created_at' => array(
                                'type' => 'TIMESTAMP'
                        ),
                        'updated_at' => array(
                                'type' => 'TIMESTAMP'
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('role');
        }

        public function down()
        {
                $this->dbforge->drop_table('role');
        }
}