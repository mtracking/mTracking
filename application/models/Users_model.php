<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    private $table = 'users';
    private $products_table = 'products';

    public function join_another_tables()
    {
        $this->db->select('users.*, COUNT(products.id) AS opened_products');
        $this->db->from($this->table);
        $this->db->join($this->products_table, 'users.id = products.user_id', 'left');
        $this->db->group_by('users.id');
    }

    public function all($limit = 0, $data = NULL)
    {
        $this->join_another_tables();
        if (!is_null($data)) $this->search($data);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('role_id', 'desc');
        $this->db->order_by('opened_products', 'desc');
        return $this->db->get()->result();
    }

    public function count($data = NULL)
    {
        $this->join_another_tables();
        if (!is_null($data)) $this->search($data);
        return $this->db->get()->num_rows();
    }

    public function search($data)
    {
        $this->db->group_start();
        $this->db->like('users.full_name', $data);
        $this->db->or_like('users.email', $data);
        $this->db->or_like('users.phone', $data);
        $this->db->group_end();
    }
    public function insert($user_data)
    {
        $query = $this->db->insert($this->table, $user_data);
        $id = $this->db->insert_id();
        return [$query,$id];
    }
    public function login($email, $password)
    {
        $user = $this->is_user_exist($email);
        if (!is_null($user))
        {
            $this->load->library('bcrypt');
            return [$this->bcrypt->check_password($password, $user->encrypted_password), $user];
        }
        else return [FALSE, NULL];
    }

    public function is_user_exist($email)
    {
        $query = $this->db->get_where($this->table, array('email' => $email));
        $result = $query->first_row();
        return $result;
    }

    public function is_email_existed($email)
    {
        $query = $this->db->get_where($this->table, array('email' => $email));
        $result = $query->num_rows();
        return $result > 0;
    }

    public function check_old_pwd($user_id, $old_password)
    {
        $this->load->library('bcrypt');

        $this->db->select('encrypted_password');
        $query = $this->db->get_where($this->table, array('id' => $user_id));
        if ( $this->bcrypt->check_password($old_password, $query->first_row()->encrypted_password) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function change_password($id, $new_password)
    {
        $this->load->library('bcrypt');
        $user['encrypted_password'] = $this->bcrypt->hash_password($new_password);
        $user['updated_at'] = date('Y-m-d H:i:s');
        $query = $this->update_user($id, $user);
        return $query;
    }

    public function update_user($id, $user)
    {
        $this->db->where('id', $id);
        $query = $this->db->update($this->table, $user);
        return $query;
    }
    public function user($id = NULL)
    {
        if ($id)
        {
            $query = $this->db->get_where($this->table, array('id' => $id));
            return $query->first_row();
        } else
        {

        }
    }

    public function delete($ids)
    {
        return $this->db->where_in('id', $ids)->delete($this->table);
    }

}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
?>