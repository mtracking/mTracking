<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Quantity_Fields extends CI_Migration {

    public function up()
    {
        $fields = array(
          'quantity INT'
        );

        $this->dbforge->add_column('storage', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('storage', 'quantity');
    }

}