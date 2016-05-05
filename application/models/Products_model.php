<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    private $table = 'products';
    private $batches_table = 'batches';
    private $types_table = 'types';
    private $subtypes_table = 'subtypes';
    private $categories_table = 'categories';
    private $status_product_table = 'status_product';
    private $pictures_table = 'pictures';
    private $users_table = 'users';

    public function join_another_tables()
    {
        $this->db->select('products.*, batches.lot AS batch_lot, batches.producing_date, batches.expiry_date,
                            types.id AS type_id, types.name AS type_name, types.characteristics, types.storage_temp, types.sourcing, types.price, types.country,
                            subtypes.id AS subtype_id, subtypes.producing_year, subtypes.factory,
                            categories.name AS category_name,
                            status_product.name AS status_product_name, status_product.id AS status_product_id,
                            pictures.image_file_name,
                            users.email');
        $this->db->from($this->table);
        $this->db->join($this->status_product_table, 'products.status_product = status_product.id');
        $this->db->join($this->batches_table, 'products.batch_id = batches.id');
        $this->db->join($this->subtypes_table, 'batches.subtype_id = subtypes.id');
        $this->db->join($this->types_table, 'subtypes.type_id = types.id');
        $this->db->join($this->pictures_table, 'pictures.type_id = types.id','left');
        $this->db->join($this->categories_table, 'types.category_id = categories.id');
        $this->db->join($this->users_table, 'products.user_id = users.id', 'left');
    }

    public function order_products()
    {
        $this->db->order_by('batches.id', 'desc');
        $this->db->order_by('products.status_product', 'desc');
    }

    public function where_products($data)
    {
        if (!is_null($data['serial_no']) && $data['serial_no'] != 0)
        {
            $this->db->like('products.serial_no', $data['serial_no']);
        }
        else
        {
            if (!is_null($data['batch_id']) && $data['batch_id'] != 0)
            {
                $this->db->where('batches.id', $data['batch_id']);
            }
            if (!is_null($data['category_id']) && $data['category_id'] != 0)
            {
                $this->db->where('categories.id', $data['category_id']);
            }
            if (!is_null($data['type_id']) && $data['type_id'] != 0)
            {
                $this->db->where('types.id', $data['type_id']);
            }
            if (!is_null($data['subtype_id']) && $data['subtype_id'] != 0)
            {
                $this->db->where('subtypes.id', $data['subtype_id']);
            }
        }
    }

    public function buy_from_user($limit = 0, $user_id)
    {
        $result = array();
        if (!is_null($user_id))
        {
            $this->join_another_tables();
            $this->db->where('products.user_id', $user_id);
            $this->db->group_by('products.id');
            if($limit > 0)
            {
                $offset = $this->uri->segment(3);
                $this->db->limit($limit,$offset);
            }
            $this->db->order_by('products.updated_at', 'desc');
            $result = $this->db->get()->result();
        }
        return $result;
    }

    public function count_buy_from_user($user_id)
    {
        $result = 0;
        if (!is_null($user_id))
        {
            $this->join_another_tables();
            $this->db->where('products.user_id', $user_id);
            $this->db->group_by('products.id');
            $result = $this->db->get()->num_rows();
        }
        return $result;
    }

    public function all($limit = 0, $data = NULL)
    {
        $this->join_another_tables();
        $this->where_products($data);
        $this->order_products();
        $this->db->group_by('products.id');
        if($limit > 0)
        {
            $offset = $this->uri->segment(3);
            $this->db->limit($limit,$offset);
        }
        return $this->db->get()->result();
    }

    public function count($data)
    {
        $this->join_another_tables();
        $this->where_products($data);
        $this->db->group_by('products.id');
        return $this->db->get()->num_rows();
    }

    public function insert($products)
    {
        return $this->db->insert_batch($this->table, $products);
    }

    function find($serial_no)
    {
        $this->join_another_tables();
        $this->db->where('products.serial_no', $serial_no);
        $query = $this->db->get();
        return $query->first_row();
    }

    function confirm_products($serial_no, $serial_active)
    {
        $this->join_another_tables();
        $this->db->where('products.serial_no', $serial_no);
        $this->db->where('products.serial_active', $serial_active);
        $query = $this->db->get();
        return $query->first_row();
    }

    /*Huck's code*/
    public function update_product_location($serial_no, $location, $product_status = NULL)
    {
        $new_location['latitude'] = $location['lat'];
        $new_location['longitude'] = $location['lon'];
        $new_location['area'] = $location['country'] .' - ' . $location['city'];
        $new_location['time'] = date('Y-m-d H:i:s');

        $check_last_location = $this->check_last_location($serial_no, $new_location);
        if ($product_status) {
            $query = $this->update_location($serial_no, $new_location, $product_status);
            return $query;
        }
        if ($check_last_location)
        {
            $query = $this->update_location($serial_no, $new_location);
            return $query;
        }
    }

    private function update_location($serial_no, $new_location, $product_status = NULL)
    {
        $product = $this->find($serial_no);

        $product->location = $this->add_location($product->location, $new_location);
        if ( $product_status )
        {
            $product->status_product = $product_status;
        }

        $this->db->where('serial_no', $serial_no);
        $data = array(
            'location' => $product->location,
            'status_product' => $product_status,
            'updated_at' => date('Y:m:d H:i:s'));
        return $this->db->update($this->table, $data);
    }

    private function add_location($old_location, $new_location)
    {
        $location_arr = json_decode($old_location);
        $location_arr = ($location_arr) ? $location_arr : [];
        array_push($location_arr, $new_location);
        return json_encode($location_arr);
    }

    private function check_last_location($serial_no, $location)
    {
        $this->db->where('serial_no', $serial_no);
        $query = $this->db->get($this->table);
        $product = $query->first_row();

        if ($product->location)
        {
            $location_raw = json_decode($product->location);
            $last_product_locations = end($location_raw);

            if ( (strcmp($last_product_locations->longitude, $location['longitude']) <> 0 ) OR
                (strcmp($last_product_locations->latitude, $location['latitude']) <> 0 ) )
            {
                return TRUE;
            }
        }
        else
        {
            return TRUE;
        }
        return FALSE;
    }

    public function update_user($serial_no, $user_id)
    {
        $product = $this->find($serial_no);
        return (is_null($product->user_id)) ? $this->db->where('serial_no', $serial_no)->update($this->table, array('user_id' => $user_id)) : FALSE;
    }

    public function delete_products_of_batch($batch_id)
    {
        $this->db->where('batch_id', $batch_id)->delete($this->table);
    }

    public function get_products_of_batch($batch_id)
    {
        $this->join_another_tables();
        $this->db->where('products.batch_id', $batch_id);
        return $this->db->get()->result();
    }
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
?>