<?php use App\Models\Custom_Model;

ob_start();

class App_Users extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser_app');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $Custom = new Custom();
        $MUser_app = new MUser_app();
        $data = array();
        $data['user'] = $MUser_app->getAllUserApp();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        /*==========Log=============*/
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $track_msg = 'View success';
            $MUser = new MUser();
            $data['districts'] = $Custom->getDistricts();
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('user_app', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        } else {
            $track_msg = 'page-not-authorized';
            $this->load->view('page-not-authorized', $data);
        }
        $trackarray = array(
            "activityName" => "View App_Users",
            "action" => "View App_Users -> Function: App_Users/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/

    }

    function addData()
    { $Custom = new Custom();
        $formArray = array();
        $InsertData = 0;
        if (isset($_POST['userName']) && $_POST['userName'] != '' && isset($_POST['userPassword']) && $_POST['userPassword'] != '') {
            $M = new MUser_app();
            $checkUsername = $M->checkUsername($_POST['userName']);
            if (isset($checkUsername[0]) && count($checkUsername) >= 1) {
                $result = array('Error', 'User Name already exist', 'error');
            } else {


                $formArray['full_name'] = ucfirst($_POST['fullName']);
                $formArray['username'] = $_POST['userName'];

                $salt = openssl_random_pseudo_bytes(16);
                $userPasswordenc = $Custom->genPassword($_POST['userPassword'], $salt,'sha1');

                $formArray['password'] = $_POST['userPassword'];
                $formArray['passwordenc'] = $userPasswordenc;
                $formArray['designation'] = $_POST['designation'];
                $formArray['dist_id'] = $_POST['district'];
                $formArray['auth_level'] = 0;
                $formArray['enabled'] = 1;
                $formArray['isNewUser'] = 1;
                $formArray['attempt'] = 0;
                $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
                $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
                $formArray['createdDateTime'] = date('Y-m-d H:i:s');

                $InsertData = $Custom->Insert($formArray, 'id', 'users', 'N');
                if ($InsertData) {
                    $result = array('Success', 'Successfully Inserted', 'success');
                } else {
                    $result = array('Error', 'Something went wrong in inserting data', 'error');
                }
            }
        } else {
            $result = array('Error', 'Invalid Data', 'error');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "App_Users addData",
            "action" => "Add App_Users -> Function: App_Users/addData()",
            "result" => $result[1],
            "PostData" => $formArray,
            "affectedKey" => 'id=' . $InsertData,
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/

        echo json_encode($result);
    }

    public function getEdit()
    {
        $MUser = new MUser_app();
        $result = $MUser->getEditUser($this->input->post('id'));
        echo json_encode($result, true);
    }

    function editData()
    {
        if (isset($_POST['userName']) && $_POST['userName'] != '' && isset($_POST['idUser']) && $_POST['idUser'] != '') {
            $Custom = new Custom();
            $idUser = $_POST['idUser'];
            $formArray = array();
            $formArray['full_name'] = ucfirst($_POST['fullName']);
            $formArray['designation'] = $_POST['designation'];
            $formArray['dist_id'] = $_POST['district'];
            $formArray['attempt'] = 0;
            $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');

            $editData = $Custom->Edit($formArray, 'id', $idUser, 'users');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }

            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "App_Users",
                "action" => "Edit App_Users -> Function: App_Users/editData()",
                "result" => $result . "--- resultID: " . $editData,
                "PostData" => $formArray,
                "affectedKey" => 'id=' . $idUser,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            $result = 3;
        }
        echo $result;
    }

    function resetPwd()
    {
        if (isset($_POST['idUser']) && $_POST['idUser'] != '' && isset($_POST['userPassword']) && $_POST['userPassword'] != '') {
            $Custom = new Custom();
            $idUser = $_POST['idUser'];
            $formArray = array();
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc = $Custom->genPassword($_POST['userPassword'], $salt,'sha1');

            $formArray['password'] = $_POST['userPassword'];
            $formArray['passwordenc'] = $userPasswordenc;
            $formArray['isNewUser'] = 1;
            $formArray['attempt'] = 0;
            $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($formArray, 'id', $idUser, 'users');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }

            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "App_Users",
                "action" => "Reset Password App_Users -> Function: App_Users/resetPwd()",
                "result" => $result . "--- resultID: " . $editData,
                "PostData" => $formArray,
                "affectedKey" => 'id=' . $idUser,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            $result = 3;
        }
        echo $result;
    }


   /* function resetPwdAll()
    {
        $MUser_app = new MUser_app();
        $getAllUserApp= $MUser_app->getAllUserApp();
        $Custom = new Custom();
        foreach ($getAllUserApp as $k=>$v){
            $idUser = $v->username;
            $formArray = array();
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc = $Custom->genPassword( $v->password, $salt,'sha1');
            $formArray['passwordenc'] = $userPasswordenc;
            $formArray['isNewUser'] = 1;
            $formArray['attempt'] = 0;
            $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($formArray, 'username', $idUser, 'users');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        }
        echo $result;
    }*/

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idUser']) && $_POST['idUser'] != '') {
            $idUser = $_POST['idUser'];
            $editArr['colflag'] = 1;
            $editArr['enabled'] = 0;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idUser, 'users');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "App_Users",
                "action" => "Delete App_Users -> Function: App_Users/deleteData()",
                "result" => $result . "--- resultID: " . $editData,
                "PostData" => $editArr,
                "affectedKey" => 'id=' . $idUser,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            $result = 3;
        }
        echo $result;
    }

    function getUsersByDistrict()
    {
        $MUser = new MUser_app();
        $result = $MUser->getAppUserByDist($this->input->post('dist'));
        echo json_encode($result, true);
    }


} ?>