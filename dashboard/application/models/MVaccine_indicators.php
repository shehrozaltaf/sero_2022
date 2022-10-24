<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MVaccine_indicators extends CI_Model
{

    public $globalWhere = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (isset($_SESSION['login']['idGroup']) && $_SESSION['login']['idGroup'] == 1) {
            $this->globalWhere = ' ';
        } else {
            $this->globalWhere = ' AND username not in(\'dmu@aku\',\'user0001\',\'user0002\',\'test1234\') And Children.ebCode not like \'9%\' ';
        }

    }

    function getTotalChilds($province, $district)
    {

        $dist_where = 'where (clusters.colflag is null OR clusters.colflag = \'0\') and (Children.colflag is null OR Children.colflag = \'0\') ' . $this->globalWhere;
        if (isset($province) && $province != '') {
            $dist_where .= " and SUBSTRING (clusters.dist_id, 1, 1) = '$province' ";
        }
        if (isset($district) && $district != '') {
            $exp = explode(',', $district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (clusters.dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql = "SELECT
	COUNT (Children.ebCode) AS totalChilds,
	Children.ebCode
FROM
	Children
LEFT JOIN clusters ON Children.ebCode = clusters.cluster_no
$dist_where
GROUP BY
	Children.ebCode  ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getBcg($province, $district)
    {
        $dist_where = " where im02 = 1 and (im0501yy<>' '  or im0501dd in(44,88,66) or im09=1) 
        AND (clusters.colflag is null OR clusters.colflag = '0')
        AND (Children.colflag is null OR Children.colflag = '0') " . $this->globalWhere;
        if (isset($province) && $province != '') {
            $dist_where .= " and SUBSTRING (clusters.dist_id, 1, 1) = '$province' ";
        }
        if (isset($district) && $district != '') {
            $exp = explode(',', $district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (clusters.dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql = "select count(*) as bcg from Children 
  LEFT JOIN clusters ON Children.ebCode = clusters.cluster_no $dist_where 
  GROUP BY
	Children.ebCode  ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getpenta3($province, $district)
    {
        $dist_where = " where im02 = 1 and (im0512yy<>' '  or im0512dd in(44,88,66) or im15=1) 
        AND (clusters.colflag is null OR clusters.colflag = '0')
        AND (Children.colflag is null OR Children.colflag = '0')  " . $this->globalWhere;
        if (isset($province) && $province != '') {
            $dist_where .= " and SUBSTRING (clusters.dist_id, 1, 1) = '$province' ";
        }
        if (isset($district) && $district != '') {
            $exp = explode(',', $district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (clusters.dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql = "select count(*) as penta3 from Children    
LEFT JOIN clusters ON Children.ebCode = clusters.cluster_no $dist_where 
  GROUP BY
	Children.ebCode ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getCardAvailable($province, $district)
    {
        $dist_where = " where im02=1  AND (clusters.colflag is null OR clusters.colflag = '0')
        AND (Children.colflag is null OR Children.colflag = '0')  " . $this->globalWhere;
        if (isset($province) && $province != '') {
            $dist_where .= " and SUBSTRING (clusters.dist_id, 1, 1) = '$province' ";
        }
        if (isset($district) && $district != '') {
            $exp = explode(',', $district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (clusters.dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql = "select count(*) as cardavailable from Children  
LEFT JOIN clusters ON Children.ebCode = clusters.cluster_no $dist_where 
  GROUP BY
	Children.ebCode ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
