<?php error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');

class Upload_data extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }


    function index()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View Upload Data",
            "result" => "View Upload Data page. Fucntion: Upload_data/index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'upload_data');

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('upload_data', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    public function addExcelData()
    {
        $config['upload_path'] = 'assets/uploads/excelsUpload';
        $config['allowed_types'] = 'xlsx|xlx|csv';
        $this->load->library('upload', $config);
        $data = array();
        if (!$this->upload->do_upload('document_file')) {
            /* $error = array('Error' => $this->upload->display_errors());
             print_r($error);*/
            $data = array('0' => 'Error', '1' => $this->upload->display_errors());
        } else {
            if (!$this->upload->do_upload('userfile')) {
                $error = array('Error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (isset($_POST['idTable']) && $_POST['idTable'] != '' && $_POST['idTable'] != '0') {
                $table = $_POST['idTable'];
                $data = array('document_file' => $this->upload->data());
                $file = 'assets/uploads/excelsUpload/' . $data['document_file']['file_name'];
                if (file_exists($file)) {
                    $this->load->library('excel');
                    $objPHPExcel = PHPExcel_IOFactory::load($file);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row == 1) {
                            $header[$row][$column] = $data_value;
                        } else {
                            $arr_data[$row][$column] = $data_value;
                        }
                    }
                    $myarr = array();
                    foreach ($arr_data as $k => $l) {
                        $c = array();
                        foreach ($header[1] as $h => $v) {
                            $c[$v] = $l[$h];
                        }
                        $myarr[] = $c;
                    }
                    if ($this->db->insert_batch($table, $myarr)) {
                        $data = array('0' => 'Success', '1' => 'Successfully Uploaded');
                    } else {
                        $data = array('0' => 'Error', '1' => $this->db->error());
                    }
                } else {
                    $data = array('0' => 'Error', '1' => 'Error while uploading file');
                }
            } else {
                $data = array('0' => 'Error', '1' => 'Please select table');
            }

        }
        echo json_encode($data);
    }


}

?>