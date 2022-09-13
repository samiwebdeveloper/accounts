<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ImageUpload extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->model('ImageUpload');
    }


    public function single_img_upload()
    {
        $this->load->view('upload_single_img');
    }

    public function upload_single_image()
    {
        for ($i = 1; $i <= count($_FILES); $i++) {
            $config = array();
            $config['upload_path'] = 'assets/upload_img/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('upload_file_' . $i)) {
                $data['error'] =  '<div class="  col-md-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button>
                <strong>Alert!: </strong>Upload Correct File Formate. </div>';
                $this->load->view('upload_single_img', $data);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $imgName[$i] = $this->upload->data();
                $img_name = $imgName[$i]['file_name'];
                $data['error'] =  '<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button>
                    <strong>Successfully!: </strong>Records has been saved. </div>';
                $this->load->view('upload_single_img', $data);
            }
        }
    }

    public function multiple_img_upload()
    {
        $this->load->view('upload_multiple_img');
    }
    public function upload_multiple_image()
    {


        for ($i = 0; $i < count($_FILES['img_name']['name']); $i++) {
            $_FILES['file']['name'] = $_FILES['img_name']['name'][$i];
            $_FILES['file']['type'] = $_FILES['img_name']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['img_name']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['img_name']['error'][$i];
            $_FILES['file']['size'] = $_FILES['img_name']['size'][$i];

            $config['upload_path'] = 'assets/upload_img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $data['error'] =  '<div class="  col-md-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button>
                <strong>Alert!: </strong>Upload Correct File Formate. </div>';
            } else {
                $data = array('upload_data' => $this->upload->data());
                $imgName[$i] = $this->upload->data();
                $file = $imgName[$i]['file_name'];
                $data['error'] =  '<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button>
                    <strong>Successfully!: </strong>Records has been saved. </div>';
            }
        }

        $this->load->view('upload_multiple_img', $data);

    }
}
