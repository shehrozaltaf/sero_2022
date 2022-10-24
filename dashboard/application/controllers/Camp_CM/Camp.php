<?php error_reporting(0);

class Camp extends CI_controller
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
        $Custom = new Custom();
        $trackarray = array("action" => "View Camp", "activityName" => "Camp Main",
            "result" => "View Camp Main page. URL: " . current_url() . " .  Fucntion: Camp/index()");
        $Custom->trackLogs($trackarray, "user_logs");

        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $ucs = '';
        $area = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
            $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
        } else {
            $district = '0';
        }
        if (isset($_GET['s']) && $_GET['s'] != '') {
            $status = $_GET['s'];
        } else {
            $status = '';
        }
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;

        $MCamp = new MCamp();
        $getAllCamps = $MCamp->getAllCamps($district, $ucs, $area, $status);
        $myData = array();
        if (isset($getAllCamps) && $getAllCamps != '') {
            foreach ($getAllCamps as $k => $v) {
                $myData[$v->id]['id'] = $v->id;
                $myData[$v->id]['district'] = $v->district;
                $myData[$v->id]['ucName'] = $v->ucName;
                $myData[$v->id]['area_no'] = $v->area_no;
                $myData[$v->id]['area_name'] = $v->area_name;
                $myData[$v->id]['plan_date'] = date('Y-m-d', strtotime($v->plan_date));
                $myData[$v->id]['camp_no'] = $v->camp_no;
                $myData[$v->id]['execution_date'] = (isset($v->execution_date) && $v->execution_date != '' ? date('Y-m-d', strtotime($v->execution_date)) : '');
                $myData[$v->id]['execution_duration'] = (isset($v->execution_duration) && $v->execution_duration != '' ? $v->execution_duration : '');
                $myData[$v->id]['camp_status'] = $v->camp_status;
                $myData[$v->id]['remarks'] = $v->remarks;
                $myData[$v->id]['locked'] = $v->locked;
                $getDr = $MCamp->getDrByCamp($v->id);
                $myDr = '';
                if (isset($getDr) && $getDr != '') {
                    foreach ($getDr as $kd => $d) {
                        if ($kd == 0) {
                            $myDr .= $d->staff_name . '<small> (' . $d->staff_type . ')</small>';
                        } else {
                            $myDr .= ', ' . $d->staff_name . '<small> (' . $d->staff_type . ')</small>';
                        }

                    }
                }
                $myData[$v->id]['doctors'] = $myDr;
            }
        }
        $data['myData'] = $myData;
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/camp', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function getCampDetail()
    {
        if (!isset($_POST['district']) || $_POST['district'] == '') {
            $result = 2;
        } elseif (!isset($_POST['ucs']) || $_POST['ucs'] == '') {
            $result = 3;
        } elseif (!isset($_POST['area']) || $_POST['area'] == '') {
            $result = 8;
        } else {
            $MCamp = new MCamp();
            $district = (isset($_POST['district']) && $_POST['district'] != '' && $_POST['district'] != 0 ? $_POST['district'] : 0);
            $ucs = (isset($_POST['uc']) && $_POST['uc'] != '' && $_POST['uc'] != 0 ? $_POST['uc'] : 0);
            $area = (isset($_POST['area']) && $_POST['area'] != '' && $_POST['area'] != 0 ? $_POST['area'] : 0);
            $result = $MCamp->getCampDetails($district, $ucs, $area);
        }
        echo json_encode($result, true);
    }

    function getMaxCampNo()
    {
        $MCamp = new MCamp();
        $area = (isset($_REQUEST['area']) && $_REQUEST['area'] != '' && $_REQUEST['area'] != 0 ? $_REQUEST['area'] : 0);
        $data = $MCamp->getMaxCamp($area);
        if (isset($data[0]->maxCamp) && $data[0]->maxCamp != '') {
            $exp = explode('-', $data[0]->maxCamp);
            if (isset($exp[2]) && $exp[2] != '') {
                $max = $exp[2];
            } else {
                $max = 0;
            }
        } else {
            $max = 0;
        }
        echo $max;
    }

    function getClustersByUCs()
    {
        $MCamp = new Custom();
        $ucs = (isset($_REQUEST['uc']) && $_REQUEST['uc'] != '' && $_REQUEST['uc'] != 0 ? $_REQUEST['uc'] : 0);
        $data = $MCamp->getClustersByUC($ucs);
        echo json_encode($data, true);
    }

    function getDoctorsByUcs()
    {
        $MCamp = new MCamp();
        $ucs = (isset($_REQUEST['ucs']) && $_REQUEST['ucs'] != '' && $_REQUEST['ucs'] != 0 ? $_REQUEST['ucs'] : 0);
        $type = 0;
        $data = $MCamp->getDrByUc($ucs, $type);
        echo json_encode($data, true);
    }

    function getAreaByUCs()
    {
        $MCamp = new MCamp();
        $ucs = (isset($_REQUEST['uc']) && $_REQUEST['uc'] != '' && $_REQUEST['uc'] != 0 ? $_REQUEST['uc'] : 0);
        $filter = (isset($_REQUEST['filter']) && $_REQUEST['filter'] != '' && $_REQUEST['filter'] != 0 ? $_REQUEST['filter'] : 0);
        $data = $MCamp->getAreasByUc($ucs, $filter);
        echo json_encode($data, true);
    }

    function addCamp()
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
        if (!isset($_POST['area']) || $_POST['area'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();
        }
        if (!isset($_POST['camp_rounds']) || $_POST['camp_rounds'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }

        if (!isset($_POST['camps']) || $_POST['camps'] == '') {
            $flag = 1;
            $result = 6;
            echo $result;
            exit();
        }


        $MCamp = new MCamp();
        $area = $_POST['area'];
        $data = $MCamp->getMaxCamp($area);
        if (isset($data[0]->maxCamp) && $data[0]->maxCamp != '') {
            $exp = explode('-', $data[0]->maxCamp);
            if (isset($exp[2]) && $exp[2] != '') {
                $max = $exp[2];
            } else {
                $max = 0;
            }
        } else {
            $max = 0;
        }

        if ($max > ($_POST['camp_rounds'] + $max)) {
            $flag = 1;
            $result = 8;
            echo $result;
            exit();
        }

        if ($flag == 0) {
            $Custom = new Custom();
            $formArray = array();
            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['ucCode'] = $_POST['ucCode'];
            $formArray['area_no'] = $_POST['area'];
            $formArray['total_round'] = $_POST['camp_rounds'];

            $formArray['camp_status'] = 'Planned';
            $formArray['locked'] = 0;
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $_SESSION['login']['UserName'];
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            foreach ($_POST['camps'] as $k => $c) {
                if (isset($c['camp']) && $c['camp'] != '') {
                    $formArray['camp_no'] = $c['camp'];
                }
                if (isset($c['rounds']) && $c['rounds'] != '') {
                    $formArray['camp_round'] = $c['rounds'];
                }
                if (isset($c['plandate']) && $c['plandate'] != '') {
                    $formArray['plan_date'] = date('Y-m-d', strtotime($c['plandate']));
                }

                $InsertData = $Custom->Insert($formArray, 'id', 'camp', 'Y');
                if ($InsertData) {
                    $formArray_other = array();
                    $formArray_other['idCamp'] = $InsertData;
                    $formArray_other['camp_no'] = $c['camp'];
                    $formArray_other['dist_id'] = $formArray['dist_id'];
                    $formArray_other['ucCode'] = $formArray['ucCode'];
                    $formArray_other['area_no'] = $formArray['area_no'];
                    $formArray_other['colflag'] = 0;
                    $formArray_other['createdBy'] = $_SESSION['login']['UserName'];
                    $formArray_other['createdDateTime'] = date('Y-m-d H:i:s');
                    foreach ($c['camp_doctors'] as $d) {
                        $formArray_other['idDoctor'] = $d;
                        $InsertData_other = $Custom->Insert($formArray_other, 'idCampDetail', 'camp_detail', 'N');
                    }
                    if ($InsertData_other) {
                        $result = 1;
                    } else {
                        $result = 11;
                    }
                } else {
                    $result = 10;
                }
            }

        } else {
            $result = 9;
        }
        $trackarray = array("action" => "Camp Add -> Function: addCamp() camp insert ",
            "activityName" => "Add Camp",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    function editData()
    {
        $Custom = new Custom();
        $editArr = array();
        $flag = 0;
        if (!isset($_POST['idCamp']) || $_POST['idCamp'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['camp_status']) || $_POST['camp_status'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }
        if ((!isset($_POST['execution_date']) || $_POST['execution_date'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 8;
            echo $result;
            exit();

        }
        if ((!isset($_POST['execution_duration']) || $_POST['execution_duration'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 9;
            echo $result;
            exit();

        }
        if ((!isset($_POST['remarks']) || $_POST['remarks'] == '') && $_POST['camp_status'] == 'Canceled') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();

        }

        if (isset($_POST['idCamp']) && $_POST['idCamp'] != '' && $flag == 0) {
            $idCamp = $_POST['idCamp'];
            $editArr['camp_status'] = $_POST['camp_status'];
            /* $editArr['participants_no'] = $_POST['participant_no'];
             $editArr['refuses_no'] = $_POST['refuses_no'];*/
            $editArr['execution_date'] = date('Y-m-d', strtotime($_POST['execution_date']));
            $editArr['execution_duration'] = $_POST['execution_duration'];
            $editArr['remarks'] = $_POST['remarks'];
            $editArr['updateBy'] = $_SESSION['login']['UserName'];
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCamp, 'camp');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }

        $trackarray = array("action" => "Edit Camp setting -> Function: editData() ",
            "activityName" => "Edit Camp",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idCamp']) && $_POST['idCamp'] != '') {
            $idCamp = $_POST['idCamp'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $_SESSION['login']['idUser'];
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCamp, 'camp');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }

        $trackarray = array("action" => "Delete Camp -> Function: deleteData() ",
            "activityName" => "Delete Camp",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    function lockData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idCamp']) && $_POST['idCamp'] != '') {
            $idCamp = $_POST['idCamp'];
            $editArr['locked'] = 1;
            $editArr['lockedBy'] = $_SESSION['login']['UserName'];
            $editArr['lockedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCamp, 'camp');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Lock Camp setting -> Function: lockData() ",
            "activityName" => "Lock Camp",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    function unlockData()
    {
        $Custom = new Custom();
        $editArr = array();
        if ($_SESSION['login']['idUser'] == 1 && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            if (isset($_POST['idCamp']) && $_POST['idCamp'] != '') {
                $idCamp = $_POST['idCamp'];
                $editArr['locked'] = 0;
                $editData = $Custom->Edit($editArr, 'id', $idCamp, 'camp');
                if ($editData) {
                    $result = 1;
                } else {
                    $result = 2;
                }
            } else {
                $result = 3;
            }
        } else {
            $result = 4;
        }

        $trackarray = array("action" => "Lock Camp setting -> Function: lockData() ",
            "activityName" => "Lock Camp",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>