<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCamp extends CI_Model
{

    public $globalWhere = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            $this->globalWhere = ' ';
            $this->ucglobalWhere = ' ';
        } else {
            $this->globalWhere = ' AND districts.dist_id not like  \'9%\' ';
            $this->ucglobalWhere = ' AND ucs.districtCode not like  \'9%\' ';
        }
    }


    function getAllCamps($district, $ucs, $area, $status = '')
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (camp.ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if (isset($area) && $area != '') {
            $dist_where .= " and camp.area_no like '$area%' ";
        }

        if (isset($status) && $status != '') {
            $todate = date('Y-m-d');
            if ($status == 'c') {
                $dist_where .= " and camp.camp_status = 'Conducted'  AND  plan_date<='$todate'";
            }
            if ($status == 'r') {
                $dist_where .= " and camp.camp_status != 'Conducted'  AND  plan_date<='$todate'";
            }
            if ($status == 'l') {
                $dist_where .= " and camp.locked = '1'  AND  plan_date<='$todate' ";
            }
            if ($status == 't') {
                $dist_where .= " and   plan_date<='$todate' ";
            }
        }

        $sql_query = "SELECT
	camp.id,
	camp.dist_id,
	districts.district,
	camp.ucCode,
	UCs.ucName,
	camp.area_no,
	camp_area.area_name,
	camp.plan_date,
	camp.camp_no,
	camp.camp_status,
	camp.remarks,
	camp.execution_date,
	camp.execution_duration, 
	camp.colflag,
	camp.locked,
	camp.lockedBy,
	camp.lockedDateTime 
FROM
	dbo.camp
	LEFT JOIN districts ON camp.dist_id = districts.dist_id
	LEFT JOIN UCs ON camp.ucCode = UCs.ucCode
	LEFT JOIN dbo.camp_area ON camp.area_no = camp_area.area_no  
WHERE (camp.colflag is null OR camp.colflag = '0')
	  $dist_where
ORDER BY
	camp.camp_no DESC, camp.id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getCampDetails($district, $ucs, $area)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and camp.ucCode = '$ucs' ";
        }
        if (isset($district) && $district != '') {
            $dist_where .= " and camp.area_no like '$area%' ";
        }

        $sql_query = "SELECT
	camp.camp_no, 
	camp.camp_round, 
	camp.plan_date, 
	camp.camp_status,  
	camp.execution_date
FROM
	dbo.camp 
WHERE (camp.colflag is null OR camp.colflag = '0')
	  $dist_where
