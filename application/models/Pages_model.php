<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

    private $table = 'pages';
    private $users_table = 'users';

    public function join_to_another_tables()
    {
        $this->db->select('pages.*, users.full_name, users.email');
        $this->db->from($this->table);
        $this->db->join($this->users_table, 'pages.user_id = users.id');
    }

    public function all($limit = 0, $data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        if ($limit != 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pages_is_available($is_available = NULL)
    {
        (!is_null($is_available)) ? $this->is_available($is_available) : $this->is_available();
        return $this->db->get($this->table)->result();
    }

    public function count($data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        return $this->db->get()->num_rows();
    }

    public function search($data)
    {
        $this->db->group_start();
        $this->db->like('pages.title', $data);
        $this->db->or_like('users.full_name', $data);
        $this->db->or_like('users.email', $data);
        $this->db->group_end();
    }

    function find($id)
    {
        $this->join_to_another_tables();
        $this->db->where('pages.id', $id);
        return $this->db->get()->first_row();
    }

    function increment_view($id)
    {
        $this->db->where('id', $id);
        $this->db->set('view', 'view +1', FALSE);
        $this->db->update($this->table);
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('pages.is_active', $is_active);
    }

    public function is_available($is_available = ACTIVE)
    {
        $this->db->where('pages.is_available', $is_available);
    }

    function insert($page_data)
    {
        return $this->db->insert($this->table, $page_data);
    }

    function update($page_data)
    {
        return $this->db->where('id', $page_data['id'])->update($this->table, $page_data);
    }
    function update_multi_pages_with_same_data($page_ids, $page_data)
    {
        return $this->db->where_in('id', $page_ids)->update($this->table, $page_data);
    }

    function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

}
?>