<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mcard_image_status extends CI_Model
{

    function getDataImg($province, $district)
    {
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && ($district == 0 || $district == '')) {
            $where .= " And clusters.dist_id like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And clusters.dist_id like  '" . $district . "%' ";
        }


        /*( SELECT COUNT (DISTINCT i.household) FROM image_feedback i WHERE i.cluster_no = a.cluster_code ) as scoredClusters*/
        $sql = "SELECT
	a.cluster_code,
	COUNT (DISTINCT a.hhno) AS totalClusters
FROM
	vac_details a
	LEFT JOIN clusters ON a.cluster_code = clusters.cluster_no
WHERE (clusters.colflag is null OR clusters.colflag = '0'  OR clusters.colflag != '1') AND
	a.cluster_code != ''
 $where
GROUP BY
	a.cluster_code";
        $query = $this->db->query($sql);
        return $query->result();

    }

    function getDataScoredImg($province, $district)
    {
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && ($district == 0 || $district == '')) {
            $where .= " And clusters.dist_id like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And clusters.dist_id like  '" . $district . "%' ";
        }
        $sql = "SELECT
	i.cluster_no,
	i.household,
	i.ec13
FROM
	image_feedback i
	LEFT JOIN clusters ON i.cluster_no = clusters.cluster_no
WHERE (clusters.colflag is null OR clusters.colflag = '0'  OR clusters.colflag != '1') AND
	i.cluster_no != ''
 $where
GROUP BY
	i.cluster_no,
	i.household,
	i.ec13";
        $query = $this->db->query($sql);
        return $query->result();

    }

    function getDataErroredImg($province, $district)
    {
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && ($district == 0 || $district == '')) {
            $where .= " And clusters.dist_id like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And clusters.dist_id like  '" . $district . "%' ";
        }
        $sql = "SELECT
	i.cluster_no,
	i.household,
	i.ec13
FROM
	image_feedback i
	LEFT JOIN clusters ON i.cluster_no = clusters.cluster_no
WHERE (clusters.colflag is null OR clusters.colflag = '0'  OR clusters.colflag != '1') AND
	i.cluster_no != '' AND (
	i.bcg0 = 2
	OR i.opv0 = 2
	OR i.opv1 = 2
	OR i.opv2 = 2
	OR i.opv3 = 2
	OR i.penta1 = 2
	OR i.penta2 = 2
	OR i.penta3 = 2
	OR i.pcv1 = 2
	OR i.pcv2 = 2
	OR i.pcv3 = 2
	OR i.rv1 = 2
	OR i.rv2 = 2
	OR i.ipv0 = 2
	OR i.measles1 = 2
	OR i.measles2 = 2
	OR i.hep_b = 2 
	OR i.tcv = 2 
	OR i.ipv2 = 2 
	OR i.dobstatus = 2
) 
 $where
GROUP BY
	i.cluster_no,
	i.household,
	i.ec13";
        $query = $this->db->query($sql);
        return $query->result();

    }

    function getDataEditedImg($province, $district)
    {
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && ($district == 0 || $district == '')) {
            $where .= " And clusters.dist_id  like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And clusters.dist_id like  '" . $district . "%' ";
        }
        $sql = "SELECT
	v.cluster_code as cluster_no,
	v.hhno as household,
	v.ec13 as ec13
FROM
	vac_details_edit v
	LEFT JOIN clusters ON v.cluster_code = clusters.cluster_no
WHERE (clusters.colflag is null OR clusters.colflag = '0'  OR clusters.colflag != '1') AND
	v.cluster_code != ''
 $where
GROUP BY
	v.cluster_code,
	v.hhno,
	v.ec13";
        $query = $this->db->query($sql);
        return $query->result();

    }

    function getData($province, $district, $checklist)
    {
        $where = '';
        if (isset($province) && $province != '' && $province != 0 && $district == 0) {
            $where .= " And cluster_code like  '" . $province . "%' ";
        }
        if (isset($district) && $district != '' && $district != 0) {
            $where .= " And cluster_code like  '" . $district . "%' ";
        }
        if (isset($checklist) && $checklist != '' && $checklist != 0) {
            foreach ($checklist as $c => $v) {
                if (isset($v) && $v == 1) {
                    $where .= " AND bcg LIKE '44%' ";
                }
            }
        }

        $sql = "SELECT
	*
FROM
	vac_details
WHERE
	cluster_code != '' $where ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}