ORDER BY
	camp.id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getMaxCamp($area_no)
    {
        $dist_where = '';
        if (isset($area_no) && $area_no != '') {
            $dist_where .= " and camp.area_no like '" . $area_no . "%' ";
        }
        $sql_query = "SELECT MAX ( camp_no ) AS maxCamp 
FROM
	dbo.camp 
WHERE
	( camp.colflag IS NULL OR camp.colflag = '0' ) $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getMaxCamp2($ucs, $camp_rounds)
    {
        $dist_where = '';
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and camp.ucCode = '" . $ucs . "' ";
        }
        if (isset($camp_rounds) && $camp_rounds != '') {
            $dist_where .= " and camp.ucCode = '" . $camp_rounds . "' ";
        }
        $sql_query = "SELECT MAX
	( ucCode * 10000 ) + MAX ( camp_no ) AS maxCamp 
FROM
	dbo.camp 
WHERE
	( camp.colflag IS NULL OR camp.colflag = '0' ) $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getDrByCamp($camp)
    {
        $dist_where = '';
        if (isset($camp) && $camp != '') {
            $dist_where .= " and camp_detail.idCamp = '" . $camp . "' ";
        }

        $sql_query = "SELECT 
	camp_doctor.staff_name, 
	camp_doctor.staff_type 
FROM
	 camp_detail
	LEFT JOIN dbo.camp_doctor ON camp_detail.idDoctor = camp_doctor.idDoctor
	 where 
	( camp_detail.colflag IS NULL OR camp_detail.colflag = '0' )
	 and ( camp_doctor.colflag IS NULL OR camp_doctor.colflag = '0' ) 
	 $dist_where ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getDrByUc($ucs, $type)
    {
        $dist_where = '';
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and camp_doctor.ucCode = '" . $ucs . "' ";
        }
        if (isset($type) && $type != '' && $type != '0') {
            $dist_where .= " and camp_doctor.staff_type = '" . $type . "' ";
        }
        $sql_query = "SELECT
	camp_doctor.idDoctor, 
	camp_doctor.staff_name, 
	camp_doctor.staff_type
FROM
	camp_doctor  
WHERE
	( camp_doctor.colflag IS NULL OR camp_doctor.colflag = '0' ) $dist_where
ORDER BY
	camp_doctor.idDoctor DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getAreasByUc($ucs, $filter)
    {
        $dist_where = '';
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and camp_area.ucCode = '" . $ucs . "' ";
        }

        if (isset($filter) && $filter == 1) {
            $sql_query = "SELECT
	camp_area.idCampArea,
	camp_area.ucCode,
	camp_area.area_no,
	camp_area.area_name,
	camp_area.remarks,
	camp_area.dist_id,
	camp_patient_dtl.mh02 
FROM
	camp_area  
	LEFT JOIN dbo.camp ON camp_area.area_no = camp.area_no
	LEFT JOIN dbo.camp_patient_dtl ON camp.camp_no = camp_patient_dtl.mh02 
WHERE
	( camp_area.colflag IS NULL OR camp_area.colflag = '0' ) AND camp_patient_dtl.mh02 != ''
	 $dist_where
GROUP BY
	camp_area.idCampArea,
	camp_area.ucCode,
	camp_area.area_no,
	camp_area.area_name,
	camp_area.remarks,
	camp_area.dist_id,
	camp_patient_dtl.mh02 
ORDER BY
	camp_patient_dtl.mh02 DESC, camp_area.idCampArea DESC";
        } else {
            $sql_query = "SELECT
	camp_area.idCampArea,
	camp_area.ucCode,
	camp_area.area_no,
	camp_area.area_name,
	camp_area.remarks,
	camp_area.dist_id 
FROM
	camp_area   
WHERE
	( camp_area.colflag IS NULL OR camp_area.colflag = '0' )  
	 $dist_where 
ORDER BY
	camp_area.idCampArea DESC";
        }
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getAllDoctors($district, $ucs)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp_doctor.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or camp_doctor.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql_query = "SELECT
	camp_doctor.idDoctor,
	camp_doctor.dist_id,
	camp_doctor.ucCode,
	camp_doctor.staff_type,
	camp_doctor.staff_name,
	districts.district,
	UCs.ucName 
FROM
	camp_doctor
	LEFT JOIN dbo.districts ON camp_doctor.dist_id = districts.dist_id
	LEFT JOIN dbo.UCs ON camp_doctor.ucCode = UCs.ucCode 
WHERE
	( camp_doctor.colflag IS NULL OR camp_doctor.colflag = '0' ) $dist_where
ORDER BY
	camp_doctor.idDoctor DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getEditCampDoctor($idDoctor)
    {
        $this->db->select('*');
        $this->db->from('camp_doctor');
        $this->db->where('idDoctor', $idDoctor);
        $query = $this->db->get();
        return $query->result();
    }

    /*=============================Camp Status=================================*/

    function getDist($district, $ucs = '')
    {
        $dist_where = 'where (districts.colflag is null OR districts.colflag = \'0\') AND (UCs.colflag is null OR UCs.colflag = \'0\') ' . $this->globalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " AND districts.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or UCs.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }
        $dist_where .= ' AND UCs.arm =1';
        $sql_query = "SELECT
	districts.dist_id,
	districts.district 
FROM
	dbo.districts
LEFT JOIN dbo.UCs ON districts.dist_id = UCs.districtCode  
 $dist_where 
 GROUP BY  districts.dist_id,
	districts.district 
order by districts.dist_id asc";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalCampsByDict($district, $ucs, $campStatus, $locked)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (camp.ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }
        $todate = date('Y-m-d');
        if (isset($campStatus) && $campStatus == 1) {
            $dist_where .= " AND ( camp_status = 'Planned' OR camp_status = 'Conducted' ) AND  plan_date<='$todate' ";
        }
        if (isset($campStatus) && $campStatus == 2) {
            $dist_where .= " AND (camp_status = 'Conducted' )    AND  plan_date<='$todate'";
        }
        if (isset($campStatus) && $campStatus == 3) {
            $dist_where .= " and camp_status != 'Conducted'  AND  plan_date<='$todate' ";
        }
        $sql_query = "SELECT COUNT
	( camp.id ) AS totalCamps,
	camp.dist_id,
	districts.district  
FROM
	dbo.camp
	LEFT JOIN districts ON camp.dist_id = districts.dist_id
	LEFT JOIN UCs ON camp.ucCode = UCs.ucCode 
WHERE
	( camp.colflag IS NULL OR camp.colflag = '0' )  
	$dist_where
GROUP BY
	camp.dist_id,
	districts.district 
ORDER BY
	camp.dist_id ASC;";
        $query = $this->db->query($sql_query);
        return $query->result();
    }


    function getDistUC($district, $ucs = '')
    {
        $dist_where = 'where (UCs.colflag is null OR UCs.colflag = \'0\') ' . $this->ucglobalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " AND UCs.districtCode = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or UCs.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }
        $dist_where .= ' AND UCs.arm =1';
        $sql_query = "SELECT
	UCs.ucCode,
	UCs.ucName 
FROM
	dbo.UCs 
$dist_where
GROUP BY
	UCs.ucCode,
	UCs.ucName 
ORDER BY
	UCs.ucCode ASC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalCamps($district, $ucs, $campStatus, $locked)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $exp = explode(',', $ucs);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (camp.ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }
        $todate = date('Y-m-d');
        if (isset($campStatus) && $campStatus == 1) {
            $dist_where .= " AND ( camp_status = 'Planned' OR camp_status = 'Conducted' ) AND  plan_date<='$todate' ";
        }
        if (isset($campStatus) && $campStatus == 2) {
            $dist_where .= " AND (camp_status = 'Conducted' )    AND  plan_date<='$todate'";
        }
        if (isset($campStatus) && $campStatus == 3) {
            $dist_where .= " and camp_status != 'Conducted'  AND  plan_date<='$todate' ";
        }
        if (isset($locked) && $locked == 1) {
            $dist_where .= " AND locked=1   AND  plan_date<='$todate' ";
        }
        $sql_query = "SELECT COUNT
	( camp.id ) AS totalCamps,
	camp.dist_id,
	districts.district,
	camp.ucCode,
	UCs.ucName 
FROM
	dbo.camp
	LEFT JOIN districts ON camp.dist_id = districts.dist_id
	LEFT JOIN UCs ON camp.ucCode = UCs.ucCode 
WHERE
	( camp.colflag IS NULL OR camp.colflag = '0' )  
	$dist_where
GROUP BY
	camp.dist_id,
	districts.district,
	camp.ucCode,
	UCs.ucName
ORDER BY
	camp.ucCode ASC;";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================Visitors==================*/

    function visitors_status($district, $ucs, $area, $cond)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        /* if (isset($ucs) && $ucs != '') {
             $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
         }*/

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

        if ($cond == 'total') {
            $dist_where .= "  ";
        } elseif ($cond == 'male') {
            $dist_where .= " AND mh010='1'   ";
        } elseif ($cond == 'female') {
            $dist_where .= " AND mh010='2'    ";
        } elseif ($cond == 'wra') {
            $dist_where .= " AND mh010='2' AND mh09y>=14 AND mh09y<=49 ";
        } elseif ($cond == 'mwra') {
            $dist_where .= " AND (mh020=1 OR mh021=1 OR mh01701=1 OR mh01702=2 OR mh01703=4 OR mh01704=4 OR mh017077=77) ";
        } elseif ($cond == 'u5') {
//            $dist_where .= " AND ( mh09y <= 4 OR ( mh09y = 5 AND mh09m = 0 AND mh09d = 0 ) )  ";
            $dist_where .= " AND ( mh09y < 5 )  ";
        } elseif ($cond == 'others') {
            $dist_where .= " 	AND (
		( mh010 = '1' AND mh09y >= 5 ) 
		OR ( mh010 = '2' AND mh09y >= 5 AND mh09y < 14) 
		OR ( mh010 = '2' AND mh09y > 49 ) 
	) ";
        }
        $sql_query = "SELECT COUNT ( camp_patient_dtl._id ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode
	order by UCs.ucCode ASC; ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================Children==================*/

    function children($district, $ucs, $area, $cond)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";
        }

        $dist_where .= ' AND mh09y < 5 ';

        if ($cond == 'immunized') {
            $dist_where .= " AND ( mh02601 = 1 
            OR (mh02601 = 1 or mh02602 = 2 or mh02603 = 3) 
            OR (mh02608 = 8 or mh02609 = 9 or mh026010 = 10 or mh026011 = 11)
            OR (mh026014 = 14 or mh026015 = 15 or mh026016 = 16)  
            OR (mh026017 = 17 or mh026018 = 18) AND (mh026019 = 19)
            OR (mh02605 = 5 or mh02606= 6)  )";
        } elseif ($cond == 'anthro') {
            $dist_where .= " AND (mh012!='' or  mh015!='' or  mh016!='' )  ";
        } elseif ($cond == 'medi_prescibed') {
            $dist_where .= " AND ( camp_patient_dtl.mh01901 = '1' 
                    OR camp_patient_dtl.mh019010 = '10' 
                    OR camp_patient_dtl.mh019011 = '11' 
                    OR camp_patient_dtl.mh019012 = '12' 
                    OR camp_patient_dtl.mh019013 = '13' 
                    OR camp_patient_dtl.mh019014 = '14' 
                    OR camp_patient_dtl.mh019015 = '15' 
                    OR camp_patient_dtl.mh01902 = '2' 
                    OR camp_patient_dtl.mh01903 = '3' 
                    OR camp_patient_dtl.mh01904 = '4' 
                    OR camp_patient_dtl.mh01905 = '5' 
                    OR camp_patient_dtl.mh01906 = '6' 
                    OR camp_patient_dtl.mh01907 = '7' 
                    OR camp_patient_dtl.mh019077 = '77'  )  ";
        } elseif ($cond == 'examine') {
            $dist_where .= " AND (mh01801 = 1 
	OR mh01802 = 2 
	OR mh01803 = 3 
	OR mh01804 = 4 
	OR mh01805 = 5 
	OR mh01806 = 6 
	OR mh01807 = 7 
	OR mh01808 = 8 
	OR mh01809 = 9 
	OR mh018010 = 10 
	OR mh018011 = 11 
	OR mh018012 = 12 
	OR mh018013 = 13 
	OR mh018014 = 14 
	OR mh018015 = 15 
	OR mh018016 = 16 
	OR mh018077 = 77) ";
        }

        $sql_query = "SELECT COUNT ( camp_patient_dtl._id ) AS totalCnt, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function children_top_deseases($district, $ucs, $area)
    {
        $dist_where = ' where (cp.colflag is null OR cp.colflag = \'0\')  ';
        $subdist_where = 'where (colflag is null OR colflag = \'0\')  ';

        if (isset($district) && $district != '') {
            $dist_where .= " AND cp.dist_id = '$district' ";
            $subdist_where .= " AND dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND cp.ucCode = '" . trim($ucs) . "' ";
            $subdist_where .= " AND ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND cp.mh02 like '$area%' ";
            $dist_where .= " AND mh02 like '$area%' ";
        }
        $dist_where .= ' AND mh09y < 5 ';
        $subdist_where .= ' AND mh09y < 5 ';

        $sql_query = "SELECT
    (SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01801=1) AS Diarrhea,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01802=2) AS Cough,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01803=3) AS Pneumonia,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01804=4) AS Severe_Pneumonia,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01805=5) AS Asthma,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01806=6) AS Worm_Infestation,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01807=7) AS Skin_Ailment,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01808=8) AS Eye_Infection,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh01809=9) AS Ear_Infection,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018010=10) AS Malaria,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018011=11) AS Typhoid,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018012=12) AS Tonsillitis,(
SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018013=13) AS Measles,(
SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018014=14) AS Pulmonary_TB,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018015=15) AS Sepsos,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018016=16) AS Anemia,
(SELECT COUNT (id) FROM camp_patient_dtl $subdist_where AND mh018077=77) AS Other 
FROM
	dbo.camp_patient_dtl cp 
	$dist_where 
