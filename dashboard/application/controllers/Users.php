<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Users extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
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
        $MUser = new MUser();
        $data = array();

        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Users",
            "action" => "View Users -> Function: Users/index()",
            "result" => "View Users success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        $data['user'] = $MUser->getAllUser();
        $data['districts'] = '';
        $data['groups'] = $MSettings->getAllGroups();

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('auth/dashboard_users', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    public function getEdit()
    {
        $MUser = new MUser();
        $data = array();
        $result = $MUser->getEditUser($this->input->post('id'));
        foreach ($result as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['full_name'] = $v->full_name;
            $data[$k]['username'] = $v->username;
            $data[$k]['email'] = $v->email;
            $data[$k]['designation'] = $v->designation;
            $data[$k]['contact'] = $v->contact;
            $data[$k]['idGroup'] = $v->idGroup;
            $data[$k]['pwdExpiry'] = (isset($v->pwdExpiry) && $v->pwdExpiry != '' ? date('d-m-Y', strtotime($v->pwdExpiry)) : '');
        }
        echo json_encode($data, true);
    }

    function editData()
    {
        $formArray = array();
        $Custom = new Custom();
        $flag = 0;
        if (!isset($_POST['idUser']) || $_POST['idUser'] == '') {
            $result = 4;
            $flag = 1;
            echo $result;
            die();
        }
        if (isset($_POST['full_name']) && $_POST['full_name'] != '') {
            $formArray['full_name'] = ucfirst($_POST['fullName']);
        }
        if (isset($_POST['userGroup']) && $_POST['userGroup'] != '' && $_POST['userGroup'] != '0') {
            $formArray['idGroup'] = $_POST['userGroup'];
        } else {
            echo $result = 6;
            $flag = 1;
            exit();
        }

        if (isset($_POST['designation']) && $_POST['designation'] != '') {
            $formArray['designation'] = $_POST['designation'];
        }
        if (isset($_POST['contactNo']) && $_POST['contactNo'] != '') {
            $formArray['contact'] = $_POST['contactNo'];
        }
        if (isset($_POST['pwdExpiry']) && $_POST['pwdExpiry'] != '') {
            $formArray['pwdExpiry'] = date('Y-m-d', strtotime($_POST['pwdExpiry']));
        }
        if ($flag == 0 && isset($_POST['idUser']) && $_POST['idUser'] != '') {
            $idUser = $_POST['idUser'];
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:m:s');
            $editData = $Custom->Edit($formArray, 'id', $idUser, 'users_dash');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Users",
            "action" => "Edit Users -> Function: Users/editData()",
            "result" => $result,
            "PostData" => $formArray,
            "affectedKey" => 'idUser=' . $idUser,
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username'])
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idUser']) && $_POST['idUser'] != '') {
            $idUser = $_POST['idUser'];
            $editArr['status'] = 0;
            $editData = $Custom->Edit($editArr, 'id', $idUser, 'users_dash');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Users",
            "action" => "Delete Users -> Function: Users/deleteUsers()",
            "result" => $result,
            "PostData" => $editArr,
            "affectedKey" => 'idUser=' . $idUser,
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username'])
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        echo $result;
    }

    function addData()
    {
        $Custom = new Custom();
        ob_end_clean();
        $flag = 0;
        $formArray = array();
        if (!isset($_POST['fullName']) || $_POST['fullName'] == '') {
            echo $result = 3;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['userName']) || $_POST['userName'] == '') {
            echo $result = 4;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['userEmail']) || $_POST['userEmail'] == '') {
            echo $result = 5;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['userPassword']) || $_POST['userPassword'] == '') {
            echo $result = 6;
            $flag = 1;
            exit();
        }
        if (strlen($_POST['userPassword']) < 8) {
            echo $result = 7;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['userGroup']) || $_POST['userGroup'] == '' || $_POST['userGroup'] == '0') {
            echo $result = 8;
            $flag = 1;
            exit();
        }

        if (isset($_POST['userName']) && $_POST['userName'] != ''
            && isset($_POST['userEmail']) && $_POST['userEmail'] != ''
            && isset($_POST['userPassword']) && $_POST['userPassword'] != '') {
            $MUser = new MUser();
            $chkUsernameEmail = $MUser->chkUsernameEmail($_POST['userName'], $_POST['userEmail']);
            if (count($chkUsernameEmail) >= 1) {
                $result = 10;
            } else {
                $formArray['full_name'] = ucfirst($_POST['fullName']);
                $formArray['username'] = $_POST['userName'];
                $formArray['email'] = $_POST['userEmail'];
                $salt = openssl_random_pseudo_bytes(16);
                $userPasswordenc = hash('sha512', $_POST['userPassword']);
                $formArray['passwordenc'] = $userPasswordenc;
                $formArray['designation'] = (isset($_POST['designation']) && $_POST['designation'] != '' ? $_POST['designation'] : '');
                $formArray['contact'] = (isset($_POST['contactNo']) && $_POST['contactNo'] != '' ? $_POST['contactNo'] : '');
                $formArray['idGroup'] = $_POST['userGroup'];
                $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
                $formArray['createdDateTime'] = date('Y-m-d H:m:s');
                $formArray['status'] = 1;
                $formArray['attempt'] = 0;
                $formArray['isNewUser'] = 1;
                $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
                $InsertData = $Custom->Insert($formArray, 'id', 'users_dash', 'N');
                if ($InsertData) {
                    $result = 1;
                } else {
                    $result = 2;
                }
            }
        } else {
            $result = 9;
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Users",
            "action" => "Add Users -> Function: Users/addData()",
            "result" => $result,
            "PostData" => $formArray,
            "affectedKey" => 'id',
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/

        echo $result;
    }


    function resetPwd()
    {
        $flag = 0;
        if (!isset($_POST['userPassword']) || $_POST['userPassword'] == '') {
            echo $result = 4;
            $flag = 1;
            exit();
        }
        if (strlen($_POST['userPassword']) < 8) {
            echo $result = 5;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['userPasswordConfirm']) || $_POST['userPasswordConfirm'] == '' || $_POST['userPassword'] != $_POST['userPasswordConfirm']) {
            echo $result = 6;
            $flag = 1;
            exit();
        }

        if (isset($_POST['idUser']) && $_POST['idUser'] != '' && isset($_POST['userPassword']) && $_POST['userPassword'] != '') {
            $Custom = new Custom();
            $idUser = $_POST['idUser'];
            $formArray = array();
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc = hash('sha512', $_POST['userPassword']);
            $formArray['passwordenc'] = hash('sha512', $_POST['userPassword']);
            $formArray['isNewUser'] = 1;
            $formArray['attempt'] = 0;
            $formArray['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($formArray, 'id', $idUser, 'users_dash');
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
        }
        echo $result;
    }

    function changePassword()
    {
        $Custom = new Custom();
        $editArr = array();
        $flag = 0;
        if (!isset($_POST['newpassword']) || $_POST['newpassword'] == '') {
            $result = 2;
            $flag = 1;
            exit();
        }
        if (strlen($_POST['newpassword']) < 8) {
            $result = 5;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['newpasswordconfirm']) || $_POST['newpasswordconfirm'] == '' || $_POST['newpassword'] != $_POST['newpasswordconfirm']) {
            $result = 3;
            $flag = 1;
            exit();
        }
        if ($flag == 0 && isset($_SESSION['login']['idUser']) && $_SESSION['login']['idUser'] != '') {
            $idUser = $this->encrypt->decode($_SESSION['login']['idUser']);
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc =  hash('sha512', $_POST['newpassword']);
            $MUser = new MUser();
            $getUser=$MUser->getEditUser($idUser);
            if(isset($getUser[0]->passwordenc) && $getUser[0]->passwordenc===$userPasswordenc){
                $result=6;
            }else{
                $editArr['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));

                $editArr['passwordenc'] = $userPasswordenc;
                $editData = $Custom->Edit($editArr, 'id', $idUser, 'users_dash');
                if ($editData) {
                    $result = 1;
                    $_SESSION['login']['isNewUser'] = $this->encrypt->encode(0);
                    $_SESSION['login']['pwdExpiry'] = $this->encrypt->encode($editArr['pwdExpiry']);
                } else {
                    $result = 2;
                }
            }

        } else {
            $result = 4;
        }

        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "changePassword",
            "action" => "changePassword Users -> Function: Users/changePassword()",
            "result" => $result,
            "PostData" => $editArr,
            "affectedKey" => 'idUser= ' . $idUser,
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        echo $result;
    }

    function changefirstPassword()
    {
        $Custom = new Custom();
        $editArr = array();
        $flag = 0;
        if (!isset($_POST['newpassword']) || $_POST['newpassword'] == '') {
            $result = 2;
            $flag = 1;
            exit();
        }
        if (strlen($_POST['newpassword']) < 8) {
            $result = 5;
            $flag = 1;
            exit();
        }
        if (!isset($_POST['newpasswordconfirm']) || $_POST['newpasswordconfirm'] == '' || $_POST['newpassword'] != $_POST['newpasswordconfirm']) {
            $result = 3;
            $flag = 1;
            exit();
        }
        if ($flag == 0 && isset($_SESSION['login']['idUser']) && $_SESSION['login']['idUser'] != '') {
            $idUser = $this->encrypt->decode($_SESSION['login']['idUser']);
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc =  hash('sha512', $_POST['newpassword']);
            $MUser = new MUser();
            $getUser=$MUser->getEditUser($idUser);
            if(isset($getUser[0]->passwordenc) && $getUser[0]->passwordenc===$userPasswordenc){
                $result=6;
            }else{
                $editArr['isNewUser'] = 0;
                $editArr['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
                $salt = openssl_random_pseudo_bytes(16);
                $userPasswordenc =hash('sha512', $_POST['newpassword']);
                $editArr['passwordenc'] = $userPasswordenc;
                $editData = $Custom->Edit($editArr, 'id', $idUser, 'users_dash');
                if ($editData) {
                    $result = 1;
                    $_SESSION['login']['isNewUser'] = $this->encrypt->encode(0);
                    $_SESSION['login']['pwdExpiry'] = $this->encrypt->encode($editArr['pwdExpiry']);
                } else {
                    $result = 2;
                }
            }
        } else {
            $result = 4;
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "changefirstPassword",
            "action" => "changefirstPassword Users -> Function: Users/changefirstPassword()",
            "result" => $result,
            "PostData" => $editArr,
            "affectedKey" => 'idUser= ' . $idUser,
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        echo $result;
    }

    function log_reports()
    {
        $MUser = new MUser();
        $data = array();

        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Users Log Reports",
            "action" => "View Users Log Reports -> Function: Users/log_reports()",
            "result" => "View Users Log Reports success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        $data['user'] = $MUser->getAllUser();
        $data['getUserData']=array();
        $idUser=0;
        if (isset($_GET['u']) && $_GET['u'] != '') {
            $idUser=$_GET['u'];
            $data['getUserData'] = $MUser->getUserLog($idUser);
            $getLastLogin= $MUser->getLastLogin($idUser);
            $data['getUserData'][0]->getLastLogin=(isset($getLastLogin[0]->createdDateTime) && $getLastLogin[0]->createdDateTime!=''?$getLastLogin[0]->createdDateTime:'');

        }
        $data['user_slug']=$idUser;
        $data['getUserLoginActivity'] = $MUser->getUserLoginActivity($idUser, 'Login');
        $data['getUserActivity'] = $MUser->getUserActivity($idUser, 'Login');
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('auth/user_log_reports', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');

    }
} ?>