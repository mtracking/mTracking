<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {
    private $table = 'orders';

    public function insert($order_data)
    {
        return $this->db->insert($this->table, $order_data);
    }

    public function all($limit = 0, $email = NULL, $status_order = NULL)
    {
        if (!is_null($email)) $this->db->like('email', $email);
        if (!is_null($status_order)) $this->db->where('status_order', $status_order);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'desc');
        return $this->db->get($this->table)->result();
    }

    public function get_orders_of_customer($limit = 0, $email, $status_order = NULL)
    {
        if (!is_null($status_order)) $this->db->where('status_order', $status_order);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'desc');
        return $this->db->where('email', $email)->get($this->table)->result();
    }

    public function count_orders_of_customer($email, $status_order = NULL)
    {
        if (!is_null($status_order)) $this->db->where('status_order', $status_order);
        return $this->db->where('email', $email)->get($this->table)->num_rows();
    }

    public function change_status($id, $status_order)
    {
        return $this->db->where('id', $id)->update($this->table, array('status_order' => $status_order));
    }

    public function count($email = NULL, $status_order = NULL)
    {
        if (!is_null($email)) $this->db->like('email', $email);
        if (!is_null($status_order)) $this->db->where('status_order', $status_order);
        return $this->db->get($this->table)->num_rows();
    }

    public function delete($id, $role_customer = NULL)
    {
        if (!is_null($role_customer))
        {
            $order = $this->db->get_where($this->table, array('id' => $id))->first_row();
            if ($order->status_order != ORDER) return FALSE;
        }
        return $this->db->where('id', $id)->delete($this->table);
    }

}