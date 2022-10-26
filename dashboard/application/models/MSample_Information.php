<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MSample_Information extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getProv_district($province, $district, $cluster)
    {
        $where = '';
        if (isset($province) && $province != '') {
            $where .= " and c.province='" . $province . "' ";
        }
        if (isset($district) && $district != '') {
            $where .= " and c.dist_id='" . $district . "' ";
        }
        if (isset($cluster) && $cluster != '') {
            $where .= " and c.cluster_no='" . $cluster . "' ";
        }
        $sql_query = "SELECT
	c.province,
	c.district,
	c.dist_id,
	d.ebCode,
	f.hh13,
	d.ec01,
	d.ec02,
	d.ec12,
	d.childname,
	d.g01,
	d.g04 
FROM
	Clusters c
	LEFT JOIN Children d ON c.cluster_no= d.ebCode
	LEFT JOIN forms f ON c.cluster_no= f.ebCode 
	AND d.ebCode= f.ebCode 
	AND d.hhid= d.hhid 
	AND d.childlno= d.childlno 
	AND d._uuid= f._uid 
WHERE
	g01 =1 $where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }


}