Group by cp.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function children_top_medi_prescibed($district, $ucs, $area)
    {
        $dist_where = ' where (cp.colflag is null OR cp.colflag = \'0\')  ';
        $subdist_where = 'where (colflag is null OR colflag = \'0\')  ';

        if (isset($district) && $district != '') {
            $dist_where .= " AND cp.dist_id = '$district' ";
            $subdist_where .= " AND dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND cp.ucCode = '" . trim($ucs) . "' ";
            $subdist_where .= " AND ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND cp.mh02 like '$area%' ";
            $dist_where .= " AND mh02 like '$area%' ";
        }
        $dist_where .= ' AND mh09y < 5 ';
        $subdist_where .= ' AND mh09y < 5 ';

        $sql_query = "SELECT
    ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01901 = 1) ) AS Paracetamol, 
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01902 = 2) ) AS Metronidazole,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01903 = 3) ) AS Aminophylline_Plus_Compound,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01904 = 4) ) AS Amoxicillin,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01905 = 5) ) AS Cetirizine,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01906 = 6) ) AS Nonsteroidal_Anti_Inflammatory_Drug,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01907 = 7) ) AS Antiemetic,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01908 = 8) ) AS Antimalarial,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01909 = 9) ) AS Deworming,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019010 = 10) ) AS ORS,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019011 = 11) ) AS Folic_Acid,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019012 = 12) ) AS Zinc,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019013 = 13) ) AS Multivitamin,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019014 = 14) ) AS Calcium,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019015 = 15) ) AS Iron,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019077 = 77) ) AS Other 
FROM
	dbo.camp_patient_dtl cp 
	$dist_where 
