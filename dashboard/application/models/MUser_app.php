<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MUser_app extends CI_Model
{
    function getAllUserApp()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('enabled', 1);
        $this->db->order_By('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getEditUser($idUser)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $idUser);
        $query = $this->db->get();
        return $query->result();
    }

    function checkUsername($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getAppUserByDist($dist_id)
    {
        if (isset($dist_id) && $dist_id != '') {
            $this->db->where("district_code like  '" . $dist_id . "%' ");
        }
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('enabled', 1);
        $this->db->order_By('username', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}