<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart_model extends CI_Model {

    private $table = 'shopping_cart';
    private $type_table = 'types';
    private $pictures_table = 'pictures';

    public function join_to_another_table()
    {
        $this->db->select('shopping_cart.*, types.name AS type_name, types.price, pictures.image_file_name');
        $this->db->from('shopping_cart');
        $this->db->join($this->type_table, 'types.id = shopping_cart.type_id');
        $this->db->join($this->pictures_table, 'types.id = pictures.type_id', 'left');
    }

    public function all($limit = 0, $user_id = NULL)
    {
        $this->join_to_another_table();
        $this->db->where('shopping_cart.user_id', $user_id);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $this->db->group_by('types.id');
        return $this->db->get()->result();
    }

    public function insert($shopping_cart_data)
    {
        return $this->db->insert($this->table, $shopping_cart_data);
    }

    public function find($user_id, $type_id)
    {
        return $this->db->get_where($this->table, array('user_id' => $user_id, 'type_id' => $type_id))->first_row();
    }

    public function update($id, $quantity)
    {
        return $this->db->where('id', $id)->update($this->table, array('quantity' => $quantity));
    }

    public function count($user_id)
    {
        return $this->db->get_where($this->table, array('user_id' => $user_id))->num_rows();
    }

    public function get_carts_of_user($user_id)
    {
        return $this->db->get_where($this->table, array('user_id' => $user_id))->result();
    }

    public function delete($id, $user_id)
    {
        return $this->db->where('user_id', $user_id)->where_in('id', $id)->delete($this->table);
    }

    public function delete_cart_of_user($user_id)
    {
        return $this->db->where('user_id', $user_id)->delete($this->table);
    }
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
?>