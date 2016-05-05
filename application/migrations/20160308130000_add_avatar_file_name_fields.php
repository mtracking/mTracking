<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Avatar_File_Name_Fields extends CI_Migration {

    public function up()
    {
        $fields = array(
          'avatar_file_name VARCHAR(100)'
        );

        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'avatar_file_name');
    }

}