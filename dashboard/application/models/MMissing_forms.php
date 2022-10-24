<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MMissing_forms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getData()
    {
        $sql = "SELECT
	MAX (c.sysdate) AS sysdate,
	MAX (c.cluster_code) AS cluster,
	MAX (c.hhno) AS hhno,
	MAX (c.tagid) AS tagid,
	MAX (c.appversion) AS appversion,
	MAX (u.full_name) AS datacollector
FROM
	child_table AS c
LEFT OUTER JOIN forms AS f ON c._uuid = f._uid
AND c.sysdate = f.sysdate
LEFT OUTER JOIN users AS u ON c.username = u.username
WHERE
	(f._uid IS NULL)
AND (
	c.colflag IS NULL
	OR c.colflag = '0'
)
AND (c.cstatus <> '')
AND (
	LEFT (c.cluster_code, 1) <> '9'
)
GROUP BY
	c._uuid,
	c.sysdate";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
