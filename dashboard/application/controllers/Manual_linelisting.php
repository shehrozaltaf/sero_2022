<?php

class Manual_linelisting extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
//        $this->load->model('mmanual_linelisting');
        $this->load->model('custom');
        $this->load->model('msettings');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
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
            $this->load->view('manual_linelisting', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Manual_linelisting",
            "action" => "View Manual_linelisting -> Function: Manual_linelisting/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function insertData()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['cluster_select']) || $_POST['cluster_select'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['total_structure_identified']) || $_POST['total_structure_identified'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();
        }

        if (!isset($_POST['total_household_identified']) || $_POST['total_household_identified'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();
        }
        if (!isset($_POST['total_residential_structures']) || $_POST['total_residential_structures'] == '') {
            $flag = 1;
            $result = 13;
            echo $result;
            exit();
        }
        /* if (!isset($_POST['household_targeted_children']) || $_POST['household_targeted_children'] == '') {
             $flag = 1;
             $result = 5;
             echo $result;
             exit();
         }*/

        if (!isset($_POST['option']) || $_POST['option'] == '') {
            $flag = 1;
            $result = 10;
            echo $result;
            exit();
        }

        if (!isset($_POST['linelisting_date']) || $_POST['linelisting_date'] == '') {
            $flag = 1;
            $result = 12;
            echo $result;
            exit();
        }

        if ($flag == 0) {
            $cluster = $_POST['cluster_select'];

            $M = new Custom();
            $data = $M->getClustersData($cluster);

            if (isset($data) && $data != '') {
                $Custom = new Custom();
                $formArray = array();
                $formArray['col_dt'] = date('Y-m-d H:i:s');
                $formArray['cluster'] = $cluster;
                $formArray['enumcode'] = $data[0]->dist_id;
                $formArray['geoArea'] = $data[0]->geoarea;
                $formArray['formdate'] = date('d-m-y', strtotime($_POST['linelisting_date']));
                $formArray['hh01'] = $cluster;
                $formArray['projectname'] = 'TPVICS_R2-LINELISTING';
                $formArray['tot_str'] = $_POST['total_structure_identified'];
                $formArray['tot_hh'] = $_POST['total_household_identified'];
                $formArray['hh07n'] = $_POST['total_residential_structures'];
                $formArray['data_collected'] = 'Manual';
                $formArray['username'] = $this->encrypt->decode($_SESSION['login']['username']);
                $formArray['sysdate'] = date('Y-m-d H:i:s');
                foreach ($_POST['option'] as $opt) {
                    $formArray['hh04'] = $opt['structure_number'];
                    $formArray['hh08'] = '1';
                    $formArray['hh05'] = $opt['household_no'];
                    $formArray['hh11'] = $opt['household_name'];
                    $formArray['hh14'] = '1';
                    $formArray['hh14a'] = $opt['childAge'];
                    $formArray['tabNo'] = 'A';
                    $uid = $cluster . '_' . $formArray['tabNo'] . '_' . $formArray['hh04'] . '_' . $formArray['hh05'];
                    $formArray['_uid'] = $uid;
                    $InsertData = $Custom->Insert($formArray, 'col_id', 'listings', 'N');
                    if ($InsertData) {
                        $result = 1;
                        $track_msg = 'Successfully inserted';
                    } else {
                        $result = 8;
                        $track_msg = 'Error in inserting data';
                    }
                    /*==========Log=============*/
                    $Custom = new Custom();
                    $trackarray = array(
                        "activityName" => "Manual_linelisting",
                        "action" => "View Manual_linelisting -> Function: Manual_linelisting/insertData()",
                        "result" => $track_msg,
                        "PostData" => $formArray,
                        "affectedKey" => "col_id",
                        "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                        "username" => $this->encrypt->decode($_SESSION['login']['username']),
                    );
                    $Custom->trackLogs($trackarray, "all_logs");
                    /*==========Log=============*/
                }


            } else {
                $result = 7;
            }

        } else {
            $result = 9;
        }
        echo $result;
    }


}

?>