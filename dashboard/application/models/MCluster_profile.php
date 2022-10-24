<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCluster_profile extends CI_Model
{
    function getData($district, $uc)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and clusters.dist_id= '$district' ";
        }
        if (isset($uc) && $uc != '') {
            $exp = explode(',', $uc);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or clusters.uc_id = '" . trim($d) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql_query = "SELECT
	* 
FROM
	clusters
WHERE
	1=1 $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }


}