<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_Producing_Date_Fields extends CI_Migration {

    public function up()
    {
        $this->dbforge->drop_column('products', 'producing_date');
    }

    public function down()
    {
        $this->dbforge->drop_column('storage', 'quantity');
    }

}