<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCommunity_mobilization extends CI_Model
{
    public $globalWhere = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if (isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            $this->globalWhere = ' ';
        } else {
            $this->globalWhere = ' AND districts.dist_id not like  \'9%\' ';
        }
    }

    function getAllCommunity_mobilizations($district, $ucs, $status = '')
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and community_mobilization.dist_id = '$district' ";
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
                $dist_where_clause .= " $or SUBSTRING (community_mobilization.ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if (isset($status) && $status != '') {
            $todate = date('Y-m-d');
            if ($status == 'c') {
                $dist_where .= " and community_mobilization.camp_status = 'Conducted'   AND  plan_date<='$todate'";
            }
            if ($status == 'r') {
                $dist_where .= " and community_mobilization.camp_status != 'Conducted'   AND  plan_date<='$todate'";
            }
            if ($status == 'l') {
                $dist_where .= " and community_mobilization.locked = '1'   AND  plan_date<='$todate'";
            }
            if ($status == 't') {
                $dist_where .= " and   plan_date<='$todate' ";
            }

        }

        $sql_query = "SELECT
	community_mobilization.id,
	community_mobilization.dist_id,
	districts.district,
	community_mobilization.ucCode,
	UCs.ucName, 
	community_mobilization.area,
	camp_area.area_name,
	community_mobilization.plan_date,
	community_mobilization.session_no,
	community_mobilization.session_type,
	community_mobilization.camp_status,
	community_mobilization.remarks,
	community_mobilization.execution_date, 
	community_mobilization.participant_gender_type,
	community_mobilization.venue,
	community_mobilization.session_topic,
	community_mobilization.session_topic_other, 
	community_mobilization.total_male,
	community_mobilization.total_female,
	community_mobilization.political_com_leaders,
	community_mobilization.religious_com_leaders,
	community_mobilization.educational_com_leaders,
	community_mobilization.businessman_com_leaders,
	community_mobilization.doctors_health_provider,
	community_mobilization.paramedics_health_provider,
	community_mobilization.lhws_health_provider,
	community_mobilization.lhvs_health_provider,
	community_mobilization.cmws_health_provider,
	community_mobilization.vaccinators_health_provider,
	community_mobilization.fcv_government_officials,
	community_mobilization.ucpw_government_officials,
	community_mobilization.ttsp_government_officials,
	community_mobilization.other_government_officials,
	community_mobilization.locked 
FROM
	community_mobilization
	LEFT JOIN districts ON community_mobilization.dist_id = districts.dist_id
	LEFT JOIN UCs ON community_mobilization.ucCode = UCs.ucCode 
	LEFT JOIN camp_area ON community_mobilization.area = camp_area.area_no 
WHERE
	( community_mobilization.colflag IS NULL OR community_mobilization.colflag = '0' ) 
	  $dist_where
ORDER BY
	community_mobilization.session_no DESC ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getMobByCamp($camp)
    {
        $dist_where = '';
        if (isset($camp) && $camp != '') {
            $dist_where .= " and community_mobilization_detail.idCM = '" . $camp . "' ";
        }

        $sql_query = "SELECT 
	camp_doctor.staff_name, 
	camp_doctor.staff_type 
FROM
	 community_mobilization_detail
	LEFT JOIN camp_doctor ON community_mobilization_detail.idMob = camp_doctor.idDoctor
	 where 
	( community_mobilization_detail.colflag IS NULL OR community_mobilization_detail.colflag = '0' )
	 and ( camp_doctor.colflag IS NULL OR camp_doctor.colflag = '0' ) 
	 $dist_where ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getCMDetails($district, $ucs)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and community_mobilization.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and community_mobilization.ucCode = '$ucs' ";
        }

        $sql_query = "SELECT
	community_mobilization.id,
	community_mobilization.dist_id,
	community_mobilization.ucCode, 
	community_mobilization.plan_date,
	community_mobilization.session_no,
	community_mobilization.session_type,
	community_mobilization.camp_status,
	community_mobilization.remarks,
	community_mobilization.execution_date, 
	community_mobilization.venue,
	community_mobilization.session_topic,
	community_mobilization.session_topic_other, 
	community_mobilization.total_male,
	community_mobilization.total_female,
	community_mobilization.political_com_leaders,
	community_mobilization.religious_com_leaders,
	community_mobilization.educational_com_leaders,
	community_mobilization.businessman_com_leaders,
	community_mobilization.doctors_health_provider,
	community_mobilization.paramedics_health_provider,
	community_mobilization.lhws_health_provider,
	community_mobilization.lhvs_health_provider,
	community_mobilization.cmws_health_provider,
	community_mobilization.vaccinators_health_provider,
	community_mobilization.fcv_government_officials,
	community_mobilization.ucpw_government_officials,
	community_mobilization.ttsp_government_officials,
	community_mobilization.other_government_officials,
	community_mobilization.locked 
