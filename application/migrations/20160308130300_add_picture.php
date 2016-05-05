<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_picture extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'auto_increment' => TRUE
                        ),
                        'image_file_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255'
                        ),
                        'description' => array(
                                'type' => 'TEXT'
                        ),
                        'image' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255'
                        ),
                        'wine_id' => array(
                                'type' => 'INT',
                        ),
                        'created_at' => array(
                                'type' => 'TIMESTAMP'
                        ),
                        'updated_at' => array(
                                'type' => 'TIMESTAMP'
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('pictures');
        }

        public function down()
        {
                $this->dbforge->drop_table('pictures');
        }
}