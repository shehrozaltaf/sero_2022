<?php
//error_reporting(0);

class Community_mobilization extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamp');
        $this->load->model('mcommunity_mobilization');
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
        $trackarray = array("action" => "View Community_mobilization", "activityName" => "Community Mobilization Main",
            "result" => "View Community Mobilization Main page. URL: " . current_url() . " .  Fucntion: Community_mobilization/index()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
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

        $MCommunity_mobilization = new MCommunity_mobilization();
        $getAllCommunity_mobilizations = $MCommunity_mobilization->getAllCommunity_mobilizations($district, $ucs,$status);
        $myData = array();
        if (isset($getAllCommunity_mobilizations) && $getAllCommunity_mobilizations != '') {
            foreach ($getAllCommunity_mobilizations as $k => $v) {
                $myData[$v->id]['id'] = $v->id;
                $myData[$v->id]['district'] = $v->district;
                $myData[$v->id]['ucName'] = $v->ucName;
                $myData[$v->id]['plan_date'] = date('Y-m-d', strtotime($v->plan_date));
                $myData[$v->id]['execution_date'] = (isset($v->execution_date) && $v->execution_date != '' ? date('Y-m-d', strtotime($v->execution_date)) : '');
                $myData[$v->id]['area_name'] = (isset($v->area_name) && $v->area_name != '' ? $v->area_name : '');
                $myData[$v->id]['participant_gender_type'] = (isset($v->participant_gender_type) && $v->participant_gender_type != '' ? $v->participant_gender_type : '');
                $myData[$v->id]['session_type'] = (isset($v->session_type) && $v->session_type != '' ? $v->session_type : '');
                $myData[$v->id]['session_topic'] = (isset($v->session_topic) && $v->session_topic != '' ? $v->session_topic : '');
                $myData[$v->id]['venue'] = (isset($v->venue) && $v->venue != '' ? $v->venue : '');
                $myData[$v->id]['session_no'] = $v->session_no;
                $myData[$v->id]['camp_status'] = $v->camp_status;
                $myData[$v->id]['remarks'] = $v->remarks;
                $myData[$v->id]['locked'] = $v->locked;
                $myDr = '';
                $getDr = $MCommunity_mobilization->getMobByCamp($v->id);
                if (isset($getDr) && $getDr != '') {
                    foreach ($getDr as $kd => $d) {
                        if ($kd == 0) {
                            $myDr .= $d->staff_name . '<small>(' . $d->staff_type . ')</small>';
                        } else {
                            $myDr .= ', ' . $d->staff_name . '<small>(' . $d->staff_type . ')</small>';
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
        $this->load->view('camp_cm/community_mobilization', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function getCM_Detail()
    {
        if (!isset($_POST['district']) || $_POST['district'] == '') {
            $result = 2;
        } elseif (!isset($_POST['ucs']) || $_POST['ucs'] == '') {
            $result = 3;
        } else {
            $MCommunity_mobilization = new MCommunity_mobilization();
            $district = (isset($_POST['district']) && $_POST['district'] != '' && $_POST['district'] != 0 ? $_POST['district'] : 0);
            $ucs = (isset($_POST['uc']) && $_POST['uc'] != '' && $_POST['uc'] != 0 ? $_POST['uc'] : 0);
            $res = $MCommunity_mobilization->getCMDetails($district, $ucs);
            if (isset($res) && $res != '' && count($res) >= 1) {
                $result = 5;
            } else {
                $result = 1;
            }
        }
        $result = 1;
        echo $result;
    }

    function getMaxCM()
    {
        $MCommunity_mobilization = new MCommunity_mobilization();
        $district = (isset($_POST['district']) && $_POST['district'] != '' && $_POST['district'] != 0 ? $_POST['district'] : 0);
        $ucs = (isset($_POST['ucs']) && $_POST['ucs'] != '' && $_POST['ucs'] != 0 ? $_POST['ucs'] : 0);
        $data = $MCommunity_mobilization->getMaxCommunity_mobilization($district, $ucs);

        if (isset($data[0]->maxCM) && $data[0]->maxCM != '') {
            $max = $data[0]->maxCM + 2;
        } else {
            $max = ($ucs * 10000) + 1;
        }
        echo $max;
    }

    function addCM()
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

        if (!isset($_POST['session_no']) || $_POST['session_no'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }

        if (!isset($_POST['participant_gender_type']) || $_POST['participant_gender_type'] == '') {
            $flag = 1;
            $result = 8;
            echo $result;
            exit();
        }
        if (!isset($_POST['session_type']) || $_POST['session_type'] == '') {
            $flag = 1;
            $result = 6;
            echo $result;
            exit();
        }


        if ((!isset($_POST['session_type_other']) || $_POST['session_type_other'] == '') && $_POST['session_type'] == 'Other') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();
        }

        if (!isset($_POST['plan_date']) || $_POST['plan_date'] == '') {
            $flag = 1;
            $result = 7;
            echo $result;
            exit();
        }

        if ($flag == 0) {
            $MCommunity_mobilization = new MCommunity_mobilization();
            $Custom = new Custom();
            $formArray = array();
            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['ucCode'] = $_POST['ucCode'];
            $formArray['area'] = $_POST['area'];
            $formArray['plan_date'] = date('Y-m-d', strtotime($_POST['plan_date']));
            $formArray['participant_gender_type'] = $_POST['participant_gender_type'];
            $formArray['session_type'] = $_POST['session_type'];
            $formArray['session_type_other'] = $_POST['session_type_other'];
            $formArray['camp_status'] = 'Planned';
            $formArray['locked'] = 0;
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $_SESSION['login']['UserName'];
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $data = $MCommunity_mobilization->getMaxCommunity_mobilization($formArray['dist_id'], $formArray['ucCode']);
            if (isset($data[0]->maxCM) && $data[0]->maxCM != '') {
                $max = $data[0]->maxCM + 1;
                $formArray['session_no'] = $max;
            } else {
                $max = 1;
                $formArray['session_no'] = $formArray['ucCode'] * 10000 + $max;
            }
            $InsertData = $Custom->Insert($formArray, 'id', 'Community_mobilization', 'Y');
            if ($InsertData) {
                $result = 1;
            } else {
                $result = 8;
            }
            $trackarray = array("action" => "Community_mobilization Add -> Function: addCommunity_mobilization() Community_mobilization insert ",
                "activityName" => "Add Community_mobilization",
                "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 9;
        }

        $trackarray = array("action" => "Community_mobilization Add -> Function: addCommunity_mobilization() Community_mobilization insert ",
            "activityName" => "Add Community_mobilization",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");


        echo $result;
    }

    function editData()
    {
        $Custom = new Custom();
        $editArr = array();
        $flag = 0;
        if (!isset($_POST['idCommunity_mobilization']) || $_POST['idCommunity_mobilization'] == '') {
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
            $result = 4;
            echo $result;
            exit();
        }
        if ((!isset($_POST['remarks']) || $_POST['remarks'] == '') && $_POST['camp_status'] == 'Canceled') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }
        if ((!isset($_POST['Mobilizer']) || $_POST['Mobilizer'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 6;
            echo $result;
            exit();
        }
        if ((!isset($_POST['venue']) || $_POST['venue'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 7;
            echo $result;
            exit();
        }
        if ((!isset($_POST['session_topic']) || $_POST['session_topic'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 8;
            echo $result;
            exit();
        }
        if ((!isset($_POST['total_male']) || $_POST['total_male'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 9;
            echo $result;
            exit();
        }
        if ((!isset($_POST['total_female']) || $_POST['total_female'] == '') && $_POST['camp_status'] == 'Conducted') {
            $flag = 1;
            $result = 10;
            echo $result;
            exit();
        }

        if (isset($_POST['idCommunity_mobilization']) && $_POST['idCommunity_mobilization'] != '' && $flag == 0) {
            $idCommunity_mobilization = $_POST['idCommunity_mobilization'];
            $editArr['camp_status'] = $_POST['camp_status'];
            $editArr['remarks'] = $_POST['remarks'];
            if ($editArr['camp_status'] == 'Conducted') {
                $editArr['execution_date'] = date('Y-m-d', strtotime($_POST['execution_date']));
                $editArr['venue'] = $_POST['venue'];
                $editArr['venue_other'] = $_POST['venue_other'];
                $ses = '';
                foreach ($_POST['session_topic'] as $k_sess_topic => $v_sess_topic) {
                    if ($k_sess_topic >= 1) {
                        $ses .= ' | ' . $v_sess_topic;
                    } else {
                        $ses .= $v_sess_topic;
                    }
                }
                $editArr['session_topic'] = $ses;
                $editArr['session_topic_other'] = $_POST['session_topic_other'];
                $editArr['total_male'] = (isset($_POST['total_male']) && $_POST['total_male'] != '' ? (int)$_POST['total_male'] : '');
                $editArr['total_female'] = (isset($_POST['total_female']) && $_POST['total_female'] != '' ? (int)$_POST['total_female'] : '');
                $editArr['political_com_leaders'] = (isset($_POST['political_com_leaders']) && $_POST['political_com_leaders'] != '' ? (int)$_POST['political_com_leaders'] : '');
                $editArr['religious_com_leaders'] = (isset($_POST['religious_com_leaders']) && $_POST['religious_com_leaders'] != '' ? (int)$_POST['religious_com_leaders'] : '');
                $editArr['educational_com_leaders'] = (isset($_POST['educational_com_leaders']) && $_POST['educational_com_leaders'] != '' ? (int)$_POST['educational_com_leaders'] : '');
                $editArr['businessman_com_leaders'] = (isset($_POST['businessman_com_leaders']) && $_POST['businessman_com_leaders'] != '' ? (int)$_POST['businessman_com_leaders'] : '');
                $editArr['other_com_leaders'] = (isset($_POST['other_com_leaders']) && $_POST['other_com_leaders'] != '' ? (int)$_POST['other_com_leaders'] : '');
                $editArr['doctors_health_provider'] = (isset($_POST['doctors_health_provider']) && $_POST['doctors_health_provider'] != '' ? (int)$_POST['doctors_health_provider'] : '');
                $editArr['paramedics_health_provider'] = (isset($_POST['paramedics_health_provider']) && $_POST['paramedics_health_provider'] != '' ? (int)$_POST['paramedics_health_provider'] : '');
                $editArr['lhws_health_provider'] = (isset($_POST['lhws_health_provider']) && $_POST['lhws_health_provider'] != '' ? (int)$_POST['lhws_health_provider'] : '');
                $editArr['lhvs_health_provider'] = (isset($_POST['lhvs_health_provider']) && $_POST['lhvs_health_provider'] != '' ? (int)$_POST['lhvs_health_provider'] : '');
                $editArr['cmws_health_provider'] = (isset($_POST['cmws_health_provider']) && $_POST['cmws_health_provider'] != '' ? (int)$_POST['cmws_health_provider'] : '');
                $editArr['vaccinators_health_provider'] = (isset($_POST['vaccinators_health_provider']) && $_POST['vaccinators_health_provider'] != '' ? (int)$_POST['vaccinators_health_provider'] : '');
                $editArr['other_health_provider'] = (isset($_POST['other_health_provider']) && $_POST['other_health_provider'] != '' ? (int)$_POST['other_health_provider'] : '');
                $editArr['fcv_government_officials'] = (isset($_POST['fcv_government_officials']) && $_POST['fcv_government_officials'] != '' ? (int)$_POST['fcv_government_officials'] : '');
                $editArr['ucpw_government_officials'] = (isset($_POST['ucpw_government_officials']) && $_POST['ucpw_government_officials'] != '' ? (int)$_POST['ucpw_government_officials'] : '');
                $editArr['ttsp_government_officials'] = (isset($_POST['ttsp_government_officials']) && $_POST['ttsp_government_officials'] != '' ? (int)$_POST['ttsp_government_officials'] : '');
                $editArr['other_government_officials'] = (isset($_POST['other_government_officials']) && $_POST['other_government_officials'] != '' ? (int)$_POST['other_government_officials'] : '');
                $editArr['other_participants'] = (isset($_POST['other_participants']) && $_POST['other_participants'] != '' ? (int)$_POST['other_participants'] : '');

            }
            $editArr['updateBy'] = $_SESSION['login']['UserName'];
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCommunity_mobilization, 'community_mobilization');
            if ($editArr) {
                $result = 1;
                if (isset($_POST['Mobilizer']) && $_POST['Mobilizer'] != '') {
                    $formArray_other = array();
                    $formArray_other['idCM'] = $idCommunity_mobilization;
                    $formArray_other['session_no'] = $_POST['session_no'];
                    $formArray_other['dist_id'] = $_POST['dist_id'];
                    $formArray_other['ucCode'] = $_POST['ucCode'];
                    $formArray_other['colflag'] = 0;
                    $formArray_other['createdBy'] = $_SESSION['login']['UserName'];
                    $formArray_other['createdDateTime'] = date('Y-m-d H:i:s');
                    foreach ($_POST['Mobilizer'] as $d) {
                        $formArray_other['idMob'] = $d;
                        $editData_other = $Custom->Insert($formArray_other, 'idCMDetail', 'community_mobilization_detail', 'N');
                    }
                    if ($editData_other) {
                        $result = 1;
                    } else {
                        $result = 11;
                    }
                }

            } else {
                $result = 10;
            }

            $trackarray = array("action" => "Edit Community_mobilization setting -> Function: editData() ",
                "result" => $editData, "PostData" => $editArr);
            $Custom->trackLogs($trackarray, "user_logs");

        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Edit Community_mobilization setting -> Function: editData() ",
            "activityName" => "Edit Community_mobilization",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idCommunity_mobilization']) && $_POST['idCommunity_mobilization'] != '') {
            $idCommunity_mobilization = $_POST['idCommunity_mobilization'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $_SESSION['login']['idUser'];
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCommunity_mobilization, 'community_mobilization');

            $trackarray = array("action" => "Delete Community_mobilization setting -> Function: deleteData() ",
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
        $trackarray = array("action" => "Delete Community_mobilization -> Function: deleteData() ",
            "activityName" => "Delete Community_mobilization",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }

    function getMobByUcs()
    {
        $MCamp = new MCamp();
        $ucs = (isset($_REQUEST['ucs']) && $_REQUEST['ucs'] != '' && $_REQUEST['ucs'] != 0 ? $_REQUEST['ucs'] : 0);
        $type = 'Mob';
        $data = $MCamp->getDrByUc($ucs, $type);
        echo json_encode($data, true);
    }

    function lockData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idCommunity_mobilization']) && $_POST['idCommunity_mobilization'] != '') {
            $idCommunity_mobilization = $_POST['idCommunity_mobilization'];
            $editArr['locked'] = 1;
            $editArr['lockedBy'] = $_SESSION['login']['UserName'];
            $editArr['lockedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idCommunity_mobilization, 'community_mobilization');

            $trackarray = array("action" => "Lock Community_mobilization setting -> Function: lockData() ",
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
        $trackarray = array("action" => "Lock Community_mobilization setting -> Function: lockData() ",
            "activityName" => "Lock Community_mobilization",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>