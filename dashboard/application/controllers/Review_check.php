<?php error_reporting(0);

class Review_check extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mreview_check');
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
            $MCard_comment = new MReview_check();
            $province = $MCard_comment->getProvince_District('');
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
            $this->load->view('review_check', $data);
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
            "activityName" => "Review_check",
            "action" => "View Review_check -> Function: Review_check/index()",
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
        $MCard_comment = new MReview_check();
        $cluster = $_POST['cluster_no'];
        $household = $_POST['household'];
        $childNo = $_POST['childNo'];
        $getData = $MCard_comment->getDataImages($cluster, $household, $childNo);

        $checkExistData = $MCard_comment->checkExistData($cluster, $household, $childNo);
        $data = array();
        $data['data'] = $getData;
        if (isset($checkExistData) && $checkExistData != '' && count($checkExistData) > 0) {
            $data['dataExist'] = $checkExistData;
        } else {
            $data['dataExist'] = '0';
        }
        echo json_encode($data);
    }

    function submitData()
    {
        $Custom = new Custom();
        $insertArr = array();
        $insertArr['cluster_no'] = $_POST['cluster_no'];
        $insertArr['household'] = $_POST['household'];
        $insertArr['comment_status'] = $_POST['comment_status'];
        $insertArr['comment'] = $_POST['comment'];
        $flag = 0;
        if (!isset($insertArr['cluster_no']) || $insertArr['cluster_no'] == '' || $insertArr['cluster_no'] == 'undefined') {
            echo 2;
            $flag = 1;
            exit();
        }
        if (!isset($insertArr['household']) || $insertArr['household'] == '' || $insertArr['household'] == 'undefined') {
            echo 3;
            $flag = 1;
            exit();
        }
        if (!isset($insertArr['comment_status']) || $insertArr['comment_status'] == '' || $insertArr['comment_status'] == 'undefined') {
            echo 6;
            $flag = 1;
            exit();
        }
        if (!isset($insertArr['comment']) || $insertArr['comment'] == '' || $insertArr['comment'] == 'undefined') {
            echo 5;
            $flag = 7;
            exit();
        }
        if ($flag == 0) {
            $insertArr['child_ec14'] = (isset($_POST['child_ec14']) ? $_POST['child_ec14'] : '');
            $insertArr['ec13'] = (isset($_POST['ec13']) ? $_POST['ec13'] : '');
            $insertArr['f01'] = (isset($_POST['f01']) ? $_POST['f01'] : '');
            $insertArr['f02'] = (isset($_POST['f02']) ? $_POST['f02'] : '');
            $insertArr['createdBy'] = $this->encrypt->decode($_SESSION['login']['username']);
            $insertArr['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($insertArr, 'id_Image_feedback_Comment', 'image_feedback_comments', 'N');
            if ($InsertData) {
                echo 1;
                $track_msg = 'Successfully inserted';
            } else {
                echo 4;
                $track_msg = 'Error in inserting data';
            }
            /*==========Log=============*/
            $Custom = new Custom();
            $trackarray = array(
                "activityName" => "Image_forms",
                "action" => "View Image_forms -> Function: Image_forms/index()",
                "result" => $track_msg,
                "PostData" => $insertArr,
                "affectedKey" => "id_Image_feedback_Comment",
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            echo 5;
        }
    }

    function getDistrictByProvince()
    {
        $MCard_comment = new MReview_check();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $data = $MCard_comment->getProvince_District($province);
        $p = array();
        $res = array();
        foreach ($data as $k => $v) {
            $exp = explode('|', $v->geoarea);
            $p[$v->dist_id] = $exp[1];
        }
        $res[0] = $p;
        echo json_encode($res, true);
    }

    function getClustersByDist()
    {
        $MCard_comment = new MReview_check();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $MCard_comment->getClusters($district);
        echo json_encode($data, true);
    }

    function getHhnoByCluster()
    {
        $MCard_comment = new MReview_check();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $data = $MCard_comment->gethhnoByClust($cluster);
        echo json_encode($data, true);
    }

    function getChildNoByHH()
    {
        $MCard_comment = new MReview_check();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $hh = (isset($_REQUEST['hh']) && $_REQUEST['hh'] != '' ? $_REQUEST['hh'] : 0);
        $data = $MCard_comment->getChildByHH($cluster, $hh);
        echo json_encode($data, true);
    }

}

?>