Group by cp.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================WRA==================*/

    function wra($district, $ucs, $area, $cond)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";

        }

        $dist_where .= " AND mh010='2' AND mh09y>=14 AND mh09y<=49 ";

        if ($cond == 'anc_checkup') {
            $dist_where .= " AND mh020= '1'   ";
        } elseif ($cond == 'tetanus') {
            $dist_where .= " AND mh021= '1'   ";
        } elseif ($cond == 'physical_examine') {
            $dist_where .= "  AND (mh012!='' or  mh015!='' or  mh016!='' )  ";
        } elseif ($cond == 'medi_prescibed') {
            $dist_where .= " AND ( camp_patient_dtl.mh01901 = '1' 
                    OR camp_patient_dtl.mh019010 = '10' 
                    OR camp_patient_dtl.mh019011 = '11' 
                    OR camp_patient_dtl.mh019012 = '12' 
                    OR camp_patient_dtl.mh019013 = '13' 
                    OR camp_patient_dtl.mh019014 = '14' 
                    OR camp_patient_dtl.mh019015 = '15' 
                    OR camp_patient_dtl.mh01902 = '2' 
                    OR camp_patient_dtl.mh01903 = '3' 
                    OR camp_patient_dtl.mh01904 = '4' 
                    OR camp_patient_dtl.mh01905 = '5' 
                    OR camp_patient_dtl.mh01906 = '6' 
                    OR camp_patient_dtl.mh01907 = '7' 
                    OR camp_patient_dtl.mh019077 = '77'  )  ";
        }

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh016 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode; ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================Immunized==================*/

    function immunized($district, $ucs, $area, $cond)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";
        }

        /* if ($cond == 'Vaccines_By_Antigen') {
             $dist_where .= " AND mh020= '1'   ";
         } elseif ($cond == 'height') {
             $dist_where .= " AND   ( mh09y <= 4 OR ( mh09y = 5 AND mh09m = 0 AND mh09d = 0 ) )  and mh012!=''  ";
         } elseif ($cond == 'weight') {
             $dist_where .= " AND ( mh09y <= 4 OR ( mh09y = 5 AND mh09m = 0 AND mh09d = 0 ) )  and mh015!='' ";
         } elseif ($cond == 'muac') {
             $dist_where .= " AND ( mh09y <= 4 OR ( mh09y = 5 AND mh09m = 0 AND mh09d = 0 ) )  and mh016!=''";
         } elseif ($cond == 'Vaccination_not_Reported') {
             $dist_where .= " AND chkVaccination='1'  ";
         }*/

        if ($cond == 'Vaccines_By_Antigen') {
            $dist_where .= " AND mh020= '1'   ";
        } elseif ($cond == 'height') {
            $dist_where .= " AND   ( mh09y < 5 )  and mh012!=''  ";
        } elseif ($cond == 'weight') {
            $dist_where .= " AND (  mh09y < 5 )  and mh015!='' ";
        } elseif ($cond == 'muac') {
            $dist_where .= " AND (  mh09y < 5 )  and mh016!=''";
        } elseif ($cond == 'Vaccination_not_Reported') {
            $dist_where .= " AND chkVaccination='1'  ";
        }

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh016 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================ANC==================*/

    function anc_mwra2($district, $ucs, $area, $cond)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";
        }

        if ($cond == 'anc_checkup') {
            $dist_where .= " AND mh020= '1'   ";
        } elseif ($cond == 'tetanus') {
            $dist_where .= " AND mh021= '1'   ";
        } elseif ($cond == 'weight') {
            $dist_where .= " AND mh010='2' AND mh09y>=14 AND mh09y<=49 AND mh012 !=''  ";
        } elseif ($cond == 'medi_prescibed') {
            $dist_where .= " AND ( camp_patient_dtl.mh01901 = '1' 
                    OR camp_patient_dtl.mh019010 = '10' 
                    OR camp_patient_dtl.mh019011 = '11' 
                    OR camp_patient_dtl.mh019012 = '12' 
                    OR camp_patient_dtl.mh019013 = '13' 
                    OR camp_patient_dtl.mh019014 = '14' 
                    OR camp_patient_dtl.mh019015 = '15' 
                    OR camp_patient_dtl.mh01902 = '2' 
                    OR camp_patient_dtl.mh01903 = '3' 
                    OR camp_patient_dtl.mh01904 = '4' 
                    OR camp_patient_dtl.mh01905 = '5' 
                    OR camp_patient_dtl.mh01906 = '6' 
                    OR camp_patient_dtl.mh01907 = '7' 
                    OR camp_patient_dtl.mh019077 = '77'  )  ";
        }

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh016 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================Camp Form Status==================*/

    function camps_form_status($district, $ucs, $area)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.mh03 = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.mh04 = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 like '$area%' ";
        }

        $sql_query = "SELECT
	camp_patient_dtl.serial,
	camp_patient_dtl.mh03,
	camp_patient_dtl.mh04,
	UCs.ucName ,
	camp_area.area_name ,
	camp_patient_dtl.mh01,
	camp_patient_dtl.mh02,
	camp_patient_dtl.mh07,
	camp_patient_dtl.mh08,
	camp_patient_dtl.mh010,
	camp_patient_dtl.entrydate,
	camp_patient_dtl.userid,
	camp_patient_dtl.form_id 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.mh04 = UCs.ucCode
	LEFT JOIN dbo.camp_area ON camp_area.area_no = LEFT ( mh02, 8 ) 
	$dist_where order by camp_patient_dtl.form_id ASC";

        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*==================Camp Form Status==================*/


    function camps_health_summary($district, $ucs, $area)
    {
        $dist_where = 'where (cp.colflag is null OR cp.colflag = \'0\')  ';
        $subdist_where = 'where (colflag is null OR colflag = \'0\')  ';
//        $mh02_limit = 8;
        $mh02_limit = 12;
        if (isset($district) && $district != '') {
            $dist_where .= " AND cp.dist_id = '$district' ";
            $subdist_where .= " AND dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND cp.ucCode = '" . trim($ucs) . "' ";
            $subdist_where .= " AND ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND cp.mh02 like '$area%' ";
            $mh02_limit = 12;
        }

        $sql_query = "SELECT
    UCs.ucName ,
	camp_area.area_name ,
	LEFT ( cp.mh02, $mh02_limit ) as camp_no,
	COUNT( cp.mh010 ) AS totalGender,
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh010 = 1  AND LEFT ( mh02, $mh02_limit ) =LEFT ( cp.mh02, $mh02_limit )   ) AS totalMale,
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh010 = 2  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS totalFemale, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND ( mh09y < 5 ) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS u5,  
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND mh02601 = 1  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS bcg, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02601 = 1 or mh02602 = 2 or mh02603 = 3)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS penta, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02608 = 8 or mh02609 = 9 or mh026010 = 10 or mh026011 = 11)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS opv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026014 = 14 or mh026015 = 15 or mh026016 = 16)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS pcv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026017 = 17 or mh026018 = 18)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS rota, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026019 = 19)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS ipv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02605 = 5 or mh02606= 6)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS measles, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (chkVaccination = 1)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS vnr, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh010=2 AND mh09y>=14 AND mh09y<=49 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS wra,  
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh022=2 AND  mh023=2 AND (mh02601 = 1 or mh02602 = 2 or mh02603 = 3 or mh02608 = 8 or mh02609 = 9 or mh026010 = 10 or mh026011 = 11
	or mh026014 = 14 or mh026015 = 15 or mh026016 = 16 or  mh026017 = 17 or mh026018 = 18 or mh026019 = 19 or mh02605 = 5 or mh02606= 6) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS zeroDose,  
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh020 = 1 or mh021= 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS ancTotal, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh020 = 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS anc, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh021 = 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS tetanus
FROM
	dbo.camp_patient_dtl cp
	LEFT JOIN dbo.UCs ON cp.ucCode = UCs.ucCode
	LEFT JOIN dbo.camp_area ON camp_area.area_no = LEFT ( mh02, 8 ) 
	$dist_where 
