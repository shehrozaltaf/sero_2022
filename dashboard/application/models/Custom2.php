<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Custom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function selectAll($Qry)
    {
        $query = $this->db->query($Qry);
        $DataRetuen = $query->result();
        if ($DataRetuen) {
            return $DataRetuen;
        } else {
            return 0;
        }
    }

    function Insert($Data, $idReturn, $table, $getLastId = 'N')
    {
        $insert = $this->db->insert($table, $Data);
        if ($insert) {
            if ($getLastId === 'Y') {
                $returnValue = $this->db->insert_id();
            } elseif (!isset($Data[$idReturn]) || $Data[$idReturn] == '') {
                $returnValue = 1;
            } else {
                $returnValue = $Data[$idReturn];
            }
            return $returnValue;
        } else {
            return FALSE;
        }
    }

    function Edit($Data, $key, $value, $table)
    {
        $this->db->where($key, $value);
        $update = $this->db->update($table, $Data);
        if ($update) {
            return 1;
        } else {
            return 0;
        }
    }

    function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
            return $uuid;
        }
    }

    /*==========Log=============*/
    function trackLogs($array, $log_type)
    {

        date_default_timezone_set("Asia/Karachi");
        $UserName = (isset($array['UserName']) ? $array['UserName'] : $_SESSION['login']['username']);
        if (isset($log_type) && $log_type == 'user_logs') {
            $logFilePath = 'customLogs/user_logs/' . $UserName . 'logs_' . date("n_j_Y") . '.txt';
        } else {
            $logFilePath = 'customLogs/daily_logs/logs_' . date("n_j_Y") . '.txt';
        }
        $activityName = (isset($array['activityName']) ? $array['activityName'] : 'Invalid activityName');
        $action = (isset($array['action']) ? $array['action'] : 'Invalid Action');
        $postData = '';
        if (isset($array['PostData']) && $array['PostData'] != '') {
            foreach ($array['PostData'] as $key => $post) {
                $postData .= $key . ' = ' . $post . PHP_EOL;
            }

        }
        $result = (isset($array['result']) ? $array['result'] : 'Invalid Result');
        $idUser = (isset($array['idUser']) ? $array['idUser'] : $_SESSION['login']['idUser']);
        $log = "UserIPAddress: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F-j-Y g:i a") . PHP_EOL .
            "idUser: " . $idUser .
            ", UserName: " . $UserName . PHP_EOL .
            "Action: " . $action . PHP_EOL .
            "Result: " . $result . PHP_EOL .
            "PostData: " . $postData . PHP_EOL .
            "-------------------------------------------------" . PHP_EOL;
        $formArray = array();
        $formArray['idUser'] = $idUser;
        $formArray['activityName'] = $activityName;
        $formArray['actiontype'] = $action;
        $formArray['result'] = $result;
        $formArray['isActive'] = 1;
        $formArray['createdBy'] = $_SESSION['login']['idUser'];
        $formArray['createdDateTime'] = date('Y-m-d H:m:s');

        $InsertData = $this->Insert($formArray, 'id', 'users_dash_activity','N');
        $txt = fopen($logFilePath, "a") or die("Unable to open file!");
        fwrite($txt, $log);
        fclose($txt);
//        echo file_put_contents($logFilePath . date("n_j_Y") . '.txt', $log);
    }

    function getProvinces($sub_district = '')
    {
        if (isset($sub_district) && $sub_district != '') {
            $exp = explode(',', $sub_district);
            $dist_where_clause = '   (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (!isset($_SESSION['login']['idGroup']) || $_SESSION['login']['idGroup'] != 1) {
            $this->db->where("cluster_no NOT LIKE '9%' ");

        }

        $this->db->select('	province,
	SUBSTRING (dist_id, 1, 3) AS pid');
        $this->db->from('clusters');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->group_by('province');
        $this->db->group_by('SUBSTRING (dist_id, 1, 3)');
        $this->db->order_By('province', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getProvince_District($pro, $sub_district = '')
    {
        if (isset($pro) && $pro != '') {
            $this->db->where(" dist_id like '" . $pro . "%' ");
        }

        if (isset($sub_district) && $sub_district != '') {
            $exp = explode(',', $sub_district);
            $dist_where_clause = '   (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (!isset($_SESSION['login']['idGroup']) || $_SESSION['login']['idGroup'] != 1) {
            $this->db->where("cluster_no NOT LIKE '9%' ");
        }

        $this->db->select('district, dist_id');
        $this->db->from('clusters');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->group_by('district');
        $this->db->group_by('dist_id');
        $this->db->order_By('district', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getClusters_District($dist, $randomized = '')
    {
        if (isset($dist) && $dist != '') {
            $this->db->where(" dist_id = '" . $dist . "' ");
        }
        if (!isset($_SESSION['login']['idGroup']) || $_SESSION['login']['idGroup'] != 1) {
            $this->db->where("cluster_no NOT LIKE '9%' ");
        }
        if (isset($randomized) && $randomized == '1') {
            $this->db->where("randomized", 1);
        } elseif (isset($randomized) && $randomized == '0') {
            $this->db->where("(randomized = 0 or randomized is null)");
        }

        $this->db->select('cluster_no,randomized,locked');
        $this->db->from('clusters');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->group_by('cluster_no,randomized,locked');
        $this->db->order_By('cluster_no', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getClustersData($cluster)
    {
        $this->db->select('*');
        $this->db->from('clusters');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->where('cluster_no', $cluster);
        $query = $this->db->get();
        return $query->result();
    }

}