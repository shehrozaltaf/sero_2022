<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MLogin extends CI_Model
{
    public $Modal;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->Modal = new Custom();
    }

    function validate($user, $pass)
    {
        $this->db->select('*');
        $this->db->from('users_dash');
        $this->db->where("(username ='" . $user . "' or email = '" . $user . "')");
        $this->db->where('status', 1);
//        $this->db->where('password', $pass);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    function ForgetPass($email)
    {
        $this->db->select('*');
        $this->db->from('users_dash');
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    function updateUserPassword($idUser, $newPassword)
    {
        $pramArray = array();
        $pramArray['password'] = $newPassword;
        $pramArray['passwordenc'] = hash('sha256', $newPassword);
        $result = $this->Modal->Edit($pramArray, 'idUser', $idUser, 'user');
        if ($result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    function ChkOldPassword($id, $Password)
    {
        $query = "select password,passwordenc from user where idUser='$id' and password='$Password'";
        return $this->Modal->selectAll($query);
    }

    function changeUserPassword($idPerson, $newPassword)
    {
        $pramArray = array();
        $pramArray['password'] = $newPassword;
        $pramArray['passwordenc'] = hash('sha256', $newPassword);
        $result = $this->Modal->Edit($pramArray, 'idUser', $idPerson, 'user');
        if ($result) {
            echo 1;
        } else {
            echo 2;
        }
    }
}