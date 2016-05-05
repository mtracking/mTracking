<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery {
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    public function image_upload($dir)
    {
        $upload_dir = APPPATH. $dir;
        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'gif|jpg|png',
            'max_size' => '100000');
        $this->CI->load->library('upload', $config);
        if (!$this->CI->upload->do_upload('file'))
        {
            $errors = $this->upload->display_errors();
            return [FALSE, $errors];
        }
        $image_data =  $this->CI->upload->data();
        chmod($image_data['full_path'], 0777);
        return [TRUE, $image_data];
    }

    public function resize_image($image_data, $width, $height)
    {
        $image_config = array(
            'image_library' => 'gd2',
            "source_image" => $image_data['full_path'],
            "new_image" => $image_data['file_path'],
            "maintain_ratio" => TRUE);
        // Resize image
        $image_config['width'] = $width;
        $image_config['height'] = $height;
        $dim = (intval($image_data["image_width"]) / intval($image_data["image_height"])) - ($image_config['width'] / $image_config['height']);
        $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
        $this->CI->load->library("image_lib");
        $this->CI->image_lib->initialize($image_config);
        if (!$this->CI->image_lib->resize())
        {
            $errors = $this->image_lib->display_errors();
            return [FALSE, $errors];
        }
        chmod($image_data['full_path'], 0777);
        return [TRUE, NULL];
    }

    public function image_delete($dir)
    {
        if (file_exists(APPPATH. $dir)) return unlink(APPPATH. $dir);
        return FALSE;
    }

    function is_url_exist($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0],"200 OK") ? TRUE : FALSE;
    }
}
?>