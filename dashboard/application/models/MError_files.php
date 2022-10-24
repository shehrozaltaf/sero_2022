<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MError_files extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getError_Files($dist)
    {
        $this->db->select("*");
        $this->db->from('error_files');
//        $this->db->where('dist_id', $dist);
        $this->db->where('isActive', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

}