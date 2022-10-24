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

    function trackLogs($array, $log_type)
    {
        date_default_timezone_set("Asia/Karachi");
        $UserName = (isset($array['username']) ? $array['username'] : $this->encrypt->decode($_SESSION['login']['username']));

        if ($_SERVER['SERVER_NAME'] == 'vcoe1.aku.edu' || $_SERVER['SERVER_NAME'] == 'vcoe1') {
            $logFileDirPath = 'E:/';
        } else {
            $logFileDirPath = 'C:/';
        }
        $logFileDirPath .= 'PortalFiles/JSONS/enp/dashboardLogs/';

        if (!is_dir($logFileDirPath)) {
            mkdir($logFileDirPath, 0777, TRUE);
        }
        $logFilePath = $logFileDirPath . $UserName . 'logs_' . date("n_j_Y") . '.txt';
        $activityName = (isset($array['activityName']) ? $array['activityName'] : 'Invalid activityName');
        $action = (isset($array['action']) ? $array['action'] : 'Invalid Action');
        $affectedKey = (isset($array['affectedKey']) ? $array['affectedKey'] : '');
        $postData = '';
        if (isset($array['PostData']) && $array['PostData'] != '') {
            foreach ($array['PostData'] as $key => $post) {
                $postData .= $key . ' = ' . $post . PHP_EOL;
            }
        }
        $idUser = (isset($array['idUser']) ? $array['idUser'] : $this->encrypt->decode($_SESSION['login']['idUser']));
        $result = (isset($array['result']) ? $array['result'] : 'Invalid Result');
        $Query = (isset($array['Query']) && $array['Query'] != '' ? $array['Query'] : '');
        $log = "UserIPAddress: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F-j-Y g:i a") . PHP_EOL .
            "idUser: " . $idUser . ", UserName: " . $UserName . PHP_EOL .
            "Action: " . $action . PHP_EOL .
            "Query: " . $Query . PHP_EOL .
            "AffectedKey: " . $affectedKey . PHP_EOL .
            "Result: " . $result . PHP_EOL .
            "PostData: " . $postData . PHP_EOL .
            "-------------------------------------------------" . PHP_EOL;
        if ($log_type == 'table_logs' || $log_type == 'all_logs') {
            $formArray = array();
            $formArray['idUser'] = $idUser;
            $formArray['activityName'] = $activityName;
            $formArray['actiontype'] = $action;
            $formArray['affectedKey'] = $affectedKey;
            $formArray['result'] = $result;
            $formArray['postData'] = $postData;
            $formArray['isActive'] = 1;
            $formArray['createdBy'] = $idUser;
            $formArray['createdDateTime'] = date('Y-m-d H:m:s');
            $this->Insert($formArray, 'id', 'users_dash_activity', 'N');
        }
        if ($log_type == 'user_logs' || $log_type == 'all_logs') {
            $txt = fopen($logFilePath, "a") or die("Unable to open file!");
            fwrite($txt, $log);
            fclose($txt);
        }
    }

    /*==========Log=============*/

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
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("cluster_no NOT LIKE '9%' ");
        }

        $this->db->select('	province,
	SUBSTRING (dist_id, 1, 1) AS pid');
        $this->db->from('clusters');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->group_by('province');
        $this->db->group_by('SUBSTRING (dist_id, 1, 1)');
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
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
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
        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
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




    function getClustersByUC($ucs)
    {
        if (isset($ucs) && $ucs != '') {
            $this->db->where(" UCs.ucCode = '" . $ucs . "' ");
        }
        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("UCs.ucCode NOT LIKE '9%' ");
        }
        $this->db->select('clusters.cluster_no');
        $this->db->from('clusters');
        $this->db->join('UCs', 'LEFT ( clusters.cluster_no, 3 ) = UCs.ucCode', 'left');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->group_by('clusters.cluster_no');
        $this->db->order_By('clusters.cluster_no', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getDistricts($ucs = '')
    {
        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = '   (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or dist_id = '" . trim($d) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("dist_id NOT LIKE '9%' ");
        }

        $this->db->select('dist_id,district');
        $this->db->from('districts');
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->group_by('dist_id');
        $this->db->group_by('district');
        $this->db->order_By('dist_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    /*=========tpvics shruc=============*/
    function getUcs_District($district, $ucs = '', $arms = '')
    {
        if (isset($district) && $district != '') {
            $this->db->where("districtCode", $district);
        }

        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = '   (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $this->db->where($dist_where_clause);
        }

        if (isset($arms) && $arms != '') {
            $this->db->where("arm", $arms);
        }

        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("ucCode NOT LIKE '9%' ");
        }

        $this->db->select('ucCode,ucName');
        $this->db->from('UCs');
        $this->db->group_by('ucCode');
        $this->db->group_by('ucName');
        $this->db->order_By('ucName', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getClusters_UC($ucs, $randomized = '')
    {
        if (isset($ucs) && $ucs != '') {
            $this->db->where(" clusters.uc_id = '" . $ucs . "' ");
        }
        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("clusters.uc_id NOT LIKE '9%' ");
        }
        if (isset($randomized) && $randomized == '1') {
            $this->db->where("clusters.randomized", 1);
        } elseif (isset($randomized) && $randomized == '0') {
            $this->db->where("(clusters.randomized = 0 or clusters.randomized is null)");
        }

        $this->db->select('clusters.cluster_no,clusters.randomized,clusters.locked,clusters.uc_id');
        $this->db->from('clusters');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->group_by('clusters.cluster_no,clusters.randomized,clusters.locked,clusters.uc_id');
        $this->db->order_By('clusters.cluster_no', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    // Generate password
    public static function genPassword($password, $salt, $algorithm = '')
    {
        $key_length = 16;
        $saltSize = 16;
        $iterations = 1000;
        if (!isset($algorithm) || $algorithm == '') {
            $algorithm = 'sha1';  // sha1 OR sha512
        }

        $output = hash_pbkdf2(
            $algorithm,
            $password,
            $salt,
            $iterations,
            $key_length / 8,
            true                // IMPORTANT
        );
        // echo base64_encode($salt.$output)."\n";
        return base64_encode($salt . $output);
    }

    // Compare old and new password
    public static function checkPassword($password, $oldPasswordHash)
    {
        $key_length = 16;
        $saltSize = 16;
        $iterations = 1000;
        $salt = substr(base64_decode($oldPasswordHash), 0, $saltSize);
        echo $oldPasswordHash . "\n";
        $genPass = self::genPassword($password, $salt);
        if ($genPass == $oldPasswordHash) {
            return "true";
        } else {
            return "false";
        }
    }

}