FROM
	community_mobilization
WHERE (community_mobilization.colflag is null OR community_mobilization.colflag = '0')
	  $dist_where
ORDER BY
	community_mobilization.session_no DESC,  community_mobilization.id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getMaxCommunity_mobilization($district, $ucs)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and community_mobilization.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and community_mobilization.ucCode = '$ucs' ";
        }
        $sql_query = "SELECT MAX (  session_no ) AS maxCM 
FROM
	community_mobilization 
WHERE
	( community_mobilization.colflag IS NULL OR community_mobilization.colflag = '0' ) $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*=============================CM Status=================================*/

    function totalCM($district, $ucs, $campStatus, $locked)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and cm.dist_id = '$district' ";
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
                $dist_where_clause .= " $or SUBSTRING (cm.ucCode, 1, 5) = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }
        $todate = date('Y-m-d');
        if (isset($campStatus) && $campStatus == 1) {
            $dist_where .= " AND ( camp_status = 'Planned' OR camp_status = 'Conducted' )   AND  plan_date<='$todate' ";
        }
        if (isset($campStatus) && $campStatus == 2) {
            $dist_where .= " AND (camp_status = 'Conducted' )   AND  plan_date<='$todate' ";
        }
        if (isset($campStatus) && $campStatus == 3) {
            $dist_where .= " and camp_status != 'Conducted'  AND  plan_date<='$todate' ";
        }
        if (isset($locked) && $locked == 1) {
            $dist_where .= " AND locked=1   AND  plan_date<='$todate' ";
        }

        $sql_query = "SELECT COUNT
	( cm.dist_id ) AS totalCamps,
	cm.dist_id,
	districts.district,
	cm.ucCode,
	UCs.ucName 
FROM
	community_mobilization cm
	LEFT JOIN districts ON cm.dist_id = districts.dist_id
	LEFT JOIN UCs ON cm.ucCode = UCs.ucCode 
WHERE
	( cm.colflag IS NULL OR cm.colflag = '0' ) 
	  $dist_where
GROUP BY
	cm.dist_id,
	districts.district,
	cm.ucCode,
	UCs.ucName 
ORDER BY
	cm.ucCode ASC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*=============================Camp Status=================================*/


    function totalCamps($district, $ucs)
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

        $sql_query = "SELECT
	camp.dist_id,
	districts.district,
	camp.ucCode,
	UCs.ucName,
	camp.camp_status,	camp.camp_no
FROM
	dbo.camp
	LEFT JOIN districts ON camp.dist_id = districts.dist_id
	LEFT JOIN UCs ON camp.ucCode = UCs.ucCode 
WHERE (camp.colflag is null OR camp.colflag = '0')
	  $dist_where
ORDER BY
	camp.camp_status DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalVisitors($district, $ucs, $overall)
    {

        $sel = ' ';
        $grpby = ' ';

        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
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
                $dist_where_clause .= " $or camp_patient_dtl.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;

        }

        if (isset($overall) && $overall == 0) {
            $sel = ',	UCs.ucName,	UCs.ucCode ';
            $grpby = ' GROUP BY UCs.ucName,	UCs.ucCode  ';
        }

        $sql_query = "SELECT COUNT
	( camp_patient_dtl._id ) AS totalVisitors $sel 
FROM
	 [camp_patient_dtl] 
LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode 
	  $dist_where $grpby";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalImmunized($district, $ucs, $overall)
    {

        $sel = ' ';
        $grpby = ' ';
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\') 
        AND (
        mh02601=1 OR  
        mh02602=1 OR  
        mh02603=1 OR  
        mh02604=1 OR  
        mh02605=1 OR  
        mh02606=1 OR  
        mh02608=1 OR  
        mh02609=1 OR  
        mh026010=1 OR  
        mh026011=1 OR  
        mh026014=1 OR  
        mh026015=1 
       
        )';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
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
                $dist_where_clause .= " $or camp_patient_dtl.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;

        }

        if (isset($overall) && $overall == 0) {
            $sel = ',	UCs.ucName ';
            $grpby = ' GROUP BY UCs.ucName  ';
        }

        $sql_query = "SELECT COUNT
	( camp_patient_dtl.mh023 ) AS totalVisitors $sel 
FROM
	 [camp_patient_dtl] 
LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode
 
	  $dist_where $grpby";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalRefusedRoutineImmunization($district, $ucs, $overall)
    {

        $sel = ' ';
        $grpby = ' ';

//        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\') AND mh026012=1 ';
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\') AND mh027b=1 ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
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
                $dist_where_clause .= " $or camp_patient_dtl.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;

        }

        if (isset($overall) && $overall == 0) {
            $sel = ',	UCs.ucName ';
            $grpby = ' GROUP BY UCs.ucName  ';
        }

        $sql_query = "SELECT COUNT
	( camp_patient_dtl.mh026012 ) AS totalVisitors $sel 
FROM
	 [camp_patient_dtl] 
LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode
 
	  $dist_where $grpby";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalWRA_HMC($district, $ucs, $overall)
    {

        $sel = ' ';
        $grpby = ' ';

        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\') AND 
         (mh020=\'1\' or mh021=\'1\')';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
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
                $dist_where_clause .= " $or camp_patient_dtl.ucCode = '" . substr(trim($d), 0, 5) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;

        }

        if (isset($overall) && $overall == 0) {
            $sel = ',	UCs.ucName ';
            $grpby = ' GROUP BY UCs.ucName  ';
        }

        $sql_query = "SELECT COUNT
	( camp_patient_dtl.mh023 ) AS totalVisitors $sel 
FROM
	 [camp_patient_dtl] 
LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode
 
	  $dist_where $grpby";
        $query = $this->db->query($sql_query);
        return $query->result();
    }


    function patient_prescribed($district, $ucs, $area)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 = '$area' ";
        }

        $dist_where .= " AND (
		camp_patient_dtl.mh01801 = '1' 
		OR camp_patient_dtl.mh018010 = '1' 
		OR camp_patient_dtl.mh018011 = '1' 
		OR camp_patient_dtl.mh018012 = '1' 
		OR camp_patient_dtl.mh018013 = '1' 
		OR camp_patient_dtl.mh018014 = '1' 
		OR camp_patient_dtl.mh018015 = '1' 
		OR camp_patient_dtl.mh018016 = '1' 
		OR camp_patient_dtl.mh01802 = '1' 
		OR camp_patient_dtl.mh01803 = '1' 
		OR camp_patient_dtl.mh01804 = '1' 
		OR camp_patient_dtl.mh01805 = '1' 
		OR camp_patient_dtl.mh01806 = '1' 
		OR camp_patient_dtl.mh01807 = '1' 
		OR camp_patient_dtl.mh018077 = '1' 
		OR camp_patient_dtl.mh018077x = '1' 
		OR camp_patient_dtl.mh01808 = '1' 
		OR camp_patient_dtl.mh01809 = '1' 
		OR camp_patient_dtl.mh01901 = '1' 
		OR camp_patient_dtl.mh019010 = '1' 
		OR camp_patient_dtl.mh019011 = '1' 
		OR camp_patient_dtl.mh019012 = '1' 
		OR camp_patient_dtl.mh019013 = '1' 
		OR camp_patient_dtl.mh019014 = '1' 
		OR camp_patient_dtl.mh019015 = '1' 
		OR camp_patient_dtl.mh01902 = '1' 
		OR camp_patient_dtl.mh01903 = '1' 
		OR camp_patient_dtl.mh01904 = '1' 
		OR camp_patient_dtl.mh01905 = '1' 
		OR camp_patient_dtl.mh01906 = '1' 
		OR camp_patient_dtl.mh01907 = '1' 
		OR camp_patient_dtl.mh019077 = '1' 
		OR camp_patient_dtl.mh019077x = '1' 
	) ";

        $sql_query = "SELECT
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode  
	  $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function patient_weight_done($district, $ucs, $area)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 = '$area' ";
        }

        $dist_where .= " AND mh012!= ''   ";

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh012 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function patient_height_done($district, $ucs, $area)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 = '$area' ";
        }

        $dist_where .= " AND mh015!= ''  ";

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh015 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function muac_done($district, $ucs, $area)
    {
        $dist_where = 'where (camp_patient_dtl.colflag is null OR camp_patient_dtl.colflag = \'0\')  ';
        if (isset($district) && $district != '') {
            $dist_where .= " AND camp_patient_dtl.dist_id = '$district' ";
        }

        if (isset($ucs) && $ucs != '') {
            $dist_where .= " AND camp_patient_dtl.ucCode = '" . trim($ucs) . "' ";
        }

        if (isset($area) && $area != 0) {
            $dist_where .= " AND camp_patient_dtl.mh02 = '$area' ";
        }

        $dist_where .= " AND mh016!= ''   ";

        $sql_query = "SELECT COUNT ( camp_patient_dtl.mh016 ) AS totalVisitors, 
	UCs.ucName,
	UCs.ucCode 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.UCs ON camp_patient_dtl.ucCode = UCs.ucCode  
	  $dist_where GROUP BY
	UCs.ucName,
	UCs.ucCode ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}