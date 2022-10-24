<?php ob_start();

class Settings extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    /*Groups*/
    function groups()
    {
        $MSettings = new MSettings();
        $data = array();
        $data['groups'] = $MSettings->getAllGroups();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('settings/group', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');

        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Group setting",
            "action" => "View Group setting -> Function: Settings/groups()",
            "result" => "View success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
    }

    function addGroupData()
    {
        ob_end_clean();
        if (isset($_POST['groupName']) && $_POST['groupName'] != '') {
            $MSettings = new MSettings();
            $Custom = new Custom();
            $formArray = array();
            $formArray['groupName'] = ucfirst($_POST['groupName']);
            $formArray['isActive'] = 1;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($formArray, 'idGroup', 'group', 'Y');
            $pages = $MSettings->getAllPages();
            foreach ($pages as $p) {
                $pagegroupArray = array();
                $pagegroupArray['idGroup'] = $InsertData;
                $pagegroupArray['idPages'] = $p->idPages;
                $pagegroupArray['CanAdd'] = 0;
                $pagegroupArray['CanEdit'] = 0;
                $pagegroupArray['CanDelete'] = 0;
                $pagegroupArray['CanView'] = 0;
                $pagegroupArray['CanViewAllDetail'] = 0;
                $pagegroupArray['isActive'] = 1;
                $Custom->Insert($pagegroupArray, 'idPageGroup', 'pagegroup', 'N');
            }

            $trackarray = array(
                "activityName" => "Group setting",
                "action" => "Add Group setting -> Function: Settings/addGroupData()",
                "result" => $InsertData,
                "PostData" => $formArray,
                "affectedKey" => 'idGroup',
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");

            if ($InsertData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        echo $result;
    }

    public function getGroupEdit()
    {
        $MSettings = new MSettings();
        $result = $MSettings->getEditGroup($this->input->post('id'));
        echo json_encode($result, true);
    }

    function editGroupData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idGroup']) && $_POST['idGroup'] != '' && isset($_POST['groupName']) && $_POST['groupName'] != '') {
            $idGroup = $_POST['idGroup'];
            $editArr['groupName'] = $_POST['groupName'];
            $editArr['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idGroup', $idGroup, 'group');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
            $trackarray = array(
                "activityName" => "Group setting",
                "action" => "Edit Group setting -> Function: Settings/editGroupData()",
                "result" => $result,
                "PostData" => $editArr,
                "affectedKey" => 'idGroup=' . $idGroup,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
        } else {
            $result = 3;
        }

        echo $result;
    }

    function deleteGroupData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idGroup']) && $_POST['idGroup'] != '') {
            $idGroup = $_POST['idGroup'];
            $editArr['isActive'] = 0;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idGroup', $idGroup, 'group');

            $trackarray = array("action" => "Delete Group setting -> Function: deleteGroupData() ",
                "result" => $editData, "PostData" => $editArr);
            $Custom->trackLogs($trackarray, "table_logs");
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
            $trackarray = array(
                "activityName" => "Group setting",
                "action" => "Delete Group setting -> Function: Settings/deleteGroupData()",
                "result" => $result,
                "PostData" => $editArr,
                "affectedKey" => 'idGroup=' . $idGroup,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
        } else {
            $result = 3;
        }
        echo $result;
    }

    /*pages*/
    function pages()
    {
        $MSettings = new MSettings();
        $data = array();
        $data['pages'] = $MSettings->getAllPages();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('settings/pages', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Pages setting",
            "action" => "View Pages setting -> Function: Settings/pages()",
            "result" => "View success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
    }

    function addPageData()
    {
        ob_end_clean();
        if (isset($_POST['pageName']) && $_POST['pageName'] != '') {
            $MSettings = new MSettings();
            $Custom = new Custom();
            $formArray = array();
            $formArray['pageName'] = ucfirst($_POST['pageName']);
            $formArray['pageUrl'] = $_POST['pageUrl'];
            if (isset($_POST['menuParent']) && $_POST['menuParent'] == 1) {
                $formArray['isParent'] = 1;
                $formArray['idParent'] = $_POST['menuParent'];
            } else {
                $formArray['isParent'] = 0;
                $formArray['idParent'] = 0;
            }
            $formArray['menuIcon'] = (isset($_POST['menuIcon']) ? $_POST['menuIcon'] : '');
            $formArray['menuClass'] = (isset($_POST['menuClass']) ? $_POST['menuClass'] : '');
            $formArray['isMenu'] = (isset($_POST['isMenu']) ? $_POST['isMenu'] : 1);
            $formArray['sort_no'] = (isset($_POST['sort_no']) ? $_POST['sort_no'] : 999);
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $formArray['isActive'] = 1;
            $checkProjectByURL = $MSettings->checkPagesByURL($formArray['pageUrl']);
            if (isset($checkProjectByURL[0]->pageUrl) && count($checkProjectByURL[0]->pageUrl) >= 1) {
                $result = 4;
            } else {
                $InsertData = $Custom->Insert($formArray, 'idPages', 'pages', 'Y');
                $groups = $MSettings->getAllGroups();
                foreach ($groups as $g) {
                    $pagegroupArray = array();
                    $pagegroupArray['idPages'] = $InsertData;
                    $pagegroupArray['idGroup'] = $g->idGroup;
                    $pagegroupArray['CanAdd'] = 0;
                    $pagegroupArray['CanEdit'] = 0;
                    $pagegroupArray['CanDelete'] = 0;
                    $pagegroupArray['CanView'] = 0;
                    $pagegroupArray['CanViewAllDetail'] = 0;
                    $pagegroupArray['isActive'] = 1;
                    $Custom->Insert($pagegroupArray, 'idPageGroup', 'pagegroup', 'N');
                }
                if ($InsertData) {
                    $result = 1;
                } else {
                    $result = 2;
                }

                $trackarray = array(
                    "activityName" => "Page setting",
                    "action" => "Add Page setting -> Function: Settings/addPageData()",
                    "result" => $InsertData,
                    "PostData" => $formArray,
                    "affectedKey" => 'idPages',
                    "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                    "username" => $this->encrypt->decode($_SESSION['login']['username']),
                );
                $Custom->trackLogs($trackarray, "all_logs");
            }
        } else {
            $result = 3;
        }
        echo $result;
    }

    public function getPageEdit()
    {
        $MSettings = new MSettings();
        $result = $MSettings->getPageById($this->input->post('id'));
        echo json_encode($result, true);
    }

    function deletePageData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idPage']) && $_POST['idPage'] != '') {
            $idPage = $_POST['idPage'];
            $editArr['isActive'] = 0;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idPages', $idPage, 'pages');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
            $trackarray = array(
                "activityName" => "Pages setting",
                "action" => "Delete Pages setting -> Function: Settings/deletePageData()",
                "result" => $result,
                "PostData" => $editArr,
                "affectedKey" => 'idPages=' . $idPage,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username'])
            );
            $Custom->trackLogs($trackarray, "all_logs");
        } else {
            $result = 3;
        }
        echo $result;
    }


    /*Group Settings*/

    function groupSettings($slug)
    {
        if (!$slug) {
            redirect(base_url());
        } else {
            $MSettings = new MSettings();
            $data = array();
            $data['slug'] = $slug;
            $data['groups'] = $MSettings->getEditGroup($slug);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('settings/groupSettings', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $Custom = new Custom();
            $trackarray = array(
                "activityName" => "Group Role setting",
                "action" => "View Group Role setting -> Function: Settings/groupSettings()",
                "result" => "View success",
                "PostData" => "",
                "affectedKey" => "",
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
        }
    }

    public function getFormGroupData()
    {
        $id = $_POST['idGroup'];
        if ($id) {
            $MSettings = new MSettings();
            $getData = $MSettings->selectFormGroupData($id);
            echo json_encode($getData);
        }
    }

    public function fgAdd()
    {
        $mSetting = new Msettings();
        $last = "";
        for ($i = 0; $i < count($_POST); $i++) {
            $idPageGroup = $_POST[$i]["idPageGroup"];
            if (isset($_POST[$i]["CanViewAllDetail"])) {
                $postArray = array(
//                    'idPageGroup' => $_POST[$i]["idPageGroup"],
                    'CanViewAllDetail' => ($_POST[$i]["CanViewAllDetail"] == "true") ? 1 : 0
                );
                $last = $mSetting->fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanView"])) {
                $postArray = array(
//                    'idPageGroup' => $_POST[$i]["idPageGroup"],
                    'CanView' => ($_POST[$i]["CanView"] == "true") ? 1 : 0
                );
                $last = $mSetting->fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanAdd"])) {
                $postArray = array(
//                    'idPageGroup' => $_POST[$i]["idPageGroup"],
                    'CanAdd' => ($_POST[$i]["CanAdd"] == "true") ? 1 : 0
                );
                $last = $mSetting->fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanEdit"])) {
                $postArray = array(
//                    'idPageGroup' => $_POST[$i]["idPageGroup"],
                    'CanEdit' => ($_POST[$i]["CanEdit"] == "true") ? 1 : 0
                );
                $last = $mSetting->fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanDelete"])) {
                $postArray = array(
//                    'idPageGroup' => $_POST[$i]["idPageGroup"],
                    'CanDelete' => ($_POST[$i]["CanDelete"] == "true") ? 1 : 0
                );
                $last = $mSetting->fgAdd($postArray, $idPageGroup);
            }
        }
        echo $last;
    }

    /*change Sub Location*/
    public function changeLocation()
    {
        if (isset($_POST['loc']) && $_POST['loc'] != '') {
            $M = new Custom();
            $getSubLocations = $M->getSubLocations($_POST['loc']);
            $result = array('0' => 'Success', '1' => $getSubLocations);
        } else {
            $result = array('0' => 'Error', '1' => 'Invalid Location');
        }
        echo json_encode($result);
    }
} ?>