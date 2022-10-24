<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MSurveyReport extends CI_Model
{
    function getData($province,$district)
    {
        $dist_where='';
        if (isset($province) && $province != '') {
            $dist_where .= " and SUBSTRING (clusters.dist_id, 1, 1) = '$province' ";
        }
        if (isset($district) && $district != '') {
            $exp = explode(',', $district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or SUBSTRING (clusters.dist_id, 1, 3) = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        $sql_query = "SELECT
	forms.ebcode AS Cluster,
	clusters.district,
	forms.hh01 AS FormDate,
	COUNT ( * ) AS Synced 
FROM
	forms
	left JOIN clusters ON forms.ebCode = clusters.cluster_no AND (clusters.colflag is null OR clusters.colflag = '0')
WHERE (forms.colflag is null OR forms.colflag = '0') 
	  $dist_where
GROUP BY
	forms.ebcode,
	clusters.district,
	forms.hh01 
ORDER BY
	forms.hh01 DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getHouseholdSurvey($cluster, $formDate)
    {
        $sql_query = "SELECT
	hhno
FROM
	[dbo].[forms]
WHERE
	ebCode = '" . $cluster . "'
AND formdate LIKE  '" . $formDate . "%' 
 AND (forms.colflag is null OR forms.colflag = '0')   ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}