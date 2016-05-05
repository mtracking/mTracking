<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types_model extends CI_Model {

    private $table = 'types';
    private $categories_table = 'categories';
    private $pictures_table = 'pictures';

    public function join_to_another_tables()
    {
        $this->db->select('types.*, categories.name AS category_name, pictures.image_file_name');
        $this->db->from($this->table);
        $this->db->join($this->categories_table, 'categories.id = types.category_id');
        $this->db->join($this->pictures_table, 'types.id = pictures.type_id', 'left');
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
        $this->db->group_by('types.id');
        return $this->db->get()->result();
    }

    public function count($data = NULL, $is_active = NULL)
    {
        $this->join_to_another_tables();
        (!is_null($is_active)) ? $this->is_active($is_active) : $this->is_active();
        if (!is_null($data)) $this->search($data);
        $this->db->group_by('types.id');
        return $this->db->get()->num_rows();
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
        $this->db->group_by('types.id');
        return $this->db->get()->result();
    }

    public function count_types_available($limit = 0, $data = NULL)
    {
        $this->join_to_another_tables();
        $this->is_active();
        $this->is_available();
        $this->search($data);
        $this->db->group_by('types.id');
        return $this->db->get()->num_rows();
    }

    public function belong_to_category($limit = 0, $category_id)
    {
        $this->join_to_another_tables();
        $this->is_active();
        if ($category_id != 0) $this->db->where('category_id', $category_id);
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit, $offset);
        }
        $this->db->group_by('types.id');
        return $this->db->get()->result();
    }

    public function count_types_belong_to_category($category_id)
    {
        $this->join_to_another_tables();
        if ($category_id != 0) $this->db->where('category_id', $category_id);
        $this->is_active();
        $this->db->group_by('types.id');
        return $this->db->get()->num_rows();
    }

    public function is_active($is_active = ACTIVE)
    {
        $this->db->where('types.is_active', $is_active);
    }

    public function is_available()
    {
        $this->db->where('types.is_available', ACTIVE);
    }

    public function search($data)
    {
        $this->db->group_start();
        if (is_numeric($data)) $this->db->where('types.category_id', $data);
        else
        {
            $this->db->or_like('types.name', $data);
            $this->db->or_like('categories.name', $data);
        }
        $this->db->group_end();
    }

    function find($id)
    {
        $this->join_to_another_tables();
        $this->db->where('types.id', $id);
        return $this->db->get()->first_row();
    }

    function pictures($id)
    {
        return $this->db->get_where($this->pictures_table, array('type_id' => $id))->result();
    }

    function insert($type_data, $pictures_data = NULL)
    {

        $this->db->trans_begin();
        $this->db->insert($this->table, $type_data);
        if (!is_null($pictures_data)) $this->insert_pictures($this->db->insert_id(), $pictures_data);
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

    function update($type_data, $pictures_data = NULL)
    {
        $this->db->trans_begin();
        if (!is_null($pictures_data)) $this->insert_pictures($type_data['id'], $pictures_data);
        $this->db->where('id', $type_data['id'])->update($this->table, $type_data);
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