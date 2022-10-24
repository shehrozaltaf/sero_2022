<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCard_edit extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getData($province, $district, $checklist)
    {
        $join = '';
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && $district == 0) {
            $where .= " And clusters.dist_id like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And clusters.dist_id  =  '" . $district . "' ";
        }
        if (isset($checklist) && $checklist != '' && $checklist != 0) {
            foreach ($checklist as $c => $v) {
                if (isset($v) && $v == 1) {
                    $where .= " AND vac_details.bcg LIKE '44%' ";
                }

                if (isset($v) && $v == 2) {
                    $join .= " INNER JOIN image_feedback ON vac_details.cluster_code = image_feedback.cluster_no 
                    AND vac_details.hhno = image_feedback.household 
                    AND vac_details.ec13 = image_feedback.ec13  ";
                }
            }
        }

        $sql = "SELECT
	vac_details.hhno,
	vac_details.cluster_code,
	vac_details.ec13,
	vac_details_edit.cluster_code AS alreadyEdited,
	vac_details_edit.createdByUsername as editedBy
FROM
	vac_details
	$join
	LEFT JOIN clusters ON vac_details.cluster_code = clusters.cluster_no
	LEFT JOIN vac_details_edit ON vac_details.cluster_code = vac_details_edit.cluster_code AND vac_details.hhno = vac_details_edit.hhno AND vac_details.ec13 = vac_details_edit.ec13
WHERE
 (clusters.colflag is null OR clusters.colflag = '0') AND
	vac_details.cluster_code != '' AND (
	image_feedback.bcg0 = 2
	OR image_feedback.opv0 = 2
	OR image_feedback.opv1 = 2
	OR image_feedback.opv2 = 2
	OR image_feedback.opv3 = 2
	OR image_feedback.penta1 = 2
	OR image_feedback.penta2 = 2
	OR image_feedback.penta3 = 2
	OR image_feedback.pcv1 = 2
	OR image_feedback.pcv2 = 2
	OR image_feedback.pcv3 = 2
	OR image_feedback.rv1 = 2
	OR image_feedback.rv2 = 2
	OR image_feedback.ipv0 = 2
	OR image_feedback.measles1 = 2
	OR image_feedback.measles2 = 2
	OR image_feedback.hep_b = 2
	OR image_feedback.ipv2 = 2
	OR image_feedback.tcv = 2
	OR image_feedback.dobstatus = 2
)  $where 
	
	group by vac_details.hhno,
	vac_details.cluster_code,
	vac_details.ec13,
	vac_details_edit.cluster_code,
	vac_details_edit.hhno,
	vac_details_edit.createdByUsername";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getDataEdit($cluster, $hhno, $ec = '')
    {
        $where = '';
        if (isset($cluster) && $cluster != '' && $cluster != 0) {
            $where .= " And vac_details.cluster_code =  '" . $cluster . "' ";
        }
        if (isset($hhno) && $hhno != '' && $hhno != '0') {
            $where .= " And vac_details.hhno =  '" . $hhno . "' ";
        }
        if (isset($hhno) && $hhno != '' && $hhno != '0') {
            $where .= " And vac_details.ec13 =  '" . $ec . "' ";
        }
        $sql = "SELECT
	
	vac_details.hhno,
	vac_details.cluster_code,
	vac_details.ec13,
	vac_details.ec14,
	vac_details.ec15,
	vac_details.im01,
	vac_details.im02,
	vac_details.im04dd,
	vac_details.im04mm,
	vac_details.im04yy,
	vac_details.bcg,
	vac_details.opv0,
	vac_details.opv1,
	vac_details.opv2,
	vac_details.opv3,
	vac_details.penta1,
	vac_details.penta2,
	vac_details.penta3,
	vac_details.pcv,
	vac_details.pcv2,
	vac_details.pcv3,
	vac_details.rv1,
	vac_details.rv2,
	vac_details.ipv,
	vac_details.measles1,
	vac_details.measles2,
	vac_details.hep_b,
	vac_details.ipv2,
	vac_details.tcv,
	vac_details.f01,
	vac_details.f02,
	image_feedback.bcg0 AS bcg0_val,
	image_feedback.opv0 AS opv0_val,
	image_feedback.opv1 AS opv1_val,
	image_feedback.opv2 AS opv2_val,
	image_feedback.opv3 AS opv3_val,
	image_feedback.penta1 AS penta1_val,
	image_feedback.penta2 AS penta2_val,
	image_feedback.penta3 AS penta3_val,
	image_feedback.pcv1 AS pcv1_val,
	image_feedback.pcv2 AS pcv2_val,
	image_feedback.pcv3 AS pcv3_val,
	image_feedback.rv1 AS rv1_val,
	image_feedback.rv2 AS rv2_val,
	image_feedback.ipv0 AS ipv0_val,
	image_feedback.measles1 AS measles1_val,
	image_feedback.measles2 AS measles2_val,
	image_feedback.hep_b AS hep_b_val,
	image_feedback.ipv2 AS ipv2_val,
	image_feedback.tcv AS tcv_val,
	image_feedback.dobstatus AS dob_val
FROM
	vac_details
	LEFT JOIN image_feedback ON vac_details.cluster_code = image_feedback.cluster_no AND vac_details.hhno = image_feedback.household  AND vac_details.ec13 = image_feedback.ec13
WHERE 1=1 $where 
order by id_Image_feedback desc";
        $query = $this->db->query($sql);
        return $query->result();
    }

}