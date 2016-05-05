<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batches_model extends CI_Model {

    private $table = 'batches';
    private $categories_table = 'categories';
    private $types_table = 'types';
    private $subtypes_table = 'subtypes';
    private $products_table = 'products';

    public function join_to_another_tables()
    {
        $this->db->select('types.name AS type_name, types.id AS type_id, types.country, types.type_details,
            subtypes.producing_year, subtypes.id AS subtype_id,
            categories.id AS category_id,
            batches.*, SUM(products.status_product = 2) AS products_opened');
        $this->db->from($this->table);
        $this->db->join($this->subtypes_table, 'batches.subtype_id = subtypes.id');
        $this->db->join($this->types_table, 'types.id = subtypes.type_id');
        $this->db->join($this->categories_table, 'categories.id = types.category_id');
        $this->db->join($this->products_table, 'batches.id = products.batch_id', 'left');
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
        $this->db->order_by('batches.producing_date', 'desc');
        $this->db->order_by('batches.created_at', 'asc');
        $this->db->group_by('batches.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function count($data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        $this->db->group_by('batches.id');
        return $this->db->get()->num_rows();
    }

    public function get_batches_with_date($date)
    {
        return $this->db->get_where($this->table, array('producing_date' => $date))->num_rows();
    }

    public function get_batch_belong_to_type_label($type_id)
    {
        if ($type_id != 0) $this->db->where('type_id', $type_id);
        return $this->db->get($this->table)->result();
    }

    public function search($data)
    {
        $this->db->group_start();
        if (is_numeric($data)) $this->db->where('batches.subtype_id', $data);
        else
        {
            $this->db->like('quantity', $data);
            $this->db->or_like('batches.lot', $data);
            $this->db->or_like('types.name', $data);
        }
        $this->db->group_end();
    }

    function find($id)
    {
        $this->join_to_another_tables();
        $this->db->where('batches.id', $id);
        return $this->db->get()->first_row();
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('batches.is_active', $is_active);
    }

    function insert($batch_data)
    {
        $batch_id = NULL;
        $query = $this->db->insert($this->table, $batch_data);
        $batch_id = $this->db->insert_id();
        return [$query, $batch_id];
    }

    function update($batch_data)
    {
        return $this->db->where('id', $batch_data['id'])->update($this->table, $batch_data);
    }

    function delete($id)
    {
        $this->db->trans_begin();
        $this->load->model('products_model');
        $products = $this->products_model->get_products_of_batch($id);
        $this->db->where('id', $id)->delete($this->table);
        $this->products_model->delete_products_of_batch($id);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->load->library('gallery');
            foreach ($products as $key => $product)
            {
                $this->gallery->image_delete(LINK_TO_SAVE_QRCODE.$product->serial_no. FILENAME_QRCODE1);
                $this->gallery->image_delete(LINK_TO_SAVE_QRCODE.$product->serial_no. FILENAME_QRCODE2);
            }
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
?>