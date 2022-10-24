<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mimage_forms extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getDataImages($cluster, $hhno, $child)
    {
        $this->db->select("*");
        $this->db->from('vac_details');
        $this->db->where('f01  !=', '');
        $this->db->where('cluster_code', $cluster);
        $this->db->where('hhno', $hhno);
        $this->db->where('ec13', $child);
        $this->db->where("REPLACE(f01, ';', '|') NOT LIKE '%|%'");

        $query = $this->db->get();
        return $query->result();
    }

    function getProvince_District($pro)
    {
        if (isset($pro) && $pro != '') {
            $this->db->where("clusters.dist_id like '" . $pro . "%' ");
        }
        $this->db->select("vac_details.cluster_code,clusters.geoarea,clusters.dist_id");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'INNER');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('vac_details.cluster_code !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
//        $this->db->where('clusters.geoarea not like \'test%\' ');
        $this->db->group_by('vac_details.cluster_code');
        $this->db->group_by('clusters.dist_id');
        $this->db->group_by('clusters.geoarea');
        $query = $this->db->get();
        return $query->result();
    }

    function getClusters($dist)
    {
        $this->db->select("vac_details.cluster_code");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'LEFT');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('vac_details.cluster_code  !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
//        $this->db->where("cluster_code like '" . $dist . "%' ");
        $this->db->where("clusters.dist_id = '" . $dist . "' ");
        $this->db->group_by('vac_details.cluster_code');
        $query = $this->db->get();
        return $query->result();
    }

    function gethhnoByClust($cluster_code)
    {
        $this->db->select("hhno");
        $this->db->from('vac_details');
        $this->db->where('im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->group_by('hhno');
        $query = $this->db->get();
        return $query->result();
    }

    function getChildByHH($cluster_code, $hh)
    {
        $this->db->select("ec13");
        $this->db->from('vac_details');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->where('hhno', $hh);
        $this->db->group_by('ec13');
        $query = $this->db->get();
        return $query->result();
    }

    function checkExistData($cluster, $hhno, $childNo = '')
    {
        if (isset($childNo) && $childNo != '') {
            $this->db->where("ec13", $childNo);
        }
        $this->db->select("*");
        $this->db->from('image_feedback');
        $this->db->where('cluster_no', $cluster);
        $this->db->where('household', $hhno);
        $this->db->order_by('id_Image_feedback','asc');
        $query = $this->db->get();
        return $query->result();
    }

}