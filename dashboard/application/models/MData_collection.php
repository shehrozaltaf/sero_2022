<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MData_collection extends CI_Model
{
    public $globalWhere = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            $this->globalWhere = ' ';
        } else {
            $this->globalWhere = ' AND c.geoarea not like \'test%\' and c.dist_id not like  \'9%\' ';
        }
    }

    /*============================ Data Collection Province & District Start ============================*/
    function total_rand_clusters($district, $sub_district = '', $pageLevel = 1)
    {
        $dist_where = 'where  (c.colflag is null OR c.colflag = \'0\')   ' . $this->globalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " and SUBSTRING (dist_id, 1, 1) = '$district' ";
        }
        if (isset($sub_district) && $sub_district != '') {
            $exp = explode(',', $sub_district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if ($pageLevel == 2) {
            $selectQ = "  c.district, SUBSTRING (c.dist_id, 1, 3) AS dist_id, ";
            $groupQ = "  c.district, SUBSTRING (c.dist_id, 1, 3) ";
            $orderQ = " dist_id asc ";
        } else {
            $selectQ = " SUBSTRING (c.dist_id, 1, 1) AS dist_id, ";
            $groupQ = " SUBSTRING (c.dist_id, 1, 1) ";
            $orderQ = " dist_id asc ";
        }

        $sql_query = "SELECT $selectQ
SUM ( CASE WHEN randomized = '1' THEN 1 ELSE 0 END ) randomized_c
FROM clusters c $dist_where
GROUP BY $groupQ
ORDER BY $orderQ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function completed_rand_Clusters_district($district, $sub_district = '', $pageLevel = 1)
    {

        $dist_where = $this->globalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " and SUBSTRING (dist_id, 1, 1) = '$district' ";
        }
        if (isset($sub_district) && $sub_district != '') {
            $exp = explode(',', $sub_district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if ($pageLevel == 2) {
            $str = 3;
        } else {
            $str = 1;
        }
        $sql_query = "select SUBSTRING (c.dist_id, 1, $str) as provinceId, c.cluster_no,
			(select count(*) from Randomised where dist_id = c.dist_id and hh02 = c.cluster_no  AND (Randomised.colflag is null OR Randomised.colflag = '0')) as hh_randomized,
			( SELECT 	COUNT (distinct f.hhid)  FROM forms f LEFT JOIN Randomised bl ON f.ebCode = bl.hh02 AND f.hhid = RIGHT (bl.compid, 10)
 WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.ebCode = c.cluster_no ) AS hh_collected
			from clusters c where (c.colflag is null OR c.colflag = '0')   $dist_where  order by c.dist_id";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*============================ Data Collection Province & District End ============================*/


    function get_data_collection_rand_table($district, $cluster_type = '', $sub_district = '', $sysdate = '')
    {
        $dist_where = ' and  c.geoarea not like \'test%\' ';
        if (isset($district) && $district != '' && $sub_district == '') {
            $dist_where .= " and SUBSTRING (c.dist_id, 1, 1) = '$district' ";
        } elseif (isset($sub_district) && $sub_district != '') {
            $dist_where .= " and SUBSTRING (c.dist_id, 1, 3) = '$sub_district' ";
        }

        if (isset($cluster_type) && $cluster_type == 't') {
            $cluster_type_where = " ";
        } elseif (isset($cluster_type) && $cluster_type == 'c') {
            $cluster_type_where = " AND ( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.ebCode = bl.hh02 AND f.hhid = RIGHT (bl.compid, 10)
 WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.ebCode = c.cluster_no   ) >=18 ";
        } elseif (isset($cluster_type) && $cluster_type == 'i') {
            $cluster_type_where = " AND (SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.ebCode = bl.hh02 AND f.hhid = RIGHT (bl.compid, 10)
 WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.ebCode = c.cluster_no  )<18 ";
        } elseif (isset($cluster_type) && $cluster_type == 'r') {
            $cluster_type_where = " and  c.randomized = '1' ";
        } else {
            $cluster_type_where = '';
        }

        if (isset($sysdate) && $sysdate != '') {
            $sysdate_join = " left join  forms ff on  ff.ebCode = c.cluster_no ";
            $sysdate_where = " and  ff.sysdate like '$sysdate%'  ";
        } else {
            $sysdate_join = '';
            $sysdate_where = '';
        }
        $sql_query = "select c.dist_id as enumcode, c.cluster_no as hh02, c.geoarea,
(select count(*) from Randomised where dist_id = c.dist_id and hh02 = c.cluster_no  AND (Randomised.colflag is null OR Randomised.colflag = '0')) as randomized_households,
  
( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.ebCode = bl.hh02 AND f.hhid = RIGHT (bl.compid, 10)
 WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.ebCode = c.cluster_no ) as collected_forms,   
(select count(distinct hhid) from forms where  ebCode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus=1 ) as completed_forms, 
(select count(distinct hhid) from forms where  ebCode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus=4 ) as refused_forms,  
(select count(distinct hhid) from forms where  ebCode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (2,3,5,6,96)) as remaining_forms,
(select count(distinct hhid) from Children where  ebCode = c.cluster_no AND (Children.colflag is null OR Children.colflag = '0')  and g01=1 and trueageinmonths between 6 and 11) as child_6_11months,  
(select count(distinct hhid) from Children where  ebCode = c.cluster_no AND (Children.colflag is null OR Children.colflag = '0')  and g01=1 and trueageinmonths between 12 and 23) as child_12_23months,  
(select count(  g01) from Children where  ebCode = c.cluster_no AND (Children.colflag is null OR Children.colflag = '0')  and g01=1 ) as sample_taken  
from clusters c 
$sysdate_join 
where     (c.colflag is null OR c.colflag = '0')  
$dist_where $cluster_type_where $sysdate_where
group by c.dist_id, c.cluster_no,c.geoarea
order by c.dist_id,c.cluster_no";

        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_randomizedHH($cluster)
    {
        $sql_query = "select hh02, sno,  (tabNO + '-'+ RIGHT(compid, 8)) AS hhno from Randomised 
where hh02 = '$cluster'  AND (Randomised.colflag is null OR Randomised.colflag = '0') order by cast(sno as int)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_HH_status($cluster, $hhno)
    {
        $sql_query = "SELECT
	f.istatus,
(SELECT f01 FROM Children WHERE ebCode=f.ebCode and  hhid = f.hhid AND (Children.colflag IS NULL OR Children.colflag ='0') ) AS sample_collected,
(select trueageinmonths from Children where  ebCode = f.ebCode and  hhid = f.hhid  AND (Children.colflag is null OR Children.colflag = '0') and trueageinmonths between 6 and 11) as child_6_11months,  
(select trueageinmonths from Children where  ebCode = f.ebCode and  hhid = f.hhid  AND (Children.colflag is null OR Children.colflag = '0') and trueageinmonths between 12 and 23) as child_12_23months
FROM
	forms f 
WHERE f.ebCode = '$cluster' AND f.hhid = '$hhno'  AND (f.colflag is null OR f.colflag = '0') 
ORDER BY f.col_id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_collectedHH($cluster)
    {
        $sql_query = "select distinct ebCode, hhid,istatus from forms 
where ebCode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (1,2,3,4,5,6,7,96)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_completedHH($cluster)
    {
        $sql_query = "select distinct ebCode, hhid,istatus from forms 
where ebCode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (1)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_refusedHH($cluster)
    {
        $sql_query = "select distinct ebCode, hhid,istatus from forms 
where ebCode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus =4";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}