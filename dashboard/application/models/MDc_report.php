<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MDc_report extends CI_Model
{
    function getData($from, $to, $type)
    {
        $dist_where = '';

        if (isset($from) && $from != '') {
            $dist_where .= " and CAST ( camp_patient_dtl.sysdate AS DATE ) >= '".date('Y-m-d',strtotime($from))."' ";
        }
        if (isset($to) && $to != '') {
            $dist_where .= " and CAST ( camp_patient_dtl.sysdate AS DATE ) <= '".date('Y-m-d',strtotime($to))."' ";
        }
        if (isset($type) && $type != '') {
            $dist_where .= " and users.dd  = '$type' ";
        }
        $sql_query = "SELECT COUNT
	( col_id ) AS totalCnt,
	CAST ( camp_patient_dtl.sysdate AS DATE ) AS dt, 
	users.full_name,
	users.dd 
FROM
	dbo.camp_patient_dtl
	LEFT JOIN dbo.users ON camp_patient_dtl.username = users.username 
	where (camp_patient_dtl.colflag='0' or camp_patient_dtl.colflag is null) 
	AND camp_patient_dtl.username NOT IN ( 'abcdabcd', 'user0001', 'user0002', '' ) 
	 $dist_where
GROUP BY
	CAST ( camp_patient_dtl.sysdate AS DATE ), 
	users.full_name,
	users.dd 
ORDER BY
	users.dd ASC,
	CAST ( camp_patient_dtl.sysdate AS DATE ) ASC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}