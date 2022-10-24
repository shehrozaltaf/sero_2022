<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MSkipQuestions extends CI_Model
{
    function getFormData()
    {
        $sql_query = "SELECT
	sq.username,
	sq.total,
	(
		hh15 + hh18 + hh20 + ss04 + ss07 + ss09 + ss11 + ss22 + ss24
	) / 9 AS SkipPecentage,
	sq.hh15,
	sq.hh18,
	sq.hh20,
	sq.ss04,
	sq.ss07,
	sq.ss09,
	sq.ss11,
	sq.ss22,
	sq.ss24
FROM
	forms_sq sq";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getChildData()
    {
        $sql_query = "SELECT
	sq.username,
	sq.total,
	(
		IM01 + IM02 +  IM08 + IM10 + IM14 + IM16 + IM18 + IM21 + IM23
	) / 10 AS SkipPecentage,
	sq.IM01,
	sq.IM02,
	 
	sq.IM08,
	sq.IM10,
	sq.IM14,
	sq.IM16,
	sq.IM18,
	sq.IM21,
	sq.IM23
FROM
	child_table_sq sq";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}