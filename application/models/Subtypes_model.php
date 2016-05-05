<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subtypes_model extends CI_Model {

    private $table = 'subtypes';
    private $categories_table = 'categories';
    private $types_table ='types';

    public function join_to_another_tables()
    {
        $this->db->select('subtypes.*,
            types.category_id, types.id AS type_id,
             categories.name AS category_name, types.name AS type_name');
        $this->db->from($this->table);
        $this->db->join($this->types_table, 'types.id = subtypes.type_id');
        $this->db->join($this->categories_table, 'categories.id = types.category_id');
    }

    public function all($limit = 0, $data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count($data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        return $this->db->get()->num_rows();
    }

    public function belong_to_type($type_id)
    {
        $this->join_to_another_tables();
        $this->is_active();
        $this->db->where('subtypes.type_id', $type_id);
        return $this->db->get()->result();
    }

    public function get_types_available($limit = 0, $data = NULL)
    {
        $this->join_to_another_tables();
        $this->is_active();
        $this->is_available();
        $this->search($data);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_types_available($limit = 0, $data = NULL)
    {
        $this->join_to_another_tables();
        $this->is_active();
        $this->is_available();
        $this->search($data);
        return $this->db->get()->num_rows();
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('subtypes.is_active', $is_active);
    }

    public function search($data)
    {
        $this->db->group_start();
        if (is_numeric($data)) $this->db->where('subtypes.type_id', $data);
        else
        {
            $this->db->like('types.name', $data);
            $this->db->or_like('categories.name', $data);
            $this->db->or_like('subtypes.factory', $data);
        }
        $this->db->group_end();
    }

    function find($id)
    {
        $this->join_to_another_tables();
        $this->db->where('subtypes.id', $id);
        return $this->db->get()->first_row();
    }


    function insert($subtype_data)
    {
        return $this->db->insert($this->table, $subtype_data);
    }

    function update($subtype_data)
    {
        return $this->db->where('id', $subtype_data['id'])->update($this->table, $subtype_data);
    }

    public function update_pictures($type_id, $pictures_data)
    {
        $this->db->trans_begin();
        $this->delete_pictures($type_id);
        $this->insert_pictures($type_id, $pictures_data);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_types($list)
    {
        $this->db->where_in('id', $list);
        $query = $this->db->update($this->table, array('is_active' => NOT_ACTIVE));
        // $query = $this->db->delete($this->table);
        return $query;
    }

    public function insert_pictures($id, $pictures_data)
    {
        $datas = array();
        if (!is_null($pictures_data))
        {
            foreach ($pictures_data as $picture)
            {
                $data = array();
                $data['type_id'] = $id;
                $data['image_file_name'] = $picture;
                array_push($datas, $data);
            }
            return $this->db->insert_batch($this->pictures_table, $datas);
        }
    }

    public function delete_pictures($id)
    {
        return $this->db->delete($this->pictures_table, array('type_id' => $id));
    }
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
?>