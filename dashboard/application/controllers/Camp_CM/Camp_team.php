<?php error_reporting(0);

class Camp_team extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamp');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $ucs = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $trackarray = array("action" => "View Camp Team", "activityName" => "Camp Team - staff registration",
            "result" => "View Camp Team page. URL: " . current_url() . " .  Fucntion: Camp_team/index()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
            $MCamp = new MCamp();
            $data['myData'] = $MCamp->getAllDoctors($district, $ucs);
        } else {
            $district = '';
            $data['myData'] = '';
        }

        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;


        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/camp_team', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function addCampDoctor()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['dist_id']) || $_POST['dist_id'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['ucCode']) || $_POST['ucCode'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }
        if (!isset($_POST['staff_name']) || $_POST['staff_name'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();

        }
        if (!isset($_POST['staff_type']) || $_POST['staff_type'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();

        }

        if ($flag == 0) {
            $Custom = new Custom();
            $formArray = array();
            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['ucCode'] = $_POST['ucCode'];
            $formArray['staff_name'] = $_POST['staff_name'];
            $formArray['staff_type'] = $_POST['staff_type'];
            $formArray['colflag'] = 0;
//            $formArray['isActive'] = 1;
            $formArray['createdBy'] = $_SESSION['login']['UserName'];
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($formArray, 'id', 'camp_doctor', 'N');
            if ($InsertData) {
                $result = 1;
            } else {
                $result = 9;
            }
        } else {
            $result = 8;
        }

        $trackarray = array("action" => "Camp Team Add -> Function: addCampTeam() camp team insert ",
            "activityName" => "Add Camp Team",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    public function getDoctorEdit()
    {
        $MCamp = new MCamp();
        $result = $MCamp->getEditCampDoctor($this->input->post('id'));
        echo json_encode($result, true);
    }

    function editData()
    {
        $Custom = new Custom();
        $editArr = array();

        $flag = 0;
        if (!isset($_POST['idDoctor']) || $_POST['idDoctor'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['staff_name']) || $_POST['staff_name'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }
        if (!isset($_POST['staff_type']) || $_POST['staff_type'] == '') {
            $flag = 1;
            $result = 6;
            echo $result;
            exit();
        }
        if (isset($_POST['idDoctor']) && $_POST['idDoctor'] != '' && $flag == 0) {
            $idDoctor = $_POST['idDoctor'];
            $editArr['staff_name'] = $_POST['staff_name'];
            $editArr['staff_type'] = $_POST['staff_type'];
            $editArr['updateBy'] = $_SESSION['login']['UserName'];
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idDoctor', $idDoctor, 'camp_doctor');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Edit Camp Team -> Function: Camp_team/editData() ",
            "activityName" => "Edit Camp Team",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idDoctor']) && $_POST['idDoctor'] != '') {
            $idDoctor = $_POST['idDoctor'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $_SESSION['login']['idUser'];
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idDoctor', $idDoctor, 'camp_doctor');

            $trackarray = array("action" => "Delete Camp Doctor -> Function: deleteData() ",
                "result" => $editData, "PostData" => $editArr);
            $Custom->trackLogs($trackarray, "user_logs");
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }

        $trackarray = array("action" => "Delete Camp Team -> Function: Camp_team/deleteData() ",
            "activityName" => "Delete Camp Team",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>