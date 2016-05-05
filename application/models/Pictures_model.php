<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pictures_model extends CI_Model {

    private $table = 'pictures';

    public function all()
    {
        return $this->db->get($this->table)->result();
    }

}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
?>