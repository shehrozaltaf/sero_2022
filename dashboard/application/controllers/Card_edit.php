<?php error_reporting(0);

class Card_edit extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcard_edit');
        $this->load->model('mimage_forms');
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
            $Mimage_forms = new Mimage_forms();
            $province = $Mimage_forms->getProvince_District('');
            $p = array();
            foreach ($province as $k => $v) {
                $key = substr($v->dist_id, 0, 1);
                $exp = explode('|', $v->geoarea);
                $p[$key] = $exp[0];
            }
            $data['province'] = $p;
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('card_edit', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Card_edit",
            "action" => "View Card_edit -> Function: Card_edit/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function getData()
    {
        $M = new MCard_edit();
        $province = (isset($_POST['province']) && $_POST['province'] != '' ? $_POST['province'] : '0');
        $district = (isset($_POST['district']) && $_POST['district'] != '' ? $_POST['district'] : '0');
        $checklist = (isset($_POST['checklist']) && $_POST['checklist'] != '' ? $_POST['checklist'] : '0');

        $getData = $M->getData($province, $district, $checklist);
        $data = array();
        foreach ($getData as $k => $v) {
            $data[$v->cluster_code][] = $v;
        }
        echo json_encode($data);
    }

    function getDistrictByProvince()
    {
        $Mimage_forms = new Mimage_forms();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $data = $Mimage_forms->getProvince_District($province);
        $p = array();
        $res = array();
        foreach ($data as $k => $v) {
            $key = substr($v->cluster_code, 0, 3);
            $exp = explode('|', $v->geoarea);
            $p[$key] = $exp[1];
        }
        $res[0] = $p;
        echo json_encode($res, true);
    }


    function edit_form()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Card_edit');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $M = new MCard_edit();

            if (isset($_GET['c']) && $_GET['c'] != '') {
                $cluster = $_GET['c'];
            } else {
                $cluster = '0';
            }
            if (isset($_GET['h']) && $_GET['h'] != '') {
                $hhno = $_GET['h'];
            } else {
                $hhno = '0';
            }

            if (isset($_GET['ec']) && $_GET['ec'] != '') {
                $ec = $_GET['ec'];
            } else {
                $ec = '1';
            }

            $data['getData'] = $M->getDataEdit($cluster, $hhno, $ec);
            $data['cluster'] = $cluster;
            $data['hhno'] = $hhno;
            $data['ec'] = $ec;

            /*$Mimage_forms = new Mimage_forms();
            $data['getImageData'] = $Mimage_forms->getDataImages($cluster, $hhno, 1);*/


            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('card_edit_form', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Card_edit Form",
            "action" => "View Card_edit edit_form -> Function: Card_edit/edit_form()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }


    function addForm()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['cluster_code']) || $_POST['cluster_code'] == '') {
            $flag = 1;
            $result = 2;
        }

        if (!isset($_POST['hhno']) || $_POST['hhno'] == '') {
            $flag = 1;
            $result = 3;
        }

        if ($flag == 0) {
            $cluster = $_POST['cluster_code'];
            $hhno = $_POST['hhno'];
            $ec13 = $_POST['ec'];
            $M = new MCard_edit();
            $data = $M->getDataEdit($cluster, $hhno, $ec13);
            $Custom = new Custom();
            $formArray = array();
            if (isset($data) && $data != '') {


                $formArray['col_dt'] = date('Y-m-d H:i:s');
                $formArray['hhno'] = $hhno;
                $formArray['cluster_code'] = $cluster;
                $formArray['col_id'] = $data[0]->col_id;
                $formArray['ec13'] = $data[0]->ec13;
                $formArray['ec14'] = $data[0]->ec14;
                $formArray['ec13'] = $data[0]->ec13;
                $formArray['ec15'] = $data[0]->ec15;
                $formArray['im01'] = $data[0]->im01;
                $formArray['im04dd'] = $data[0]->im04dd;
                $formArray['im04mm'] = $data[0]->im04mm;
                $formArray['im04yy'] = $data[0]->im04yy;
                $formArray['f01'] = $data[0]->f01;
                $formArray['f02'] = $data[0]->f02;
                if (isset($_POST['dob']) && $_POST['dob'] != '') {
                    $formArray['dobcor'] = date('Y-m-d', strtotime($_POST['dob']));
                } else {
                    $formArray['dobcor'] = '';
                }

                $formArray['bcg'] = $_POST['bcg'];
                $formArray['opv0'] = $_POST['opv0'];
                $formArray['opv1'] = $_POST['opv1'];
                $formArray['opv2'] = $_POST['opv2'];
                $formArray['opv3'] = $_POST['opv3'];
                $formArray['penta1'] = $_POST['penta1'];
                $formArray['penta2'] = $_POST['penta2'];
                $formArray['penta3'] = $_POST['penta3'];
                $formArray['pcv'] = $_POST['pcv'];
                $formArray['pcv2'] = $_POST['pcv2'];
                $formArray['pcv3'] = $_POST['pcv3'];
                $formArray['rv1'] = $_POST['rv1'];
                $formArray['rv2'] = $_POST['rv2'];
                $formArray['ipv'] = $_POST['ipv'];
                $formArray['measles1'] = $_POST['measles1'];
                $formArray['measles2'] = $_POST['measles2'];
                $formArray['hep_b'] = $_POST['hep_b'];
                $formArray['ipv2'] = $_POST['ipv2'];
                $formArray['tcv'] = $_POST['tcv'];

                $formArray['bcg_98'] = $_POST['bcg_check'];
                $formArray['opv0_98'] = $_POST['opv0_check'];
                $formArray['opv1_98'] = $_POST['opv1_check'];
                $formArray['opv2_98'] = $_POST['opv2_check'];
                $formArray['opv3_98'] = $_POST['opv3_check'];
                $formArray['penta1_98'] = $_POST['penta1_check'];
                $formArray['penta2_98'] = $_POST['penta2_check'];
                $formArray['penta3_98'] = $_POST['penta3_check'];
                $formArray['pcv_98'] = $_POST['pcv_check'];
                $formArray['pcv2_98'] = $_POST['pcv2_check'];
                $formArray['pcv3_98'] = $_POST['pcv3_check'];
                $formArray['rv1_98'] = $_POST['rv1_check'];
                $formArray['rv2_98'] = $_POST['rv2_check'];
                $formArray['ipv_98'] = $_POST['ipv_check'];
                $formArray['measles1_98'] = $_POST['measles1_check'];
                $formArray['measles2_98'] = $_POST['measles2_check'];
                $formArray['hep_b_98'] = $_POST['hep_b_check'];
                $formArray['ipv2_98'] = $_POST['ipv2_check'];
                $formArray['tcv_98'] = $_POST['tcv_check'];

                $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
                $formArray['createdByUsername'] = $this->encrypt->decode($_SESSION['login']['username']);
                $formArray['createdDateTime'] = date('Y-m-d H:i:s');

                $InsertData = $Custom->Insert($formArray, 'id', 'vac_details_edit', 'N');
                if ($InsertData) {
                    $result = 1;
                    $track_msg = 'Successfully inserted';
                } else {
                    $result = 5;
                    $track_msg = 'Error in saving data';
                }
            } else {
                $result = 6;
                $track_msg = 'Invalid Data';
            }


            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "Card_edit",
                "action" => "Add Card_edit -> Function: Card_edit/addForm()",
                "result" => $track_msg,
                "PostData" => $formArray,
                "affectedKey" => "id",
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            $result = 4;
        }
        echo $result;
    }
}

?>