<?php

class Error_files extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('merror_files');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $district = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $district = $_SESSION['login']['district'];
        }


        $MCustom = new Custom();
        $province = $MCustom->getProvinces($district);
        $data['province'] = $province;

        $province = '';
        $district = '';
        $cluster = '';
        if (isset($_GET['p']) && $_GET['p'] != '') {
            $province = $_GET['p'];
            $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
        }
        if (isset($_GET['c']) && $_GET['c'] != '') {
            $cluster = $_GET['c'];
        }

        $data['slug_province'] = $province;
        $data['slug_district'] = $district;
        $data['slug_cluster'] = $cluster;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('error_files', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }


    function searchData()
    {
        $MError_files = new MError_files();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $MError_files->getError_Files($district);
        echo json_encode($data, true);
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id = $_POST['id'];
            $editArr['isActive'] = 0;
            $editData = $Custom->Edit($editArr, 'id', $id, 'error_files');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        echo $result;
    }

    function uploadFile()
    {
        if (!isset($_POST['district']) || $_POST['district'] == '') {
            $result = array('0' => 'Error', '1' => 'Invalid District');
        } else {
            $config['upload_path'] = 'assets/uploads/error_files/';
            $config['allowed_types'] = 'gif|jpg|png|html|xls|xlsx|pdf|csv';
            $config['max_size'] = '10000000';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('document_file')) {
                $data = array('document_file' => $this->upload->data());

                $dist = $_POST['district'];
                $file_name = $data['document_file']['file_name'];
                $Custom = new Custom();
                $formArray = array();
                $formArray['dist_id'] = $dist;
                $formArray['file_name'] = $file_name;
                $formArray['createdBy'] = $_SESSION['login']['UserName'];
                $formArray['createdDateTime'] = date('Y-m-d H:m:s');
                $formArray['isActive'] = 1;
                $InsertData = $Custom->Insert($formArray, 'id', 'error_files', 'N');
                if ($InsertData) {
                    $result = array('0' => 'Success', '1' => 'Successfully Uploaded');
                } else {
                    $result = array('0' => 'Error', '1' => 'File Uploaded but data not inserted');
                }
            } else {
                $result = array('0' => 'Error', '1' => 'Error in Uploading File');
            }
        }

        echo json_encode($result);
    }

}

?>