Group by UCs.ucName ,
LEFT ( cp.mh02, $mh02_limit ),
	camp_area.area_name";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function camps_health_summary_child($district, $ucs, $area, $cond, $type = '')
    {
        $dist_where = 'where (cp.colflag is null OR cp.colflag = \'0\')  ';
        $subdist_where = 'where (colflag is null OR colflag = \'0\')  ';

        $mh02_limit = 12;
        if (isset($district) && $district != '') {
            $dist_where .= " AND cp.dist_id = '$district' ";
            $subdist_where .= " AND dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND cp.ucCode = '" . trim($ucs) . "' ";
            $subdist_where .= " AND ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND cp.mh02 like '$area%' ";
            $mh02_limit = 12;
        }

        $select = "COUNT( cp.mh010 ) AS totalGender,
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh010 = 1  AND LEFT ( mh02, $mh02_limit ) =LEFT ( cp.mh02, $mh02_limit )   ) AS totalMale,
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh010 = 2  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS totalFemale,
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND ( mh09y < 5 ) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS u5";
        if (isset($cond) && $cond != '' && $cond != '0' && $type == 'u5') {
            $dist_where .= ' AND mh09y < 5 ';
            $subdist_where .= ' AND mh09y < 5 ';
            if ($cond == 'immunization') {
                $select .= ",( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND mh02601 = 1  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS bcg, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02601 = 1 or mh02602 = 2 or mh02603 = 3)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS penta, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02608 = 8 or mh02609 = 9 or mh026010 = 10 or mh026011 = 11)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS opv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026014 = 14 or mh026015 = 15 or mh026016 = 16)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS pcv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026017 = 17 or mh026018 = 18)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS rota, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh026019 = 19)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS ipv, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (mh02605 = 5 or mh02606= 6)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS measles, 
	( SELECT COUNT ( mh02 ) FROM camp_patient_dtl $subdist_where AND (chkVaccination = 1)  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS vnr";
            } elseif ($cond == 'anthro') {
                $select .= ",  ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh012!='' AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS weightTotal, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND   mh015!=''  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS heightTotal, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND   mh016!=''  AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS muac";
            } elseif ($cond == 'examine') {
                $select .= ",  
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01801=1 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Diarrhea,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01802=2 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Cough,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01803=3 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Pneumonia,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01804=4 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Severe_Pneumonia,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01805=5 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Asthma,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01806=6 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Worm_Infestation,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01807=7 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Skin_Ailment,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01808=8 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Eye_Infection,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh01809=9 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Ear_Infection,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018010=10 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Malaria,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018011=11 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Typhoid,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018012=12 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Tonsillitis,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018013=13 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Measles,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018014=14 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Pulmonary_TB,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018015=15 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Sepsos,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018016=16 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Anemia,
                ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND mh018077=77 AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Other
                ";
            } elseif ($cond == 'anc_provided') {
                $select .= ", ( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND mh022=2 AND  mh023=2 AND (mh02601 = 1 or mh02602 = 2 or mh02603 = 3 or mh02608 = 8 or mh02609 = 9 or mh026010 = 10 or mh026011 = 11
                 or mh026014 = 14 or mh026015 = 15 or mh026016 = 16 or  mh026017 = 17 or mh026018 = 18 or mh026019 = 19 or mh02605 = 5 or mh02606= 6) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS zeroDose, 
                ( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh020 = 1 or mh021= 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS ancTotal, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh020 = 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS anc, 
	( SELECT COUNT ( mh010 ) FROM camp_patient_dtl $subdist_where AND (mh021 = 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS tetanus";
            } elseif ($cond == 'medi_prescibed') {
                $select .= ", ( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01901 = 1) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Paracetamol, 
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01902 = 2) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Metronidazole,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01903 = 3) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Aminophylline_Plus_Compound,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01904 = 4) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Amoxicillin,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01905 = 5) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Cetirizine,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01906 = 6) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Nonsteroidal_Anti_Inflammatory_Drug,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01907 = 7) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Antiemetic,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01908 = 8) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Antimalarial,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh01909 = 9) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Deworming,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019010 = 10) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS ORS,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019011 = 11) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Folic_Acid,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019012 = 12) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Zinc,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019013 = 13) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Multivitamin,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019014 = 14) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Calcium,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019015 = 15) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Iron,
	( SELECT COUNT ( id ) FROM camp_patient_dtl $subdist_where AND (mh019077 = 77) AND LEFT ( mh02, $mh02_limit ) = LEFT ( cp.mh02, $mh02_limit )) AS Other 
	";

            }
        }
        $sql_query = "SELECT
    UCs.ucName ,
	camp_area.area_name ,
	LEFT ( cp.mh02, $mh02_limit ) as camp_no,
	 $select 
FROM
	dbo.camp_patient_dtl cp
	LEFT JOIN dbo.UCs ON cp.ucCode = UCs.ucCode
	LEFT JOIN dbo.camp_area ON camp_area.area_no = LEFT ( mh02, 8 ) 
	$dist_where 
Group by UCs.ucName ,
LEFT ( cp.mh02, $mh02_limit ),
	camp_area.area_name";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}