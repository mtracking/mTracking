<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Qrcode_Fields extends CI_Migration {

    public function up()
    {
        $fields = array(
          'qrcode1 TEXT',
          'qrcode2 TEXT'
        );

        $this->dbforge->add_column('products', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('products', 'qrcode1');
        $this->dbforge->drop_column('products', 'qrcode2');
    }

}