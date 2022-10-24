<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Check_Session extends CI_controller
{

    function checkSession(){
        if (isset($_SESSION['login']['idUser'])) {
            echo 1;
        }else{
            echo 2;
        }
    }

}

?>