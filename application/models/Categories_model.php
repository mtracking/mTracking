<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {

    private $table = 'categories';
    private $types_table = 'types';

    public function __construct()
    {
        parent::__construct();

    }

    public function get_all_categories($data = NULL, $is_active = NULL)
    {
        if (!is_numeric($data)) $this->search($data);
        (is_null($is_active)) ? $this->is_active() : $this->is_active($is_active);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function search($data)
    {
        $this->db->group_start();
        $this->db->like('name', $data);
        $this->db->group_end();
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('categories.is_active', $is_active);
    }

    public function count($data = NULL, $is_active = NULL)
    {
        if (!is_numeric($data)) $this->search($data);
        (is_null($is_active)) ? $this->is_active() : $this->is_active($is_active);
        return $this->db->get($this->table)->num_rows();
    }

    public function insert_new_category($category)
    {
        $query = $this->db->insert($this->table, $category);
        return $query;
    }

    public function update_category($category) {
        $this->db->where('id', $category['id']);
        $query = $this->db->update($this->table, $category);
        return $query;
    }

    public function get_category_by_id($id)
    {
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->first_row();
    }

    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->table);
        return $query;
    }

    public function delete_categories($list)
    {
        $this->db->where_in('id', $list);
        $query = $this->db->update($this->table, array('is_active' => NOT_ACTIVE));
        // $query = $this->db->delete($this->table);
        return $query;
    }

    public function get_types($id)
    {
        return $this->db->where('is_active', ACTIVE)->where('category_id', $id)->get($this->types_table)->result();
    }

}

/* End of file Categories_model.php */
/* Location: ./application/models/Categories_model.php */
?>