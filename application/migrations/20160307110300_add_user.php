<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'auto_increment' => TRUE
                        ),
                        'encrypted_password' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255'
                        ),
                        'full_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '200'
                        ),
                        'phone' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '15'
                        ),
                        'address' => array(
                                'type' => 'TEXT'
                        ),
                        'role_id' => array(
                                'type' => 'INT',
                                'constraint' => 1,
                        ),
                        'created_at' => array(
                                'type' => 'TIMESTAMP'
                        ),
                        'updated_at' => array(
                                'type' => 'TIMESTAMP'
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('users');
        }

        public function down()
        {
                $this->dbforge->drop_table('users');
        }
}