<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MHealth_camp_report extends CI_Model
{

    function getCampDetail($district, $ucs, $area)
    {
        $dist_where = 'where (colflag is null OR colflag = \'0\')  ';
        $dist_where .= " AND dist_id = '$district' ";

        if (isset($ucs) && $ucs != 0 && $ucs != '') {
            $dist_where .= " AND ucCode = '$ucs' ";
        }

        if (isset($area) && $area != 0 && $area != '') {
            $dist_where .= " AND area_no ='$area' ";
        }

        $sql_query = "SELECT  district,ucName,area_name,execution_date,execution_duration,camp_no FROM camps  $dist_where ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getReport($district, $ucs, $area, $type)
    {
        $dist_where = "where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = 0) 
         AND username!='abcdabcd' AND username!='user0001'  AND username!='user0002' ";
        $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or camp_patient_dtl.mh04 = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if (isset($area) && $area != 0 && $area != '') {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";
        }
        if (isset($type) && $type == 'u2ym') {
            $dist_where .= " AND mh010 = 1 AND ( mh09y * 12 ) + mh09m < 24 ";
        } elseif (isset($type) && $type == 'u2yf') {
            $dist_where .= " AND mh010 = 2 AND ( mh09y * 12 ) + mh09m < 24 ";
        } elseif (isset($type) && $type == 'u24mm') {
            $dist_where .= " AND mh010 = 1  AND ( mh09y * 12 ) + mh09m >= 24 AND ( mh09y * 12 ) + mh09m < 60 ";
        } elseif (isset($type) && $type == 'u24mf') {
            $dist_where .= " AND mh010 = 2 AND ( mh09y * 12 ) + mh09m >= 24 AND ( mh09y * 12 ) + mh09m < 60 ";
        } elseif (isset($type) && $type == 'u60mm') {
            $dist_where .= " AND mh010 = 1 AND ( mh09y * 12 ) + mh09m >= 60 AND ( mh09y * 12 ) + mh09m <= 168";
        } elseif (isset($type) && $type == 'u60mf') {
            $dist_where .= " AND mh010 = 2 AND ( mh09y * 12 ) + mh09m >= 60 AND ( mh09y * 12 ) + mh09m <= 168 ";
        } elseif (isset($type) && $type == 'u14m') {
            $dist_where .= " AND mh010 = 1 AND ( mh09y * 12 ) + mh09m > 168";
        } elseif (isset($type) && $type == 'u14f') {
            $dist_where .= " AND mh010 = 2 AND ( mh09y * 12 ) + mh09m > 168";
        } elseif (isset($type) && $type == 'totmale') {
            $dist_where .= " AND mh010 = 1";
        } elseif (isset($type) && $type == 'totfemale') {
            $dist_where .= " AND mh010 = 2 ";
        } elseif (isset($type) && $type == 'givenroutinem') {
            $dist_where .= " AND mh010 = 1 AND mh027b=1  AND ( mh09y * 12 ) + mh09m <=59 ";
        } elseif (isset($type) && $type == 'givenroutinef') {
            $dist_where .= " AND mh010 = 2 AND mh027b=1  AND ( mh09y * 12 ) + mh09m <=59 ";
        } elseif (isset($type) && $type == 'givenTT') {
            $dist_where .= " AND mh010 = 2 AND mh021=1";
        } elseif (isset($type) && $type == 'zeroRIu2m') {
            $dist_where .= " AND mh010 = 1 AND mh023=2 AND mh027b=2 AND ( mh09y * 12 ) + mh09m < 24";
        } elseif (isset($type) && $type == 'zeroRIu2f') {
            $dist_where .= " AND mh010 = 2 AND mh023=2 AND mh027b=2 AND ( mh09y * 12 ) + mh09m < 24";
        } elseif (isset($type) && $type == 'siam') {
            $dist_where .= " AND mh010 = 1 AND mh027a=1  AND ( mh09y * 12 ) + mh09m <=59 ";
        } elseif (isset($type) && $type == 'siaf') {
            $dist_where .= " AND mh010 = 2 AND mh027a=1  AND ( mh09y * 12 ) + mh09m <=59";
        } elseif (isset($type) && $type == 'anc') {
            $dist_where .= " AND mh010 = 2 AND mh01701=1";
        } elseif (isset($type) && $type == 'referals') {
            $dist_where .= " AND mh028 = 1";
        } elseif (isset($type) && $type == 'ors_zincm') {
            $dist_where .= " AND mh010 = 1 AND (mh019012=12 OR mh019010=10)";
        } elseif (isset($type) && $type == 'ors_zincf') {
            $dist_where .= " AND mh010 = 2 AND (mh019012=12 OR mh019010=10)";
        } elseif (isset($type) && $type == 'amoxm') {
            $dist_where .= " AND mh010 = 1 AND mh01904=4";
        } elseif (isset($type) && $type == 'amoxf') {
            $dist_where .= " AND mh010 = 2 AND mh01904=4";
        } elseif (isset($type) && $type == 'refslip') {
            $dist_where .= " AND mh010b in (1,2,3)";
        } elseif (isset($type) && $type == 'tot') {
            $dist_where .= " ";
        }
        $sql_query = "SELECT COUNT( col_id ) as totalCnt FROM camp_patient_dtl  $dist_where ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }


}