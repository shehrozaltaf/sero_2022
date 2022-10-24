<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MReview_check extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getDataImages($cluster, $hhno, $child)
    {
        $this->db->select("
        vac_details.ec14,
	vac_details.ec15,
	vac_details.im01,
	vac_details.im02,
	vac_details.im04dd,
	vac_details.im04mm,
	vac_details.im04yy,
	vac_details.bcg as bcg0,
	vac_details.opv0,
	vac_details.opv1,
	vac_details.opv2,
	vac_details.opv3,
	vac_details.penta1,
	vac_details.penta2,
	vac_details.penta3,
	vac_details.pcv as pcv1,
	vac_details.pcv2,
	vac_details.pcv3,
	vac_details.rv1,
	vac_details.rv2,
	vac_details.ipv as ipv0,
	vac_details.measles1,
	vac_details.measles2,
	vac_details.hep_b,
	vac_details.ipv2,
	vac_details.tcv,
	vac_details.f01,
	vac_details.f02,
	image_feedback.cluster_no,
	image_feedback.household,
	image_feedback.child_ec14,
	image_feedback.ec13,
	image_feedback.image_status,
	image_feedback.bcg0 as bcg0_val,
	image_feedback.opv0 as opv0_val,
	image_feedback.opv1 as opv1_val,
	image_feedback.opv2 as opv2_val,
	image_feedback.opv3 as opv3_val,
	image_feedback.penta1 as penta1_val,
	image_feedback.penta2 as penta2_val,
	image_feedback.penta3 as penta3_val,
	image_feedback.pcv1 as pcv1_val,
	image_feedback.pcv2 as pcv2_val,
	image_feedback.pcv3 as pcv3_val,
	image_feedback.rv1 as rv1_val,
	image_feedback.rv2 as rv2_val,
	image_feedback.ipv0 as ipv0_val,
	image_feedback.measles1 as measles1_val,
	image_feedback.measles2 as measles2_val,
	image_feedback.hep_b AS hep_b_val,
	image_feedback.ipv2 AS ipv2_val,
	image_feedback.tcv AS tcv_val,
	image_feedback.dobstatus as dobstatus_val,
	image_feedback.createdBy,
	image_feedback.createdDatetime
	");
        $this->db->from('image_feedback');
        $this->db->join('vac_details', 'image_feedback.cluster_no = vac_details.cluster_code AND image_feedback.household = vac_details.hhno AND image_feedback.ec13 = vac_details.ec13', 'LEFT');
        $this->db->where('image_feedback.cluster_no', $cluster);
        $this->db->where('image_feedback.household', $hhno);
        $this->db->where('image_feedback.ec13', $child);
        $this->db->where("REPLACE(vac_details.f01, ';', '|') NOT LIKE '%|%'");
        $query = $this->db->get();
        return $query->result();
    }

    function getProvince_District($pro)
    {
        if (isset($pro) && $pro != '') {
            $this->db->where("clusters.dist_id like '" . $pro . "%' ");
        }
        $this->db->select("image_feedback.cluster_no,clusters.geoarea,clusters.dist_id");
        $this->db->from('image_feedback');
        $this->db->join('clusters', 'image_feedback.cluster_no = clusters.cluster_no', 'LEFT');

        $this->db->where('image_feedback.cluster_no !=', '');
        $this->db->where('clusters.geoarea not like \'test%\' ');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->group_by('image_feedback.cluster_no');
        $this->db->group_by('clusters.dist_id');
        $this->db->group_by('clusters.geoarea');
        $query = $this->db->get();
        return $query->result();
    }

    function getClusters($dist)
    {
        $this->db->select("image_feedback.cluster_no as cluster_code");
        $this->db->from('image_feedback');
        $this->db->join('clusters', 'image_feedback.cluster_no = clusters.cluster_no', 'LEFT');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('image_feedback.cluster_no  !=', '');
        $this->db->where("clusters.dist_id = '" . $dist . "' ");
        $this->db->group_by('image_feedback.cluster_no');
        $query = $this->db->get();
        return $query->result();
    }

    function gethhnoByClust($cluster_code)
    {
        $this->db->select("household as hhno");
        $this->db->from('image_feedback');
        $this->db->where('cluster_no', $cluster_code);
        $this->db->group_by('household');
        $query = $this->db->get();
        return $query->result();
    }

    function getChildByHH($cluster_code, $hh)
    {
        $this->db->select("ec13");
        $this->db->from('image_feedback');
        $this->db->where('cluster_no', $cluster_code);
        $this->db->where('household', $hh);
        $this->db->group_by('ec13');
        $query = $this->db->get();
        return $query->result();
    }

    function checkExistData($cluster, $hhno, $childNo)
    {
        $this->db->select("*");
        $this->db->from('image_feedback_comments');
        $this->db->where('cluster_no', $cluster);
        $this->db->where('household', $hhno);
        $this->db->where("ec13", $childNo);
        $query = $this->db->get();
        return $query->result();
    }

}