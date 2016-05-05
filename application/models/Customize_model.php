<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customize_model extends CI_Model {

    private $table = 'customize';

    public function get()
    {
        return $this->db->get($this->table)->first_row();
    }

    public function update($customize_data)
    {
        return (!is_null($this->get())) ? $this->db->update($this->table, $customize_data) : $this->db->insert($this->table, $customize_data);
    }
}