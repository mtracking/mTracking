<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Readfile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function read_country()
    {
        ini_set('memory_limit', '-1');
        $file = fopen(APPPATH.LINK_TO_SAVE_USERS_IMAGE.'GeoLite2-Country-Locations-de.csv',"r");
        $countries = array();
        while(! feof($file))
        {
            $item = array();
            $item = fgetcsv($file);
            $country = array(
                'geoname_id' => $item[0],
                'locale_code' => $item[1],
                'continent_code' => $item[2],
                'continent_name' => $item[3],
                'country_iso_code' => $item[4],
                'country_name' => $item[5]);
            array_push($countries, $country);
        }
        fclose($file);
        // var_dump($countries);
        $this->db->insert_batch('countries', $countries);
    }

    function read_city()
    {
        ini_set('memory_limit', '-1');
        $file = fopen(APPPATH.LINK_TO_SAVE_USERS_IMAGE.'GeoLite2-City-Locations-en.csv',"r");
        $cities = array();
        while(! feof($file))
        {
            $item = array();
            $item = fgetcsv($file);
            $city = array(
                'geoname_id' => $item[0],
                'country_iso_code' => $item[4],
                'subdivision_1_iso_code' => $item[6],
                'subdivision_1_name' => $item[7],
                'subdivision_2_iso_code' => $item[8],
                'subdivision_2_name' => $item[9],
                'city_name' => $item[10])
                ;
            array_push($cities, $city);
        }
        fclose($file);
        // var_dump($cities);
        $this->db->insert_batch('cities', $cities);
    }

}

/* End of file Base_Controller.php */
/* Location: ./application/controllers/Base_Controller.php */
?>