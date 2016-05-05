<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

    private $table = 'posts';
    private $users_table = 'users';
    private $categories_table = 'categories';
    private $types_table = 'types';
    private $pictures_table = 'pictures';
    public function join_to_another_tables()
    {
        $this->db->select(
            'posts.*, users.full_name, users.email,
            categories.id AS category_id, categories.name AS category_name,
            types.id AS type_id, types.name AS type_name,
            pictures.image_file_name');
        $this->db->from($this->table);
        $this->db->join($this->users_table, 'posts.user_id = users.id');
        $this->db->join($this->types_table, 'posts.type_id = types.id');
        $this->db->join($this->categories_table, 'types.category_id = categories.id');
        $this->db->join($this->pictures_table, 'pictures.type_id = types.id', 'left');
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
        $this->db->like('posts.title', $data);
        $this->db->or_like('users.full_name', $data);
        $this->db->or_like('users.email', $data);
        $this->db->group_end();
    }

    function find($id)
    {
        $this->join_to_another_tables();
        $this->db->where('posts.id', $id);
        return $this->db->get()->first_row();
    }

    function get_post_is_available($id, $is_available = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_available)) ? $this->is_available($is_available) : $this->is_available();
        $this->db->where('posts.id', $id);
        return $this->db->get()->first_row();
    }

    function get_post_is_available_from_type_id($type_id, $is_available = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_available)) ? $this->is_available($is_available) : $this->is_available();
        $this->db->where('posts.type_id', $type_id);
        return $this->db->get()->first_row();
    }

    function increment_view($id, $is_type_id = NULL)
    {
        (!is_null($is_type_id)) ? $this->db->where('type_id', $id) : $this->db->where('id', $id);
        $this->db->set('view', 'view +1', FALSE);
        $this->db->update($this->table);
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('posts.is_active', $is_active);
    }

    public function is_available($is_available = ACTIVE)
    {
        $this->db->where('posts.is_available', $is_available);
    }

    function insert($post_data)
    {
        return $this->db->insert($this->table, $post_data);
    }

    function update($post_data)
    {
        return $this->db->where('id', $post_data['id'])->update($this->table, $post_data);
    }
    function update_multi_posts_with_same_data($post_ids, $post_data)
    {
        return $this->db->where_in('id', $post_ids)->update($this->table, $post_data);
    }

    function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

}
?>